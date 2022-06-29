<?php

namespace App\Http\Controllers\Api\Certifications;

use App\Http\Controllers\Controller;
use App\Models\Certification;
use Illuminate\Http\Request;

class CertificationsController extends Controller
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

        if( $certification = Certification::find($request->id) ) return $this->update($request,$certification);

        $request->validate([
            'certificate_name' => 'nullable|max:255',
            'organisation_name' => 'nullable|max:255',
            'membership_id' => 'nullable|max:255',
            'expires' => 'nullable|max:255',
            'issue_date' => 'nullable|date|max:255',
            'expiry_date' => 'nullable|date|max:255',
            'description' => 'nullable|max:255',
            'user_id' => 'numeric|required|max:255',

        ]);
        
        $certificationData = $request->only(['certificate_name','organisation_name','membership_id','expires','issue_date','expiry_date','user_id','description']);

        return $certification = Certification::create($certificationData);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Certification  $certification
     * @return \Illuminate\Http\Response
     */
    public function show(Certification $certification)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Certification  $certification
     * @return \Illuminate\Http\Response
     */
    public function edit(Certification $certification)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Certification  $certification
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Certification $certification)
    {
        $request->validate([
            'certificate_name' => 'nullable|max:255',
            'organisation_name' => 'nullable|max:255',
            'membership_id' => 'nullable|max:255',
            'expires' => 'nullable|max:255',
            'issue_date' => 'nullable|date|max:255',
            'expiry_date' => 'nullable|date|max:255',
            'description' => 'nullable|max:255',
            'user_id' => 'numeric|required|max:255',

        ]);
        
        $certificationData = $request->only(['certificate_name','organisation_name','membership_id','expires','issue_date','expiry_date','user_id','description']);

        $certification->update($certificationData);

        return $certification;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Certification  $certification
     * @return \Illuminate\Http\Response
     */
    public function destroy(Certification $certification)
    {
        return $certification->forceDelete();
    }

    public function patch(Request $request, Certification $certification)
    {
        $request->validate([
            'field' => 'required|string|max:255',
            'value' => 'nullable',
            'type' => 'nullable|string',
        ]);

        $value = $request->value;

        if( $request->type == 'current_time' ) 
            if(  $value ) $value = now();
            else $value = null;


        if( $request->type == 'phone' || $request->field == 'phone' && $value ) $value = Utilities::cleanPhoneNumber( $value, '254' );
        return $certification->update([
            $request->field => $value
        ]);

        return $certification->refresh();

    }
}
