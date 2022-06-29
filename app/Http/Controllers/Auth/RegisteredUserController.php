<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Company;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use App\Helpers\PageSettings;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use App\Helpers\Utilities;
use Inertia\Inertia;
use App\Jobs\CreateRoleAssignUser;
use Spatie\Permission\Models\Role;
use App\Events\UserRegistered;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Inertia\Response
     */
    public function create()
    {
        $data = PageSettings::register();
        return Inertia::render('Auth/Register',$data);
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|unique:users',
            'company_name' => 'required|string|max:255',
            'company_address' => 'nullable|string|max:255',
            'lat' => 'nullable',
            'lng' => 'nullable',
            'country' => 'nullable',
            'postal_code' => 'nullable',
            'physical_address' => 'nullable',
            'password' => ['required', 'confirmed'],
        ]);

        $companyData = $request->only(['company_address','lat','lng','country','postal_code','physical_address']); 
        $companyName = $request->company_name;
        $companySlug = isset($companyName) ? Utilities::getCompanySlug($companyName) : Utilities::getCompanySlug('company');

        //create company
        $company = Company::updateOrCreate(['company_name' => $companyName,'slug'=>$companySlug]);
        
        //create or update company meta
        foreach ($companyData as $key => $value):
            $meta = $company->meta()->where('key',$key)->first();
            $data = ['key' => $key, 'value' => $value,'verified_at'=>now()];
            if( $meta ) $meta->update($data);
            else $meta = $company->meta()->create($data);
        endforeach;

        $userData = $request->only(['first_name','last_name','email','phone','password']);
        $userData['password'] = Hash::make($userData['password']);
        $userData['phone'] = Utilities::cleanPhoneNumber( $userData['phone'], '254' );
        $userData['username'] = isset($userData['first_name']) ? Utilities::getUsername($userData['first_name']) : Utilities::getUsername('user');
        $userData['surname'] = $userData['last_name'];
        $userData['reg_status'] = 0;
        $userData['status'] = 0;

        $user = $company->users()->create($userData);

        $role = Role::where('name','admin')->first();
        if( ! $role )
            CreateRoleAssignUser::dispatch('admin',$user);
        else 
            $user->assignRole($role); 

        event(new UserRegistered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
