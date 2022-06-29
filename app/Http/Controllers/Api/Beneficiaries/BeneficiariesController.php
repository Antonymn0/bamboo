<?php

namespace App\Http\Controllers\Api\Beneficiaries;

use App\Http\Controllers\Controller;
use App\Models\Beneficiary;
use Illuminate\Http\Request;

class BeneficiariesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if( $beneficiary = Beneficiary::find($request->id) ) return $this->update($request,$beneficiary);

        $request->validate([
            'relationship' => 'nullable|max:255',
            'relationship_description' => 'nullable|max:255',
            'first_name' => 'nullable|max:255',
            'middle_name' => 'nullable|max:255',
            'last_name' => 'nullable|max:255',
            'user_id' => 'numeric|required|max:255',
            'phone' => 'nullable|max:255',
            'email' => 'nullable|email|max:255',
            'national_id_no' => 'nullable|max:255',
            'passport_no' => 'nullable|max:255',
            'dob' => 'nullable|date|max:255',
            'postal_address' => 'nullable|max:255',
            'postal_code' => 'nullable|max:255',
            'city' => 'nullable|max:255',

        ]);

        $beneficiaryData = $request->only(['relationship','relationship_description','first_name','middle_name','last_name','user_id','phone','email','national_id_no','passport_no','dob','postal_address','postal_code','city']);


        return $beneficiary = Beneficiary::create($beneficiaryData);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Beneficiary  $beneficiary
     * @return \Illuminate\Http\Response
     */
    public function show(Beneficiary $beneficiary)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Beneficiary  $beneficiary
     * @return \Illuminate\Http\Response
     */
    public function edit(Beneficiary $beneficiary)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Beneficiary  $beneficiary
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Beneficiary $beneficiary)
    {
        $request->validate([
            'relationship' => 'nullable|max:255',
            'relationship_description' => 'nullable|max:255',
            'first_name' => 'nullable|max:255',
            'middle_name' => 'nullable|max:255',
            'last_name' => 'nullable|max:255',
            'user_id' => 'numeric|required|max:255',
            'phone' => 'nullable|max:255',
            'email' => 'nullable|email|max:255',
            'national_id_no' => 'nullable|max:255',
            'passport_no' => 'nullable|max:255',
            'dob' => 'nullable|date|max:255',
            'postal_address' => 'nullable|max:255',
            'postal_code' => 'nullable|max:255',
            'city' => 'nullable|max:255',

        ]);

        $beneficiaryData = $request->only(['relationship','relationship_description','first_name','middle_name','last_name','user_id','phone','email','national_id_no','passport_no','dob','postal_address','postal_code','city']);

        $beneficiary->update($beneficiaryData);

        return $beneficiary;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Beneficiary  $beneficiary
     * @return \Illuminate\Http\Response
     */
    public function destroy(Beneficiary $beneficiary)
    {
        return $beneficiary->forceDelete();
    }
}
