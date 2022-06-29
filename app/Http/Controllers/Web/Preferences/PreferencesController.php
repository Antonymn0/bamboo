<?php

namespace App\Http\Controllers\Web\Preferences;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Company;
use App\Models\Loan;

class PreferencesController extends Controller
{
    /**
     * Show time tracking form
     */
    public function showTimetrackingForm(Request $request)
    {
        $data['company'] = $request->user()->company;

        return Inertia::render('Preferences/components/TimeTracking', $data);
    }

    /**
     * Show company details form
     */
    public function showCompanyDetailsForm(Request $request)
    {
        $data['company'] = $request->user()->company;

        return Inertia::render('Preferences/components/CompanyDetails/CompanyDetails', $data);
    }

    /**
     * Show company details- departments  form
     */
    public function showDepartmentsForm(Request $request)
    {
        $data['company'] = $request->user()->company;

        return Inertia::render('Preferences/components/CompanyDetails/Departments', $data);
    }

    /**
     * Show company details- departments  form
     */
    public function showSubscriptionForm(Request $request)
    {
        $data['company'] = $request->user()->company;

        return Inertia::render('Preferences/components/CompanyDetails/Subscription', $data);
    }

   

    /**
     * Show company details set leave options form
     */
    public function showCompanyDetailsLeaveOptionsForm(Request $request)
    {
        $data['company'] = $request->user()->company;

        return Inertia::render('Preferences/components/CompanyDetails/SelectLeaveOptions', $data);
    }

    /**
     * Show set leave options form
     */
    public function showSetLeaveOtionsForm(Request $request)
    {
        $data['company'] = $request->user()->company;

        return Inertia::render('Preferences/components/SetLeaveOptions', $data);
    }

    /**
     * Show logo and color form
     */
    public function showLogoColorForm(Request $request)
    {
        $data['company'] = $request->user()->company;

        return Inertia::render('Preferences/components/CompanyDetails/LogoAndColor', $data);

    }

 
    /**
     * Show notifications view
     */
    public function showNotificationView(Request $request){
        return Inertia::render('Preferences/components/Notifications_home');

    }

    /**
     * Show notifications view
    */
    public function showSetPayrollCycleOptionsForm(Request $request){

        return Inertia::render('Preferences/PayrollCycle/PayrollCycle');

    }

    /**
     * Show account status view
    */
    public function showAccountStatusForm(Request $request){

        return Inertia::render('Preferences/AccountStatus/AccountStatus');

    }

    /**
     * Show oans form
    */
    public function showLoansForm(Request $request){

        return Inertia::render('Preferences/Loans/Loans');

    }

    

}
