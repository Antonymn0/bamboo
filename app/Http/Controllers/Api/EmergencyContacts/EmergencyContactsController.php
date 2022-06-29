<?php

namespace App\Http\Controllers\Api\EmergencyContacts;

use App\Http\Controllers\Controller;
use App\Models\EmergencyContact;
use Illuminate\Http\Request;

class EmergencyContactsController extends Controller
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
        if( $emergencyContact = EmergencyContact::find($request->id) ) return $this->update($request,$emergencyContact);

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

        $emergencyContactData = $request->only(['relationship','relationship_description','first_name','middle_name','last_name','user_id','phone','email','national_id_no','passport_no','dob','postal_address','postal_code','city']);


        return $emergencyContact = EmergencyContact::create($emergencyContactData);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\EmergencyContact  $emergencyContact
     * @return \Illuminate\Http\Response
     */
    public function show(EmergencyContact $emergencyContact)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\EmergencyContact  $emergencyContact
     * @return \Illuminate\Http\Response
     */
    public function edit(EmergencyContact $emergencyContact)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EmergencyContact  $emergencyContact
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EmergencyContact $emergencyContact)
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

         $emergencyContactData = $request->only(['relationship','relationship_description','first_name','middle_name','last_name','user_id','phone','email','national_id_no','passport_no','dob','postal_address','postal_code','city']);

         $emergencyContact->update( $emergencyContactData);

        return  $emergencyContact;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EmergencyContact  $emergencyContact
     * @return \Illuminate\Http\Response
     */
    public function destroy(EmergencyContact $emergencyContact)
    {
        return $emergencyContact->forceDelete();
    }
}
