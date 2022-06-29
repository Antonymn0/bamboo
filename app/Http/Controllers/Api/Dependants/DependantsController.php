<?php

namespace App\Http\Controllers\Api\Dependants;

use App\Http\Controllers\Controller;
use App\Models\Dependant;
use Illuminate\Http\Request;

class DependantsController extends Controller
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
        if( $dependant = Dependant::find($request->id) ) return $this->update($request,$dependant);

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
        ]);

        $dependantData = $request->only(['relationship','relationship_description','first_name','middle_name','last_name','user_id','phone','email','national_id_no','passport_no','dob']);

        return $dependant = Dependant::create($dependantData);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Dependant  $dependant
     * @return \Illuminate\Http\Response
     */
    public function show(Dependant $dependant)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Dependant  $dependant
     * @return \Illuminate\Http\Response
     */
    public function edit(Dependant $dependant)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Dependant  $dependant
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Dependant $dependant)
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
        ]);

        $dependantData = $request->only(['relationship','relationship_description','first_name','middle_name','last_name','user_id','phone','email','national_id_no','passport_no','dob']);

        $dependant->update($dependantData);

        return $dependant;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Dependant  $dependant
     * @return \Illuminate\Http\Response
     */
    public function destroy(Dependant $dependant)
    {
        $dependant->forceDelete();
    }
}
