<?php

namespace App\Helpers;

use App\Models\User;
use App\Models\Task;
use App\Models\Media;
use App\Models\Company;
use App\Models\Department;
use App\Models\Subscription;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Storage;

class Utilities
{
    /**
    *Format phone numbers to country code first
    *@param number,string $phone $prefix
    *@return string $phone
    **/
    public static function cleanPhoneNumber( $num, $prefix = '254' )
    {
        $phone = strval( $num );
        $prefix = strval( $prefix );

        $phone = str_replace( '+', '', $phone );
        $phone = str_replace( ' ', '', $phone );
        $phone = str_replace( $prefix, '0', $phone );

        $phone = preg_replace( '/^0/', '', $phone );

        if( ! is_numeric($phone) ) return $num;

        $phone = $prefix.$phone ;
        return $phone;
    }

    public static function createNamesFromFullName( $validated = [] )
    {
      $names = isset( $validated['full_name'] ) ? explode(" ",$validated['full_name']) : null;
      $validated['first_name'] = isset($names[0]) ? $names[0] : 'user';
      $validated['middle_name'] = isset($names[1]) && isset($names[2]) ?  $names[1] : null;
      if( isset($names[1]) && isset($names[2]) ) $validated['last_name'] = $names[2];
      else if( isset($names[1]) && ! isset($names[2]) ) $validated['last_name'] = $names[1];
      else if( ! isset($names[1]) && isset($names[2]) ) $validated['last_name'] = $names[2];
      else $validated['last_name'] = null;

      $other_names = '';

      for( $x = 0; $x < count($names); $x++ )
      {
        if( $x <= 2 ) continue;

        $other_names .=$names[$x].' ';

      }

      if( $other_names ) $validated['other_names'] = $other_names;

      return $validated;
    }

    public static function getCompanySlug($name)
    {
      if( Company::where('slug',$name)->count() )
        return self::suggestCompanySlug($name)[0];
      return Str::slug($name,'-');
    }

    public static function getDepartmentSlug($name)
    {
      if( Department::where('slug',$name)->count() )
        return self::suggestDepartmentSlug($name)[0];
      return Str::slug($name,'-');
    }

    public static function getUsername($name)
    {
      if( User::where('username',$name)->count() )
        return self::suggestUsername($name)[0];
      return Str::slug($name,'-');
    }

    public static function getTaskSlug($name)
    {
      if( Task::where('slug',$name)->count() )
        return self::suggestTaskSlug($name)[0];
      return Str::slug($name,'-');
    }

    public static function getSubscriptionSlug($name)
    {
      if( Subscription::where('slug',$name)->count() )
        return self::suggestSubscriptionSlug($name)[0];
      return Str::slug($name,'-');
    }

    public static function suggestUsername( $username )
    {
      $suggestions = [];

      while ( count($suggestions) < 3 )
      {
        $randomNum = rand(10,1000);
        $user = User::where('username',$username.$randomNum )->first();
        if( !$user )
          $suggestions [] = $username.$randomNum;
      }

      return $suggestions;
    }

    public static function suggestCompanySlug( $slug )
    {
      $suggestions = [];

      while ( count($suggestions) < 3 )
      {
        $randomNum = rand(10,1000);
        $company = Company::where('slug',$slug.$randomNum )->first();
        if( !$company )
          $suggestions [] = $slug.$randomNum;
      }

      return $suggestions;
    }

    public static function suggestSubscriptionSlug( $slug )
    {
      $suggestions = [];

      while ( count($suggestions) < 3 )
      {
        $randomNum = rand(10,1000);
        $subscription = Subscription::where('slug',$slug.$randomNum )->first();
        if( !$subscription )
          $suggestions [] = $slug.$randomNum;
      }

      return $suggestions;
    }

    public static function suggestTaskSlug( $slug )
    {
      $suggestions = [];

      while ( count($suggestions) < 3 )
      {
        $randomNum = rand(10,1000);
        $task = Task::where('slug',$slug.$randomNum )->first();
        if( !$task )
          $suggestions [] = $slug.$randomNum;
      }

      return $suggestions;
    }

    public static function suggestDepartmentSlug( $slug )
    {
      $suggestions = [];

      while ( count($suggestions) < 3 )
      {
        $randomNum = rand(10,1000);
        $department = Department::where('slug',$slug.$randomNum )->first();
        if( !$department )
          $suggestions [] = $slug.$randomNum;
      }

      return $suggestions;
    }

    public static function userCan($permission, User $user)
    {
      if( ! Permission::where('name',$permission)->count() ) return true;
      return $user->hasPermissionTo($permission);
    }

    public static function getAtleastOneDepartment()
    {
      $departments = Department::pluck('slug');

      if( count($departments) )
        return $departments;

      $name = env('DEAULT_DEPARTMENT_NAME','hr');

      Department::create(['name'=>$name,'slug'=>self::getDepartmentSlug($name)]);

      return Department::pluck('slug');

    }

    public static function getUserPaymentModes(User $user)
    {
      return [
            'preffered_mode'      =>    $user->meta()->where('key','preffered_mode')->value('value'), 
            'mobile_number'     =>    $user->meta()->where('key','mobile_number')->value('value'), 
            'bank_name'     =>    $user->meta()->where('key','bank_name')->value('value'), 
            'bank_branch'     =>    $user->meta()->where('key','bank_branch')->value('value'), 
            'bank_branch_code'     =>    $user->meta()->where('key','bank_branch_code')->value('value'), 
            'bank_acc_name'     =>    $user->meta()->where('key','bank_acc_name')->value('value'), 
            'bank_acc_no'     =>    $user->meta()->where('key','bank_acc_no')->value('value'), 
            'bank_account_with'     =>    $user->meta()->where('key','bank_account_with')->value('value'), 
            'microfinance_name'     =>    $user->meta()->where('key','microfinance_name')->value('value'), 
            'microfinance_acc_no'     =>    $user->meta()->where('key','microfinance_acc_no')->value('value'),
            'sacco_name'     =>    $user->meta()->where('key','sacco_name')->value('value'), 
            'sacco_acc_no'     =>    $user->meta()->where('key','sacco_acc_no')->value('value'), 

      ];
    }

    public static function storeMediaFiles(Request $request,$filename,$disk='public')
    {
         if( ! $request->hasFile($filename) ) return false;
         $media = [];
         if ( is_array( $request->file($filename) ) )
            foreach( $request->file($filename) as $file )
             $media[] = self::storeMediaFile($file, $disk);
         else 
            $media[]= self::storeMediaFile($request->file($filename), $disk);
        return $media;
    }

    public static function storeMediaFile( $name = null , $purpose = null ,$file,$mediaable_id, $mediaable_type, $disk="public")
    {
          //$name =  time();//$name ? $name.'.'.$file->getClientOriginalExtension() : $file->getClientOriginalName();
          $fname = time().'.'.$file->getClientOriginalExtension();
          $dt = now();
          $dir = $dt->year.'/'.$dt->month;
          $path = $file->storeAs($dir, $fname, $disk);
          $size = $file->getSize();
          $store_path =  'storage/'.$path;
          $public_uri = url($store_path);

         // $img = Image::make($store_path);
          //$img->insert('images/watermark.png','center');
          //$img->save();


          return Media::create([
            'name' => $name,
            'path' => $path,
            'public_uri' => $public_uri,
            'size' => $size,
            'purpose' => $purpose,
            'mediaable_id' => $mediaable_id, 
            'mediaable_type' => $mediaable_type
          ]);
    }

    public static function destroyMedia(Media $media,$disk="public")
    {
      Storage::disk($disk)->delete($media->path);
      return $media->delete();
    }

    public static function getSubscriptionPackages($company)
    {
      $packages = Subscription::limit(env('PAGINATE_SIZE',10))->get();

      if( ! count($packages) )
        $packages[] = $company->subscriptions()->create([
          'name' => 'Free Trial',
          'slug' => 'free-trial',
          'price' => 0, 
          'max_employees' => env('MAX_EMPLOYEES_FREE_PLAN',10)
        ]);

      return $packages;
    }

}