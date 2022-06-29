<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\PageSettings;
use App\Helpers\Utilities;
use Inertia\Inertia;
use App\Models\User;
use App\Models\Task;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Notifications\User\RegistrationDetailsReceived;
use App\Notifications\User\RegistrationDetailsSubmitted;
use App\Notifications\User\RegistrationProgress;
use App\Notifications\User\RegistrationCorrections;
use App\Models\Payroll;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $data = PageSettings::dashboard();
        $data['user'] = User::with(['company'])->where('id', Auth::id())->first();       

        return Inertia::render('Dashboard', $data);
    }

    public function employees()
    {
        $data = PageSettings::employees();
        //$data['employees'] = User::role('employee')->with(['department','meta'])->paginate(env('PAGINATE_SIZE',10));
        return Inertia::render('Employees/Employees', $data);
    }

    public function profile(Request $request, $username = null)
    {
        $username = $username ? $username : Auth::user()->username;
        $data = PageSettings::profile();
        $user = User::with(['department', 'benefits', 'assets','supervisor', 'meta', 'education', 'certifications', 'work_experiences', 'languages', 'dependants', 'beneficiaries', 'emergency_contacts', 'referees'])->where('username', $username)->first();

        if ($user->reg_status != 0)
            return redirect()->route('user.profile.inactive', $user->username);


        $data['user'] = $user;
        $data['formFields'] = PageSettings::form_fields('basic_details', $user);
        $data['addressFormFields'] = PageSettings::form_fields('address', $user);
        $data['assetFormFields'] = PageSettings::form_fields('assign_assets', $user);
        $data['permissions'] = Auth::user()->getAllPermissions()->pluck('name');
        $data['activeTab'] = $request->active ? $request->active : '1';

        return Inertia::render('Profile', $data);
    }

    public function user_profile_inactive($username)
    {
        if (is_null($username)) return redirect()->route('employees')->with('error', 'An error occured, please try again later');

        $data = PageSettings::user_profile_inactive();

        $user = User::where('username', $username)->first();

        if ($user->reg_status == 0)
            return redirect()->route('profile', $user->username);

        $data['user'] = $user;

        $data['permissions'] = Auth::user()->getAllPermissions()->pluck('name');

        return Inertia::render('ProfileInactive', $data);
    }

    public function payroll()
    {
        $data = PageSettings::payroll();
        $data['user'] = User::with(['company'])->where('id', Auth::id())->first(); 
        $data['payrolls'] = Payroll::where('company_id', Auth::user()->company_id)
                            ->orderBy('created_at', 'desc')->get();      
        return Inertia::render('Payroll/Payroll', $data);
    }

    public function reports()
    {
        $data = PageSettings::reports();
        return Inertia::render('Reports', $data);
    }

    public function preferences(Request $request)
    {
        $data = PageSettings::preferences();
        $data['roles'] =  Role::with('permissions')->get();
        $data['permissions'] = Permission::all();
        $data['user_permissions'] =  $request->user()->getDirectPermissions();

        return Inertia::render('Preferences/components/AccessLevels', $data);
    }

    public function notifications()
    {
        $data = PageSettings::notifications();
        return Inertia::render('Notifications', $data);
    }

    public function onboard($username = null)
    {
        $user = $username ? User::with(['department'])->where('username', $username)->first() : [];

        $data = PageSettings::onboard();
        $data['formFields'] = PageSettings::form_fields('onboard_step_1');
        $data['newEmployee'] = $user;
        return Inertia::render('Onboard/StepOne', $data);
    }

    public function onboard_step_two($username)
    {
        $user = User::with(['department', 'meta', 'supervisor'])->where('username', $username)->first();

        if (!$user) return redirect()->route('onboard')->with('error', 'An error occured, please try again later');

        $data = PageSettings::onboard_step_two();
        $data['formFields'] = PageSettings::form_fields('onboard_step_2', $user);
        $data['newEmployee'] = $user;
        return Inertia::render('Onboard/StepTwo', $data);
    }

    public function onboard_step_three($username)
    {
        $user = User::with(['department'])->where('username', $username)->first();

        if (!$user) return redirect()->route('onboard')->with('error', 'An error occured, please try again later');

        $data = PageSettings::onboard_step_three();
        $data['formFields'] = PageSettings::form_fields('onboard_step_3', $user);
        $data['newEmployee'] = $user;
        return Inertia::render('Onboard/StepThree', $data);
    }

    public function onboard_step_four($username)
    {
        $user = User::with(['department'])->where('username', $username)->first();

        if (!$user) return redirect()->route('onboard')->with('error', 'An error occured, please try again later');

        $data = PageSettings::onboard_step_four();
        $data['formFields'] = PageSettings::form_fields('onboard_step_4');
        $data['newEmployee'] = $user;
        return Inertia::render('Onboard/StepFour', $data);
    }

    public function employee_registration(Request $request, $username)
    {
        $user = User::with(['department','meta', 'education', 'certifications', 'work_experiences', 'languages', 'dependants', 'beneficiaries', 'emergency_contacts', 'referees'])->where('username', $username)->first();

        if (!$user) return redirect()->route('home')->with('error', 'An error occured, please try again later');

        $data = PageSettings::employee_registration();
        $data['newEmployee'] = $user;


        switch ($request->step) {
            case '1':
                $data['formFields'] = PageSettings::form_fields('basic_details', $user);
                return Inertia::render('Registration/BasicDetails', $data);
                break;

            case '2':
                $data['formFields'] = PageSettings::form_fields('address', $user);
                return Inertia::render('Registration/AddressDetails', $data);
                break;

            case '3':
                $data['formFields'] = PageSettings::form_fields('education', $user);
                return Inertia::render('Registration/EducationDetails', $data);
                break;

            case '4':
                $data['formFields'] = PageSettings::form_fields('work', $user);
                return Inertia::render('Registration/WorkExperienceDetails', $data);
                break;

            case '5':
                $data['formFields'] = PageSettings::form_fields('dependants', $user);
                return Inertia::render('Registration/DependantsDetails', $data);
                break;

            case '6':
                $data['formFields'] = PageSettings::form_fields('beneficiaries', $user);
                return Inertia::render('Registration/BeneficiariesDetails', $data);
                break;

            case '7':
                $data['formFields'] = PageSettings::form_fields('emergency', $user);
                return Inertia::render('Registration/EmergencyDetails', $data);
                break;

            case '8':
                $data['formFields'] = PageSettings::form_fields('payment', $user);
                $data['payment'] = Utilities::getUserPaymentModes($user);
                return Inertia::render('Registration/PaymentDetails', $data);
                break;


            case '9':
                $data['avatar'] = $user->media()->where('purpose','avatar')->first();
                return Inertia::render('Registration/UploadPicture', $data);
                break;

            case '10':
                return Inertia::render('Registration/VerifyDetails', $data);
                break;

                    
            default:
                $data['formFields'] = PageSettings::form_fields('basic_details', $user);
                return Inertia::render('Registration/BasicDetails', $data);
                break;
        }
    }

    public function employee_submit(Request $request, $username)
    {
        $user = User::with(['department'])->where('username', $username)->first();

        if (!$user) return redirect()->route('home')->with('error', 'An error occured, please try again later');

        $task = Task::where('type', 'employee_onboarding')->where('type_id', $user->id)->first();

        if ($task) :
            $assignee = User::find($task->assigned_to);
            if ($assignee)
                $assignee->notify(new RegistrationDetailsReceived($assignee, $user));
        endif;

        if( $task )

            if ($task->assigned_to != $task->user_id) :
                $admin = User::find($task->user_id);
                if ($admin)
                    $admin->notify(new RegistrationProgress($admin, $user));
            endif;

        //change password
        $randomPassword = $this->get_temporary_password($user);

        $user->update(['reg_status' => 2]);

        $user->notify(new RegistrationDetailsSubmitted($user));


        //destroy session
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function open_task(Task $task)
    {
        session(['currentTaskID' => $task->id]);
        switch ($task->type) {
            case 'employee_onboarding':
                $newUser = User::find($task->type_id);
                return $newUser ? redirect()->route('newuser.basic.details', $newUser->username) : redirect()->route('dashboard');
                break;

            default:
                # code...
                break;
        }
    }

    /*public function update_task(Task $task)
    {
        session(['currentTaskID' => null]);

        return redirect()->route('dashboard');
    }*/

    /*public function newuser_basic_details($username)
    {
        $user = $username ? User::with(['department'])->where('username',$username)->first() : [];

        $data = PageSettings::newuser_basic_details();
        $data['newEmployee'] = $user;
        $data['permissions'] = Auth::user()->getAllPermissions()->pluck('name');
        $data['formFields'] = PageSettings::form_fields('basic_details');
        return Inertia::render('NewUser/BasicDetails',$data);
    }

    public function newuser_address_details($username)
    {
        $user = $username ? User::with(['department'])->where('username',$username)->first() : [];

        $data = PageSettings::newuser_address_details();
        $data['newEmployee'] = $user;
        $data['permissions'] = Auth::user()->getAllPermissions()->pluck('name');
        return Inertia::render('NewUser/AddressDetails',$data);
    }

    public function newuser_education_details($username)
    {
        $user = $username ? User::with(['department','education','certifications','languages'])->where('username',$username)->first() : [];

        $data = PageSettings::newuser_education_details();
        $data['newEmployee'] = $user;
        $data['permissions'] = Auth::user()->getAllPermissions()->pluck('name');
        return Inertia::render('NewUser/EducationDetails',$data);
    }

    public function newuser_work_details($username)
    {
        $user = $username ? User::with(['department','work_experiences','certifications','languages','referees'])->where('username',$username)->first() : [];

        $data = PageSettings::newuser_work_details();
        $data['newEmployee'] = $user;
        $data['permissions'] = Auth::user()->getAllPermissions()->pluck('name');
        return Inertia::render('NewUser/WorkDetails',$data);
    }


    public function newuser_other_details($username)
    {
        $user = $username ? User::with(['department','certifications','languages','dependants','beneficiaries','emergency_contacts','referees'])->where('username',$username)->first() : [];

        $data = PageSettings::newuser_other_details();
        $data['currentTaskID'] = session('currentTaskID');
        $data['newEmployee'] = $user;
        $data['permissions'] = Auth::user()->getAllPermissions()->pluck('name');
        return Inertia::render('NewUser/OtherDetails',$data);
    }

    public function newuser_dependants_details($username)
    {
        $user = $username ? User::with(['department','certifications','languages','dependants','beneficiaries','emergency_contacts','referees'])->where('username',$username)->first() : [];

        $data = PageSettings::newuser_dependants_details();
        $data['currentTaskID'] = session('currentTaskID');
        $data['newEmployee'] = $user;
        $data['permissions'] = Auth::user()->getAllPermissions()->pluck('name');
        return Inertia::render('NewUser/DependantsDetails',$data);
    }

    public function newuser_beneficiaries_details($username)
    {
        $user = $username ? User::with(['department','certifications','languages','dependants','beneficiaries','emergency_contacts','referees'])->where('username',$username)->first() : [];

        $data = PageSettings::newuser_beneficiaries_details();
        $data['currentTaskID'] = session('currentTaskID');
        $data['newEmployee'] = $user;
        $data['permissions'] = Auth::user()->getAllPermissions()->pluck('name');
        return Inertia::render('NewUser/BeneficiariesDetails',$data);
    }

    public function newuser_emergency_details($username)
    {
        $user = $username ? User::with(['department','certifications','languages','dependants','beneficiaries','emergency_contacts','referees'])->where('username',$username)->first() : [];

        $data = PageSettings::newuser_emergency_details();
        $data['currentTaskID'] = session('currentTaskID');
        $data['newEmployee'] = $user;
        $data['permissions'] = Auth::user()->getAllPermissions()->pluck('name');
        return Inertia::render('NewUser/EmergencyDetails',$data);
    }

    public function newuser_payment_details($username)
    {
        $user = $username ? User::with(['department','certifications','languages','dependants','beneficiaries','referees'])->where('username',$username)->first() : [];

        $data = PageSettings::newuser_payment_details();
        $data['currentTaskID'] = session('currentTaskID');
        $data['newEmployee'] = $user;
        $data['permissions'] = Auth::user()->getAllPermissions()->pluck('name');
        return Inertia::render('NewUser/PaymentDetails',$data);
    }*/

    /* public function return_to_employee(Request $request, $username)
    {
        $user = User::with(['department'])->where('username',$username)->first();

        if(  ! $user ) return redirect()->route('home')->with('error','An error occured, please try again later');

        $task = Task::where('type','employee_onboarding')->where('type_id',$user->id)->first();

        /*if( $task ):
             $assignee = User::find($task->assigned_to);
             $assignee->notify(new RegistrationDetailsReceived($assignee,$user));
        endif;

        if( $task->assigned_to != $task->user_id ):
            $admin = User::find($task->user_id);
            $admin->notify(new RegistrationProgress($admin,$user));
        endif;*/

    //change password
    /*$randomPassword = $this->get_temporary_password($user);

        $user->update(['reg_status' => 3]);

        $user->notify(new RegistrationCorrections($user,$randomPassword)); //inform employee to redo


       

        return redirect('/');
    }*/


    protected function get_temporary_password(User $user)
    {
        $randomPassword = Str::random(6);
        $password = Hash::make($randomPassword);
        $user->update(['password' => $password]);
        return $randomPassword;
    }

    public function verify_employee_biodata($username, Task $task)
    {
        $user = User::with(['department'])->where('username', $username)->first();

        if (!$user) return redirect()->route('home')->with('error', 'An error occured, please try again later');

        $data = PageSettings::verify_employee_biodata();
        $data['newEmployee'] = $user;
        $data['task'] = $task;
        return Inertia::render('Verify/BasicDetails', $data);
    }

    public function verify_education($username, Task $task)
    {
        $user = User::with(['department', 'education', 'certifications', 'languages'])->where('username', $username)->first();

        if (!$user) return redirect()->route('home')->with('error', 'An error occured, please try again later');

        $data = PageSettings::verify_education();
        $data['newEmployee'] = $user;
        $data['task'] = $task;
        return Inertia::render('Verify/Education', $data);
    }

    public function assign_assets($username, Task $task)
    {
        $user = User::with(['department', 'education', 'certifications', 'languages'])->where('username', $username)->first();

        if (!$user) return redirect()->route('home')->with('error', 'An error occured, please try again later');

        $data = PageSettings::assign_assets();
        $data['formFields'] = PageSettings::form_fields('assign_assets', $user);
        $data['newEmployee'] = $user;
        $data['task'] = $task;
        return Inertia::render('Verify/AssignAssets', $data);
    }

    public function activate_employee($username)
    {
        $user = User::where('username', $username)->first();

        if (!$user) return redirect()->route('home')->with('error', 'An error occured, please try again later');

        $data = PageSettings::activate_employee();
        $data['formFields'] = PageSettings::form_fields('activate_employee', $user);
        $data['newEmployee'] = $user;
        return Inertia::render('ActivateEmployee/AssignBenefits', $data);
    }
}
