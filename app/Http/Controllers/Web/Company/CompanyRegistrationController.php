<?php

namespace App\Http\Controllers\Web\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Inertia\Inertia;
use App\Models\User;
use App\Helpers\Utilities;
use App\Helpers\Constants;

class CompanyRegistrationController extends Controller
{
    /**
     * |Handles company registration process
     * |All company registration links are handled here
     */

    /**
     * Show basic info step
     */
    public function companyRegistrationBasicInfo(Request $request, $username){
        $data=[];
        $user = User::with(['department'])->where('username',$username)->first();
        $data['user'] = $user;
        $data['company'] = $user->company;

        return Inertia::render('CompanyRegistration/Components/BasicInfo', $data);
    }

    /**
     * Show contacts step
     */
    public function companyRegistrationContacts(Request $request, $username){
        $data=[];
        $user = User::with(['department'])->where('username',$username)->first();
        $data['user'] = $user;
        $data['company'] = $user->company;

         return Inertia::render('CompanyRegistration/Components/Contacts', $data);
    }

    /**
     * Show contacts step
     */
    public function companyRegistrationOperations(Request $request, $username){
        $data=[];
        $user = User::with(['department'])->where('username',$username)->first();
        $data['user'] = $user;
        $data['company'] = $user->company;

        return Inertia::render('CompanyRegistration/Components/Operations', $data);
    }

    /**
     * Show other details  step
     */
    public function companyRegistrationOtherDetails(Request $request, $username){
        $data=[];
        $user = User::with(['department'])->where('username',$username)->first();
        $data['user'] = $user;
        $data['company'] = $user->company;

        return Inertia::render('CompanyRegistration/Components/OtherDetails', $data);
    }

    /**
     * Show set departments  step
     */
    public function companyRegistrationSetDepartments(Request $request, $username){
        $data=[];
        $user = User::with(['department'])->where('username',$username)->first();
        $data['user'] = $user;
        $data['company'] = $user->company;

        return Inertia::render('CompanyRegistration/Components/SetDepartments', $data);
    }

    /**
     * Show upload logo  step
     */
    public function companyRegistrationUploadLogo(Request $request, $username){
        $data=[];
        $user = User::with(['department'])->where('username',$username)->first();
        $company = $user->company;
        $data['user'] = $user;
        $data['company'] = $company;
        $data['logo'] = $company->media()->where('purpose','logo')->first();

        return Inertia::render('CompanyRegistration/Components/UploadLogo', $data);
    }

    /**
     * Show upload logo  step
     */
    public function companyRegistrationSubscription(Request $request, $username){
        $data=[];
        $user = User::with(['department'])->where('username',$username)->first();
        $data['user'] = $user;
        $data['company'] = $user->company;
        $data['packages'] = Utilities::getSubscriptionPackages($user->company);


        return Inertia::render('CompanyRegistration/Components/SubscriptionPayment', $data);
    }

  

    // /**
    //  * Finnish company step process
    //  */
    // public function companyRegistrationFinishSetup(Request $request, $username){
    //     $user = User::with(['department'])->where('username',$username)->first();        
    //     $company = $user->company;
        
    //     $company->update([ 'registration_status' => '0'   ]);

    //     return redirect()->route('dashboard');
    // }


}
