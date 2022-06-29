<?php

namespace App\Http\Controllers\Api\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Department;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use App\Events\EmployeeRegistered;
use Illuminate\Support\Facades\Schema;
use App\Helpers\Utilities;
use App\Notifications\User\ContinueRegistration;

class OnboardController extends Controller
{
    public function onboard(Request $request, $step)
    {
        switch ($step) {
            case '1':
                return $this->stepOne($request);
            break;

            case '2':
                return $this->stepTwo($request);
            break;

            case '3':
                return null;//$this->stepTwo($request);
            break;

            case '4':
                return $this->stepFour($request);
            break;
            
            default:
                # code...
            break;
        }
    }

    public function stepOne(Request $request)
    {
        $id = $request->id;

        if( $user = User::find($id) ) return $this->updateStepOne($request, $user);

        $request->validate([
            'id' => 'numeric|nullable',
           /* 'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',*/
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|unique:users',
        ]);


        $randomPassword = Str::random(6);
        $userData = [];
        $userMetaData = [];
        $allData = $request->all();//$request->only(['first_name','last_name','email','phone']);
        
        //loop through all input
        foreach( $allData as $key => $value )
            if ( Schema::hasColumn('users', $key ) ) 
                $userData[$key] = $value;
            else if( $key != 'id' )
                $userMetaData[$key] = $value;

        //if not update user meta 
        $registrar = isset($userData['registered_by']) ? User::find($userData['registered_by']) : null;
        if( ! $registrar ) return;
        
        $userData['company_id'] = $registrar ? $registrar->company->id : null;

        $userData['password'] = Hash::make($randomPassword);
        $userData['username'] = isset($userData['first_name']) ? Utilities::getUsername($userData['first_name']) : Utilities::getUsername('user');
        $userData['email_verified_at'] = now();
        $userData['phone_verified_at'] = now();
        $userData['phone'] = $userData['phone'] ?  Utilities::cleanPhoneNumber( $userData['phone'], '254' ) : $userData['phone'];
        $userData['surname'] = $userData['last_name'] ? $userData['last_name'] : '';
        $userData['reg_status'] = 1;

        
        $user = User::create($userData);

         //create or update user meta
         self::storeMeta($userMetaData, $user);

        $role = Role::firstOrCreate(['name'=>'employee']);

        $user->assignRole($role);

        //event(new EmployeeRegistered($user));
        
        return $user;
    }


    public function updateStepOne(Request $request,User $user)
    {
        $request->validate([
            'id' => 'numeric|nullable',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'phone' => 'required|string',
        ]);

        if( $request->has('department_slug') ) 
            if( $deparment = Department::where('slug',$request->has('department_slug'))->first() )
                $this->addUserToDepartment( $user,$deparment->id );


        $userData = $request->only(['first_name','last_name','email','phone']);
        $userData['email_verified_at'] = now();
        $userData['phone_verified_at'] = now();
        $userData['phone'] = $userData['phone'] ?  Utilities::cleanPhoneNumber( $userData['phone'], '254' ) : $userData['phone'];
        $userData['surname'] = $userData['last_name'];

        
        $user->update($userData);

        return $user;
    }

    public static function stepTwo(Request $request)
    {

        $request->validate([
            'id' => 'numeric|required',
            /*'staff_id' => 'nullable|max:255',
            'department_id'=>'numeric|nullable',
            'contract_type'=>'nullable|max:255',
            'probation_period'=>'nullable|max:255',
            'employment_start_date'=>'nullable|date',
            'contract_start_date'=>'nullable|date',
            'contract_end_date'=>'nullable|date',
            'reporting_date' => 'nullable|date'*/
        ]);


        $id = $request->id;

        
        
        $user = User::find($id);
        
        if( $request->has('department_slug') ) 
            if( $deparment = Department::where('slug',$request->department_slug)->first() )
                self::addUserToDepartment( $user,$deparment->id );

        //$userData = $request->only(['staff_id','department_id','contract_type','probation_period','employment_start_date','contract_start_date','contract_end_date','reporting_date']);
        $userData = $request->except(['department_slug']);

        self::storeMeta($userData, $user);

        return $user->refresh();
    }

    public static function stepFour(Request $request)
    {
        $request->validate([
            'id' => 'numeric|required',
        ]);

        $id = $request->id;

        $user = User::find($id);

        $randomPassword = Str::random(6);
        $password = Hash::make($randomPassword);
        $user->update(['password' => $password]);
        return $user->notify(new ContinueRegistration($user,$randomPassword));

    }

    protected static function storeMeta($metaData, User $user)
    {
        foreach ($metaData as $key => $value):
            $meta = $user->meta()->where('key',$key)->first();
            $data = ['key' => $key, 'value' => $value,'category' => 'basic_details','verified_at'=>now()];
            if( $meta ) $meta->update($data);
            else $meta = $user->meta()->create($data);
        endforeach;
    }

    protected static function addUserToDepartment(User $user,$department_id)
    {
        return $user->update(['department_id' => $department_id]);
    }
}
