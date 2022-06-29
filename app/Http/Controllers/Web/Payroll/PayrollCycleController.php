<?php

namespace App\Http\Controllers\Web\Payroll;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\PayrollCycle;

class PayrollCycleController extends Controller
{
    /**
     * fetch payroll cycles
     */
    public function fetchPayrollCycle(Request $request, Company $company){

        $payroll_cycle = PayrollCycle::where('company_id', $company->id)->first();

        return response()->json([
            'success' => true,
            'message' => 'payroll cycle fetched',
            'data' => $payroll_cycle
        ], 200);
    }

    /**
     * store payroll cycles
     */
    public function store(Request $request, Company $company){
        $request->validate([
            'created_by' => 'required|integer',
            'company_id' => 'required|integer',
            'payroll_cycle_id' => 'required|integer',
        ]);
        
        $cycle = PayrollCycle::where('company_id', $request->company_id)->first();
                                
        if(! is_null($cycle)) $cycle->delete();

        $cycle = PayrollCycle::create([
            'created_by' => $request->created_by,
            'company_id' => $request->company_id,
            'payroll_cycle_id' => $request->payroll_cycle_id
        ]);

        return response()->json([
            'success'=> true,
            'message'=> 'payroll cycle created',
            'data' => true
        ], 200);
    }

    /**
     * delete payroll cycles
     */
    public function delete(Request $request, Company $company){
        return $company;
    }

}
