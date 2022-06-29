<?php

namespace App\Http\Controllers\Api\Benefits;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\CompanyBenefit;
use App\Models\Company;

class CompanyBenefitsController extends Controller
{
    /**
    * show company benefits form
    */
    public function showBenefitsForm(Request $request){

        return Inertia::render('Preferences/Benefits/CompanyBenefits');

    }

    /**
     * Store company benefit
     */
    public function store(Request $request){
        $data = $request->validate([
            'created_by' => 'required|integer',
            'benefit_id' => 'required|integer',
            'company_id' => 'required|integer'
        ]);

        $benefit = CompanyBenefit::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Benefit created',
            'data' => true
        ]);

    }

    /**
     * fetch benefits
     */
    public function fetchBenefits(Request $request, $company_id){

        $benefits = CompanyBenefit::where('company_id', $company_id)->get();

        return response()->json([
            'success' => true,
            'message' => 'Fecth successful',
            'data' => $benefits
        ],200);

    }


    /**
     * Delete company benefit
     */
    public function delete(Request $request, $benefit_id, $company_id ){

        $benefit = CompanyBenefit::where('company_id', $company_id)
                                ->where('benefit_id', $benefit_id)
                                ->first();

        $benefit->delete();

        return response()->json([
            'success' => true,
            'message' => 'Delete successful',
            'data' => true
        ],200);

    }

    
}
