<?php

namespace App\Http\Controllers\Api\Users;

use App\Models\User;
use App\Models\Company;
use App\Models\UserMeta;
use App\Helpers\Utilities;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Schema;
use App\Events\EmployeeActivated;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function user_meta(Request $request, User $user)
    {
        $category = $request->category;
        $per_page = $request->per_page ? $request->per_page : env('PAGINATE_SIZE',10);
        return $user->meta()
                            ->when($category,function($query) use ($category){
                                $query->where('category',$category);
                            })
                            ->paginate($per_page);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Patch the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function patch(Request $request, User $user)
    {
        $request->validate([
            'field' => 'required|string|max:255',
            'value' => 'nullable',
            'type' => 'nullable|string',
            'category' => 'nullable|string',
        ]);

        $value = $request->value;
        $field = $request->field;
        $category = $request->category;

        if( $request->type == 'current_time' ) 
            if(  $value ) $value = now();
            else $value = null;


        if( $request->type == 'phone' || $request->field == 'phone' && $value ) $value = Utilities::cleanPhoneNumber( $value, '254' );
        
       
        if ( Schema::hasColumn('users', $field ) ) 
                $user->update([
                    $field => $value
                ]);
        else if( $field != 'id' ) {
            $meta = $user->meta()->where('key',$field)->first();
            $data = ['key' => $field, 'value' => $value, 'category' => $category];
            if( $meta ) 
                if( $request->type == 'current_time' )
                        $meta->update([
                        'verified_at' => $value
                    ]);
                else 
                    $meta->update([
                        'value' => $value
                    ]);

            else $meta = $user->meta()->create($data);
        }

        return $user->refresh();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }

    /**
     * Check if record exists in the resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function record_exists(Request $request)
    {
        $request->validate([
            'field' => 'required',
            'value' => 'required',
            'id' => 'nullable|numeric'
        ]);

        $field = $request->field;
        $value = $field == 'phone' ? Utilities::cleanPhoneNumber( $request->value, '254' )  : $request->value;
        $id = $request->id;
        
        return User::when($id, function ($query) use ( $id ) {
                            return $query->where('id','<>', $id);
                        })
                    ->where($field,$value)->count();
    }

    public function search(Request $request)
    {
        $request->validate([
            'string' => 'string|nullable|max:255',
            'company_id' => 'numeric|required'
        ]);

        $string = $request->string;
        $limit = $request->limit ? $request->limit : env('PAGINATE_SIZE',10);

        $company = Company::find($request->company_id);

        if( ! $company ) return [];

        return $company->users()/*->when($string,function($query) use ($string) {
                            $query
                                    ->orWhere('first_name','like','%'.$string.'%')
                                    ->orWhere('last_name','like','%'.$string.'%')
                                    ->orWhere('username','like','%'.$string.'%')
                                    ->orWhere('email','like','%'.$string.'%')
                                    ->orWhere('phone','like','%'.$string.'%');
                        })*/
                        ->where('reg_status',0)
                        ->where(function($query) use ($string) {
                            $query
                            ->where('first_name','like','%'.$string.'%')
                            ->orWhere('last_name','like','%'.$string.'%')
                            ->orWhere('username','like','%'.$string.'%')
                            ->orWhere('email','like','%'.$string.'%')
                            ->orWhere('phone','like','%'.$string.'%');
                        })
                        ->paginate($limit);
    }

    public function meta_record_exists(Request $request)
    {
        $request->validate([
            'field' => 'required',
            'value' => 'required',
            'id' => 'nullable|numeric'
        ]);

        $field = $request->field;
        $value = $field == 'phone' ? Utilities::cleanPhoneNumber( $request->value, '254' )  : $request->value;
        $id = $request->id;

        return UserMeta::when($id, function ($query) use ( $id ) {
                            return $query->where('user_id', '<>' ,$id);
                        })->where('key',$field)->where('value',$value)->count();
        
        /*return User::when($id, function ($query) use ( $id ) {
                            return $query->where('id','<>', $id);
                        })
                    ->where($field,$value)->count();*/

        //check if meta key exist
    }

    public function activate(Request $request, User $user)
    {
        $request->validate([
            'activated_by' => 'required|numeric',
        ]);

        $randomPassword = Str::random(6);
        $password = Hash::make($randomPassword);

        $user->update([
            'activated_by' => $request->activated_by,
            'reg_status' => 0,
            'status' => 0,
            'password' => $password
        ]);

        //fire event
        event(new EmployeeActivated($user,$randomPassword));

        return $user;
    }

    public function get_subordinates(Request $request, User $user)
    {
        if( ! $user ) return [];

        $per_page = $request->per_page ? $request->per_page : env('PAGINATE_SIZE',10);

        return User::where('reports_to',$user->id)->paginate($per_page);
    }

    public function pluck( Request $request, User $user )
    {
        $request->validate([
            'field' => 'required|max:255'
        ]);

        switch ($request->field) {
            case 'avatar':
                $avatar = $user->media()->where('purpose','avatar')->orderBy('created_at','DESC')->first();
                return $avatar ? $avatar->public_uri : '';
            break;

            case 'referees':
                return $user->referees;
            break;
            
            default:
            break;
        }
    }
}
