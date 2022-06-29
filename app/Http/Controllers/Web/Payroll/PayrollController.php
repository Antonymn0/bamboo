<?php

namespace App\Http\Controllers\Web\Payroll;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\User;
use Auth;
use App\Models\Payroll;
use App\Helpers\PageSettings;


class PayrollController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getPayrolls(Request $request)
    {
        $data = PageSettings::payroll();
        $data['payrolls'] = Payroll::where('company_id', $request->user()->company_id)
                            ->orderBy('created_at', 'desc')->get();
                            

        return Inertia::render('Payroll/Payroll', $data);
    }

    /**
     * Show create payroll form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showPeriodForm(Request $request)
    {
        $data['user'] = $request->user();
        $data['company'] = $data['user']->company;

        return Inertia::render('Payroll/CreatePayroll', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'month' => 'required|string|max:255',
            'year' => 'required|min:4|max:4',            
            'company_id' => 'required|integer',            
            'created_by' => 'required|integer',            
        ]);

       $payroll_exists = Payroll::where('created_by', $request->created_by)
                            ->where('year', $request->year)
                            ->where('company_id', $request->company_id)
                            ->where('month', $request->month)
                            ->first();

        if( ! empty($payroll_exists)){
            return response()->json([
                'success' => false,
                'message' => 'You have already created a payroll for this month',
                'data' => $payroll_exists,
            ],409);
        }

        $payroll = Payroll::create($data);
        return response()->json([
            'success' => true,
            'message' => 'Success, Payroll created',
            'data' => $payroll,
        ],201);

    }

    /**
     * Show create payroll form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showEditPayrollForm(Request $request, Payroll $payroll)
    {
        $data['user'] = $request->user();
        $data['payroll'] = $payroll;

        return Inertia::render('Payroll/EditPayroll', $data);
    }


    /**
     * Show create payroll form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showSelectEmployeesForm(Request $request, Payroll $payroll)
    {        
        $data['payroll'] =$payroll;
        $data['employees'] = User::role('employee')
                            ->with(['benefits', 'department','meta' ])
                            ->where('company_id',$payroll->company_id)
                            ->get();

        return Inertia::render('Payroll/SelectPayrollEmployees', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showEditPayrollEmployeesForm(Request $request, Payroll $payroll)
    {
        $data['payroll'] = $payroll;        

        $data['employees'] = $payroll->users()->with(['benefits', 'deductions', 'meta', 'department'])->get();

        $data['all_employees'] = User::role('employee')
                            ->with(['benefits', 'department','meta' ])
                            ->where('company_id',$payroll->company_id)
                            ->get();

        return Inertia::render('Payroll/EditPayrollEmployees', $data);
    }

   

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Payroll $payroll)
    {
        $data = $request->validate([
            'month' => 'required|string|max:255',
            'year' => 'required|min:4|max:4' 
        ]);

        $payroll->update($data);
        return response()->json([
            'success' => true,
            'message' => 'Success, Payroll updated',
            'data' => $payroll,
        ],200);
    }



    /**
     * Generate payroll
    */
    public function generatePayrollData(Request $request, Payroll $payroll)
    {
        $request->validate([
            "selected_employees"    => "required",
            "selected_employees.*"  => "required|string|distinct|min:1",
        ]);

        $selected_records = explode(',', $request->selected_employees);

        // get all selected employee records
        $employees = User::with(['benefits', 'deductions'])
                    ->whereIn('id', $selected_records)
                    ->get();

        $total_benefits = 0;    
        $total_deductions = 0 ;
        $gross_payments =0;    
        $net_payments = 0;  
       
        // fetch employees with bi=oth benefits and deductions
        foreach ($employees as $employee) {
            $assigned_benefits = $employee->benefits;
            $assigned_deductions = $employee->deductions;            

            //calculate total benefits
            foreach ($assigned_benefits as $benefit) {
                $total_benefits += $benefit->amount; 
            }
            //calculate total deductions
            foreach ($assigned_deductions as $deduction) {
                $total_deductions += $deduction->amount; 
            }

            $gross_payments = $total_benefits;
            $net_payments = $gross_payments -  $total_deductions;

        }

        // update payroll data in DB
        $data =[
            'number_of_employees'  => count($employees),
            'gross_pay' => $gross_payments,
            'paye' => 0,
            'other_deductions' => $total_deductions,
            'disbursed_amount' => $net_payments
        ];
        $payroll->update($data); 

        //Save payroll employees to db : detach all and attach again
        $payroll->users()->detach();
        foreach ($employees as $employee) {
            $payroll->users()->attach($employee);           
        }

        return response()->json([
            'success' => true,
            'message' => 'Payroll reated',
            'benefits' => $total_benefits,    
            'deduction' =>  $total_deductions,
            'gross-payments' =>    $gross_payments,    
            'net_payments' =>   $net_payments, 
            'data' => $payroll
        ]);
    }



}
