<?php

namespace App\Http\Controllers\Api\Education;

use App\Http\Controllers\Controller;
use App\Models\Education;
use Illuminate\Http\Request;

class EducationController extends Controller
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
        if( $education = Education::find($request->id) ) return $this->update($request,$education);

        $request->validate([
            'institution_name' => 'nullable|max:255',
            'qualification' => 'nullable|max:255',
            'field_of_study' => 'nullable|max:255',
            'start_date' => 'nullable|date|max:255',
            'end_date' => 'nullable|date|max:255',
            'grade' => 'nullable|max:255',
            'gpa' => 'nullable|max:255',
            'marks' => 'nullable|max:255',
            'grade_attained' => 'nullable|max:255',
            'user_id' => 'numeric|required',
            'graduated' => 'nullable'

        ]);
        

        $educationData = $request->only(['institution_name','qualification','field_of_study','start_date','end_date','grade','gpa','user_id','marks','grade_attained','graduated']);

        return $education = Education::create($educationData);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Education  $education
     * @return \Illuminate\Http\Response
     */
    public function show(Education $education)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Education  $education
     * @return \Illuminate\Http\Response
     */
    public function edit(Education $education)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Education  $education
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Education $education)
    {
        $request->validate([
            'institution_name' => 'nullable|max:255',
            'qualification' => 'nullable|max:255',
            'field_of_study' => 'nullable|max:255',
            'start_date' => 'nullable|date|max:255',
            'end_date' => 'nullable|date|max:255',
            'grade' => 'nullable|max:255',
            'gpa' => 'nullable|max:255',
            'marks' => 'nullable|max:255',
            'grade_attained' => 'nullable|max:255',
            'user_id' => 'numeric|required',
            'graduated' => 'nullable'

        ]);

        $educationData = $request->only(['institution_name','qualification','field_of_study','start_date','end_date','grade','gpa','user_id','marks','grade_attained','graduated']);

        $education->update($educationData);

        return $education;

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Education  $education
     * @return \Illuminate\Http\Response
     */
    public function destroy(Education $education)
    {
        return $education->forceDelete();
    }

     /**
     * Patch the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Education  $education
     * @return \Illuminate\Http\Response
     */
    public function patch(Request $request, Education $education)
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
        return $education->update([
            $request->field => $value
        ]);

        return $education->refresh();

    }
}
