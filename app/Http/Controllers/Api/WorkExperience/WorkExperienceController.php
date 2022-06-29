<?php

namespace App\Http\Controllers\Api\WorkExperience;

use App\Http\Controllers\Controller;
use App\Models\WorkExperience;
use Illuminate\Http\Request;

class WorkExperienceController extends Controller
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
        if( $experience = WorkExperience::find($request->id) ) return $this->update($request,$experience);

        $request->validate([
            'title' => 'nullable|max:255',
            'company' => 'nullable|max:255',
            'location' => 'nullable|max:255',
            'start_date' => 'nullable|max:255',
            'end_date' => 'nullable|date|max:255',
            'user_id' => 'numeric|required|max:255',
            'description' => 'nullable',
            'lat' => 'nullable|max:255',
            'lng' => 'nullable|max:255',
            'country' => 'nullable|max:255',
            'postal_code' => 'nullable|max:255',
            'physical_address' => 'nullable|max:255',
        ]);

        $experienceData = $request->only(['physical_address','postal_code','country','lat','lng','title','company','location','start_date','end_date','user_id','description']);

        return $experience = WorkExperience::create($experienceData);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\WorkExperience  $workExperience
     * @return \Illuminate\Http\Response
     */
    public function show(WorkExperience $workExperience)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\WorkExperience  $workExperience
     * @return \Illuminate\Http\Response
     */
    public function edit(WorkExperience $workExperience)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\WorkExperience  $workExperience
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, WorkExperience $workExperience)
    {
        $request->validate([
            'title' => 'nullable|max:255',
            'company' => 'nullable|max:255',
            'location' => 'nullable|max:255',
            'start_date' => 'nullable|max:255',
            'end_date' => 'nullable|date|max:255',
            'user_id' => 'numeric|required|max:255',
            'description' => 'nullable',
            'lat' => 'nullable|max:255',
            'lng' => 'nullable|max:255',
            'country' => 'nullable|max:255',
            'postal_code' => 'nullable|max:255',
            'physical_address' => 'nullable|max:255',
        ]);

        $experienceData = $request->only(['physical_address','postal_code','country','lat','lng','title','company','location','start_date','end_date','user_id','description']);

        $workExperience->update($experienceData);

        return $workExperience;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\WorkExperience  $workExperience
     * @return \Illuminate\Http\Response
     */
    public function destroy(WorkExperience $workExperience)
    {
        return $workExperience->forceDelete();
    }
}
