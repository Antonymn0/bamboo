<?php

namespace App\Http\Controllers\Web\Preferences;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Loan;
use App\Models\Company;

class LoanController extends Controller
{
    /**
     * Save loans form
     */
    public function storeLoan(Request $request)
    {
        $request->validate([
            'loan' => 'required',
            'loan_name' => 'required|string',
            'max_loan_amount' => 'required|regex:/^[0-9]+(\.[0-9]{1,2})?$/',
            'max_repayment_period' => 'required|regex:/^[0-9]+(\.[0-9]{1,2})?$/',
            'interest_rate' => 'required|regex:/^[0-9]+(\.[0-9]{1,2})?$/',
            'company_id' => 'required|integer',
        ]);


        $loan = Loan::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Loan record created',
            'data' => $loan
        ],201);
    }

    /**
     * Get Loan records
     */
    public function fetchLoanRecord(Request $request, Company $company)
    {
        $loan_record = Loan::where('company_id', $company->id)->get();

        return response()->json([
            'success' => true,
            'message' => 'Loan record fetched',
            'data' =>  $loan_record
        ],200);
    }

    /**
     * Get Loan records
     */
    public function deleteLoanRecord(Request $request, Loan $loan)
    {
        $loan->delete();

        return response()->json([
            'success' => true,
            'message' => 'Loan record deleted',
            'data' =>  true
        ],200);
    }
}
