<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Users\UsersController;
use App\Http\Controllers\Api\Users\OnboardController;
use App\Http\Controllers\Api\Departments\DepartmentsController;
use App\Http\Controllers\Api\Tasks\TasksController;
use App\Http\Controllers\Api\Education\EducationController;
use App\Http\Controllers\Api\Certifications\CertificationsController;
use App\Http\Controllers\Api\WorkExperience\WorkExperienceController;
use App\Http\Controllers\Api\Languages\LanguagesController;
use App\Http\Controllers\Api\Dependants\DependantsController;
use App\Http\Controllers\Api\Beneficiaries\BeneficiariesController;
use App\Http\Controllers\Api\EmergencyContacts\EmergencyContactsController;
use App\Http\Controllers\Api\Referees\RefereesController;
use App\Http\Controllers\Api\Employee\EmployeeController;
use App\Http\Controllers\Api\Assets\AssetsController;
use App\Http\Controllers\Api\Benefits\BenefitsController;
use App\Http\Controllers\Api\Company\CompanyController;
use App\Http\Controllers\Api\Media\MediaController;
use App\Http\Controllers\Api\Subscription\SubscriptionController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('users/record-exists',[UsersController::class,'record_exists'])->name('users.record.exists');
Route::post('usermeta/exists',[UsersController::class,'meta_record_exists'])->name('usermeta.exists');

// Route::middleware(['auth','verified'])->group(function () {
//Route::middleware(['auth','verified'])->group(function () {
    Route::get('users/subordinates/{user}',[UsersController::class,'get_subordinates'])->name('user.subordinates');
    Route::patch('users/{user}',[UsersController::class,'patch'])->name('user.patch');
    Route::get('employee/attendance/{company}',[EmployeeController::class,'attendance']);
    Route::post('users/pluck/{user}',[UsersController::class,'pluck']);
    Route::put('user-activate/{user}',[UsersController::class,'activate'])->name('user.activate');
    Route::get('user-meta/{user}',[UsersController::class,'user_meta'])->name('user.meta');
    Route::post('onboard/{step}',[OnboardController::class,'onboard'])->name('onboard');
    Route::post('department/search',[DepartmentsController::class,'search'])->name('department.search');
    Route::post('users/search',[UsersController::class,'search'])->name('user.search');
    Route::patch('task-patch/{task}',[TasksController::class,'patch']);
    Route::resource('tasks',TasksController::class);
    Route::resource('education',EducationController::class);
    Route::patch('education/{education}',[EducationController::class,'patch'])->name('education.patch');
    Route::get('employee',[EmployeeController::class,'index']);
    Route::resource('/departments',DepartmentsController::class);
    Route::get('/get-departments/{company}',[DepartmentsController::class, 'fetchDepartments'])->name('get.departments');
    Route::get('/delete/departments/{department}',[DepartmentsController::class, 'destroy'])->name('delete.departments');
    Route::post('set-departments',[DepartmentsController::class, 'set_departments'])->name('set.departments');
    Route::patch('certification/{certification}',[CertificationsController::class,'patch'])->name('education.patch');
    Route::resource('certifications',CertificationsController::class);
    Route::resource('work-experience',WorkExperienceController::class);
    Route::patch('language/{language}',[LanguagesController::class,'patch'])->name('education.patch');
    Route::resource('languages',LanguagesController::class);
    Route::resource('dependants',DependantsController::class);
    Route::resource('beneficiaries',BeneficiariesController::class);
    Route::resource('emergency-contact',EmergencyContactsController::class);
    Route::resource('referees',RefereesController::class);
    Route::post('task/complete/{task}',[TasksController::class,'complete'])->name('task.complete');
   // Route::get('task-url-mapping/{task}',[TasksController::class,'task_url_mapping'])->name('task.url.mapping');
   Route::resource('assets',AssetsController::class);
   Route::patch('asset-patch/{asset}',[AssetsController::class,'patch']);
   Route::resource('benefits',BenefitsController::class);
   Route::patch('benefit-patch/{benefit}',[BenefitsController::class,'patch']);

   // company patch route
   Route::patch('company/{company}',[CompanyController::class,'patch'])->name('company.patch');
   Route::get('/fetch/leave-type/{company}', 'App\Http\Controllers\Web\Leave\LeaveTypesController@fetchLeaveTypes')->name('leave-type.fetch');
   Route::post('/create/leave-type/{company}', 'App\Http\Controllers\Web\Leave\LeaveTypesController@store')->name('leave-type.store');
   Route::get('/delete/leave-type/{leave_type}', 'App\Http\Controllers\Web\Leave\LeaveTypesController@delete')->name('leave-type.delete');
   Route::post('company/pluck/{company}',[CompanyController::class,'pluck']);

   //payroll routes
   Route::get('/payroll-cyle/fetch/{company}', 'App\Http\Controllers\Web\Payroll\PayrollCycleController@fetchPayrollCycle')->name('payroll-cycle.fetch');
   Route::post('/payroll-cyle/create/{company}','App\Http\Controllers\Web\Payroll\PayrollCycleController@store')->name('payroll_cycle.store');
   Route::post('/payroll/create','App\Http\Controllers\Web\Payroll\PayrollController@store')->name('payroll.store');
   Route::post('/payroll/generate-payroll/{payroll}','App\Http\Controllers\Web\Payroll\PayrollController@generatePayrollData')->name('payroll.generate.payroll.data');
   Route::post('/update/payroll-period/{payroll}','App\Http\Controllers\Web\Payroll\PayrollController@update')->name('payroll.update');
   Route::post('/payroll/update-payroll-employees/{payroll}','App\Http\Controllers\Web\Payroll\PayrollController@updatePayrollEmployees')->name('payroll.update.employees');

    // employee bulk actions routes
    Route::post('/employee/clock-in/{user}','App\Http\Controllers\Api\Employee\EmployeeController@clockin')->name('clock.in');
    Route::post('/employee/clock-out/{user}','App\Http\Controllers\Api\Employee\EmployeeController@clockOut')->name('clock.out');
    Route::post('/employee/suspend/{user}','App\Http\Controllers\Api\Employee\EmployeeController@suspendEmployee')->name('suspend.user');
    Route::post('/employee/un-suspend/{user}','App\Http\Controllers\Api\Employee\EmployeeController@unSuspendEmployee')->name('un-suspend.user');
    Route::get('/employee/download-data/{selected_employees}','App\Http\Controllers\Api\Employee\EmployeeController@downloadEmployeesData')->name('download.employees.data');

    //process password reset route process.password.reset
    Route::post('/password-reset/process/{user}', 'App\Http\Controllers\Auth\NewPasswordController@processPasswordReset')->name('process.password.reset');
   
    Route::resource('media',MediaController::class);

    // Leave routes
    Route::post('/leave/update/{leave}', 'App\Http\Controllers\Api\Leave\LeaveController@update')->name('leave.patch');
    Route::post('/leave', 'App\Http\Controllers\Api\Leave\LeaveController@store')->name('leave.post');
    Route::get('/leave/fetch-employee/{user}', 'App\Http\Controllers\Api\Leave\LeaveController@fetchEmployeeLeaves')->name('fetch.employee.leaves');
    Route::post('/admin/leave/decline/{leave}', 'App\Http\Controllers\Api\Leave\LeaveController@declineLeave')->name('admin.decline.leave');
    Route::post('/admin/leave/approve/{leave}', 'App\Http\Controllers\Api\Leave\LeaveController@approveLeave')->name('admin.approve.leave');
    Route::post('/admin/leave/mark_under-review/{leave}', 'App\Http\Controllers\Api\Leave\LeaveController@makLeaveUnderReview')->name('admin.mark-under-review.leave');

    //Mpesa payments routes
    Route::post('/payments/mpesa/stk-Push/{user}', 'App\Http\Controllers\Api\Payments\MpesaController@sendSTKPush')->name('send.mpesa.stk-push');
    Route::post('/stkpush/callback', 'App\Http\Controllers\Api\Payments\MpesaResponsesController@handleSTKPush')->name('handle.mpesa.stk-push');
    Route::get('/detect/mpesa/payment/{user}', 'App\Http\Controllers\Api\Payments\MpesaController@detectMpesaPayment')->name('detect.mpesa.payment');


    // Roles $ permissions routes 
    Route::post('/toggle/role-permissions/{user}', 'App\Http\Controllers\Web\Preferences\AccessLevels\RolesAndPermissionsController@toggleRolePermissions')->name('toggle.role.permissions');
    Route::post('/toggle/user-permissions/{user}', 'App\Http\Controllers\Web\Preferences\AccessLevels\RolesAndPermissionsController@toggleUserPermissions')->name('toggle.user.permissions');
    Route::get('/get/user-permissions/{user}', 'App\Http\Controllers\Web\Preferences\AccessLevels\RolesAndPermissionsController@getUserPermissions')->name('get.user.permissions');

    // fetch all user notifications route 
    Route::get('/fetch/all-notifications/{user}', 'App\Http\Controllers\Api\Notifications\NotificationsController@fetchAllUserNotifications')->name('get.user.all-notifications');
    Route::get('/notifications/delete/{notification}', 'App\Http\Controllers\Api\Notifications\NotificationsController@deleteNotification')->name('notification.delete'); 
    
    //Employee assets routes
    Route::post('/company/assets/save', 'App\Http\Controllers\Api\Assets\AssetsController@store')->name('employee.assets.post'); 
    Route::post('/company/assets/update/{asset}', 'App\Http\Controllers\Api\Assets\AssetsController@update')->name('employee.assets.update'); 
    Route::get('/company/assets/{company}', 'App\Http\Controllers\Api\Assets\AssetsController@fetchAssets')->name('company.assets'); 
    Route::get('/company/assets/delete/{asset}', 'App\Http\Controllers\Api\Assets\AssetsController@deleteAsset')->name('asset.delete');

    // /Company benefits routes
    Route::post('/company/benefits/store', 'App\Http\Controllers\Api\Benefits\CompanyBenefitsController@store')->name('company.benefits.store');
    Route::get('/company/benefits/delete/{benefit_id}/{company_id}', 'App\Http\Controllers\Api\Benefits\CompanyBenefitsController@delete')->name('company.benefits.delete');
    Route::get('/company/benefits/fetch/{company_id}', 'App\Http\Controllers\Api\Benefits\CompanyBenefitsController@fetchBenefits')->name('company.benefit.fetch');

    Route::post('/search/postal-codes', [CompanyController::class,'search_postal_codes'])->name('search.postal.codes');
    Route::post('/search/banks', [CompanyController::class,'search_banks'])->name('search.banks');


    Route::post('/subscribe/{subscription}/{company}', [CompanyController::class,'subscribe'])->name('subscribe');


    Route::resource('subscription',SubscriptionController::class);


// });
