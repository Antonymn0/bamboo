<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\Company\CompanyRegistrationController;
use App\Http\Controllers\Web\PrintPDF;
use App\Helpers\Formulas;
use App\Helpers\GeneratePDF;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('dashboard');
    /*return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);*/
});

Route::middleware(['auth', 'verified','reg.active', 'isCompanyRegistrationComplete'])->group(function () {
    Route::get('dashboard',[DashboardController::class,'dashboard'])->name('dashboard');
    Route::get('employees',[DashboardController::class,'employees'])->name('employees');
    Route::get('profile/{username?}',[DashboardController::class,'profile'])->name('profile');
    
    Route::get('reports',[DashboardController::class,'reports'])->name('reports');
    Route::get('preferences',[DashboardController::class,'preferences'])->name('preferences');
    Route::get('notifications',[DashboardController::class,'notifications'])->name('notifications');
    
    Route::get('onboard/{username?}',[DashboardController::class,'onboard'])->name('onboard');
    Route::get('onboard/step-two/{username}',[DashboardController::class,'onboard_step_two'])->name('onboard.step.two');
    Route::get('onboard/step-three/{username}',[DashboardController::class,'onboard_step_three'])->name('onboard.step.three');
    Route::get('onboard/step-four/{username}',[DashboardController::class,'onboard_step_four'])->name('onboard.step.four');

    Route::get('open/task/{task}',[DashboardController::class,'open_task'])->name('open.task');
    
    //Route::get('update/task/{task}',[DashboardController::class,'update_task'])->name('update.task');

    /*Route::get('newuser/basic-details/{username}',[DashboardController::class,'newuser_basic_details'])->name('newuser.basic.details');
    Route::get('newuser/address-details/{username}',[DashboardController::class,'newuser_address_details'])->name('newuser.address.details');
    Route::get('newuser/education-details/{username}',[DashboardController::class,'newuser_education_details'])->name('newuser.education.details');
    Route::get('newuser/work-details/{username}',[DashboardController::class,'newuser_work_details'])->name('newuser.work.details');
    Route::get('newuser/other-details/{username}',[DashboardController::class,'newuser_other_details'])->name('newuser.other.details');
    Route::get('newuser/dependants-details/{username}',[DashboardController::class,'newuser_dependants_details'])->name('newuser.dependants.details');
    Route::get('newuser/beneficiaries-details/{username}',[DashboardController::class,'newuser_beneficiaries_details'])->name('newuser.beneficiaries.details');
    Route::get('newuser/emergency-details/{username}',[DashboardController::class,'newuser_emergency_details'])->name('newuser.emergency.details');
    Route::get('newuser/payment-details/{username}',[DashboardController::class,'newuser_payment_details'])->name('newuser.payment.details');

    Route::get('employee/return/{user}',[DashboardController::class,'return_to_employee'])->name('employee.return');*/

    Route::get('verify/employee-biodata/{username}/{task}',[DashboardController::class,'verify_employee_biodata'])->name('verify.employee.biodata');
    Route::get('verify/education/{username}/{task}',[DashboardController::class,'verify_education'])->name('verify.education');
    Route::get('verify/contact-referees/{username}/{task}',[DashboardController::class,'verify_contact_referees'])->name('verify.contact.referees');
    Route::get('verify/assign-assets/{username}/{task}',[DashboardController::class,'assign_assets'])->name('verify.assign.assets');
    //Route::get('verify/employee-orientation/{username}/{task}',[DashboardController::class,'verify_employee_orientation'])->name('verify.employee.orientation');

    Route::get('user/profile-inactive/{username}',[DashboardController::class,'user_profile_inactive'])->name('user.profile.inactive');
    Route::get('activate-employee/{username}',[DashboardController::class,'activate_employee'])->name('activate.employee');

});

Route::middleware(['auth', 'verified'])->group(function () {
    //employee registration
    Route::get('employee/registration/{username}',[DashboardController::class,'employee_registration'])->name('employee.registration');
    Route::get('employee/submit/{username}',[DashboardController::class,'employee_submit'])->name('employee.submit');
});

  
Route::middleware(['auth', 'verified','userCanEditCompany'])->group(function () {
    //Company registration routes 
    Route::get('/company/registration/basic-info/{username}',[CompanyRegistrationController::class,'companyRegistrationBasicInfo'])->name('company.registration.basic-info');
    Route::get('/company/registration/contacts/{username}',[CompanyRegistrationController::class,'companyRegistrationContacts'])->name('company.registration.contacts');
    Route::get('/company/registration/operations/{username}',[CompanyRegistrationController::class,'companyRegistrationOperations'])->name('company.registration.operations');
    Route::get('/company/registration/other-details/{username}',[CompanyRegistrationController::class,'companyRegistrationOtherdetails'])->name('company.registration.other-details');
    Route::get('/company/registration/set-departments/{username}',[CompanyRegistrationController::class,'companyRegistrationSetDepartments'])->name('company.registration.set-departments');
    Route::get('/company/registration/upload-logo/{username}',[CompanyRegistrationController::class,'companyRegistrationUploadLogo'])->name('company.registration.upload-logo');
    Route::get('/company/registration/subscription/{username}',[CompanyRegistrationController::class,'companyRegistrationSubscription'])->name('company.registration.subscription');
    // Route::get('/company/registration/finish-setup/{username}',[CompanyRegistrationController::class,'companyRegistrationfinishSetup'])->name('company.registration.finish-setup');
    Route::get('/company/update/time-tracking/{username}',[CompanyRegistrationController::class,'companyRegistrationTimeTracking'])->name('company.registration.time.tracking');
});

Route::middleware(['auth'])->group(function () {
    //Payroll routes 
    Route::get('/payroll','App\Http\Controllers\Web\Payroll\PayrollController@getPayrolls')->name('payroll');
    Route::get('/payroll/create/period','App\Http\Controllers\Web\Payroll\PayrollController@showPeriodForm')->name('payroll.show.create.period.form');    
    Route::get('/payroll/create/employees/{payroll}','App\Http\Controllers\Web\Payroll\PayrollController@showSelectEmployeesForm')->name('payroll.show.create.employees.form');
    Route::get('/edit/payroll/{payroll}','App\Http\Controllers\Web\Payroll\PayrollController@showEditPayrollForm')->name('payroll.show.edit.form');
    Route::get('/payroll/update/employees/{payroll}','App\Http\Controllers\Web\Payroll\PayrollController@showEditPayrollEmployeesForm')->name('payroll.show.edit.employees.form');
    
});

Route::middleware(['auth'])->group(function () {
    //Offboard user routes routes 
    Route::get('/employee/offboard/{user}','App\Http\Controllers\Api\Employee\EmployeeController@offboardEmployee')->name('offboard.user');
    Route::get('/employee/offboard/show-finish/{user}','App\Http\Controllers\Api\Employee\EmployeeController@showFinishOffboardingEmployee')->name('show.finish.offboarding.user');
    Route::get('/employee/offboard/process/{user}','App\Http\Controllers\Api\Employee\EmployeeController@processOffboardingEmployee')->name('process.offboarding.user');
});
Route::middleware(['auth'])->group(function () {
    //Preferences routes routes 
    Route::get('/preferences/time-tracking','App\Http\Controllers\Web\Preferences\PreferencesController@showTimetrackingForm')->name('preferences.time-tracking');
    Route::get('/preferences/company-details','App\Http\Controllers\Web\Preferences\PreferencesController@showCompanyDetailsForm')->name('preferences.company-details');
    Route::get('/preferences/company-details/departments','App\Http\Controllers\Web\Preferences\PreferencesController@showDepartmentsForm')->name('preferences.company-details.departments');
    Route::get('/preferences/company/subscription','App\Http\Controllers\Web\Preferences\PreferencesController@showsubscriptionForm')->name('preferences.company.subscription');
    
    Route::get('/preferences/logo-and-color','App\Http\Controllers\Web\Preferences\PreferencesController@showLogoColorForm')->name('logo.and.color'); 
    Route::get('/preferences/compnay details/leave-otions','App\Http\Controllers\Web\Preferences\PreferencesController@showCompanyDetailsLeaveOptionsForm')->name('set.leave.options'); 
    Route::get('/preferences/set/leave-options','App\Http\Controllers\Web\Preferences\PreferencesController@showSetLeaveOtionsForm')->name('leave.options'); 
    Route::get('/preferences/set/payroll-cycle','App\Http\Controllers\Web\Preferences\PreferencesController@showSetPayrollCycleOptionsForm')->name('set.payroll.cycle'); 
    
    //account status
    Route::get('/account-status','App\Http\Controllers\Web\Preferences\PreferencesController@showAccountStatusForm')->name('account.status'); 
});

Route::middleware(['auth'])->group(function () {
    //User Leave routes
    Route::get('/leave/edit/{leave}','App\Http\Controllers\Web\Leave\LeaveController@showEditLeaveForm')->name('show.edit.leave.form'); 
    Route::get('/leave/show-form', 'App\Http\Controllers\Web\Leave\LeaveController@showApplyLeaveForm')->name('leave.show.apply-form');
    
    Route::get('/admin/leave/approvals/{username}', 'App\Http\Controllers\Web\Admin\LeaveController@showLeavesPage')->name('admin.leave.approvals.page');
    Route::get('/admin/leave/show-approve-form/{leave}', 'App\Http\Controllers\Web\Admin\LeaveController@showapproveLeaveform')->name('admin.leave.show.approve-form');
 });



Route::middleware(['auth'])->group(function () {
    //Change password routes
    Route::get('/change/password', 'App\Http\Controllers\Auth\NewPasswordController@showChangePasswordForm')->name('user.change.password'); 
    
    //Notifications
    Route::get('/prefferences/notifications', 'App\Http\Controllers\Web\Preferences\PreferencesController@showNotificationView')->name('preferences.notifications'); 



});

Route::middleware(['auth'])->group(function () {
    //preferences loans routes
    Route::get('/company/loans', 'App\Http\Controllers\Web\Preferences\PreferencesController@showLoansForm')->name('loans'); 
    Route::post('/store/loans', 'App\Http\Controllers\Web\Preferences\LoanController@storeLoan')->name('loans.post'); 
    Route::get('/get/loans/{company}', 'App\Http\Controllers\Web\Preferences\LoanController@fetchLoanRecord')->name('loans.get.record'); 
    Route::get('/loan/delete/{loan}', 'App\Http\Controllers\Web\Preferences\LoanController@deleteLoanRecord')->name('loans.delete.record'); 
});

Route::middleware(['auth'])->group(function () {
    // employee assets
    Route::get('/company/assets', 'App\Http\Controllers\Api\Assets\AssetsController@showAssetsForm')->name('employee.assets.form'); 
    Route::get('/company/assets/new', 'App\Http\Controllers\Api\Assets\AssetsController@showAddAssetsForm')->name('add.new.asset'); 
    Route::get('/company/assets/edit/{asset}', 'App\Http\Controllers\Api\Assets\AssetsController@showEditAssetsForm')->name('edit.asset');

    // /Company benefits routes
    Route::get('/company/benefits', 'App\Http\Controllers\Api\Benefits\CompanyBenefitsController@showBenefitsForm')->name('company.benefits');
    
   
});


Route::get('/test-pdf', function () {
    return GeneratePDF:: generateUserSubmitedDataPDF(2);
});



Route::get('/test',function(){
    return Formulas::flatRate(150000,0.05,18);
});

Route::get('/job',function(){
    return Formulas::getTotalCashPay(1);
});

Route::get('/payslip',function(){
    $pdf = GeneratePDF::generatePayslipPDF(1);
    return $pdf->stream();
})->name('test.payslip');

require __DIR__.'/auth.php';
require __DIR__.'/Setting/settings.php';
