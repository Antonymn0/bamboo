<?php

namespace App\Http\Controllers\Api\Referees;

use App\Http\Controllers\Controller;
use App\Models\Referee;
use Illuminate\Http\Request;

class RefereesController extends Controller
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
        if( $referee = Referee::find($request->id) ) return $this->update($request,$referee);

        $request->validate([
            'first_name' => 'nullable|max:255',
            'middle_name' => 'nullable|max:255',
            'last_name' => 'nullable|max:255',
            'user_id' => 'numeric|required|max:255',
            'phone' => 'nullable|max:255',
            'email' => 'nullable|email|max:255',
            'dob' => 'nullable|date|max:255',
            'postal_address' => 'nullable|max:255',
            'postal_code' => 'nullable|max:255',
            'city' => 'nullable|max:255',
            'gender' => 'nullable|max:255',

        ]);

        $refereeData = $request->only(['first_name','middle_name','last_name','user_id','phone','email','dob','postal_address','postal_code','city','gender']);


        return $referee = Referee::create($refereeData);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Referee  $referee
     * @return \Illuminate\Http\Response
     */
    public function show(Referee $referee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Referee  $referee
     * @return \Illuminate\Http\Response
     */
    public function edit(Referee $referee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Referee  $referee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Referee $referee)
    {
        $request->validate([
            'first_name' => 'nullable|max:255',
            'middle_name' => 'nullable|max:255',
            'last_name' => 'nullable|max:255',
            'user_id' => 'numeric|required|max:255',
            'phone' => 'nullable|max:255',
            'email' => 'nullable|email|max:255',
            'dob' => 'nullable|date|max:255',
            'postal_address' => 'nullable|max:255',
            'postal_code' => 'nullable|max:255',
            'city' => 'nullable|max:255',
            'gender' => 'nullable|max:255',

        ]);

         $refereeData = $request->only(['first_name','middle_name','last_name','user_id','phone','email','dob','postal_address','postal_code','city','gender']);

         $referee->update( $refereeData);

        return  $referee;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Referee  $referee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Referee $referee)
    {
        return $referee->forceDelete();
    }
}
