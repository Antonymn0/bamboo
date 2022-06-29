<?php

namespace App\Http\Controllers\Api\Languages;

use App\Http\Controllers\Controller;
use App\Models\Language;
use Illuminate\Http\Request;

class LanguagesController extends Controller
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
        if( $language = Language::find($request->id) ) return $this->update($request,$language);

        $request->validate([
            'name' => 'nullable|max:255',
            'written_proficiency' => 'nullable|max:255',
            'spoken_proficiency' => 'nullable|max:255',
            'user_id' => 'numeric|required|max:255',
        ]);
        
        $languageData = $request->only(['name','written_proficiency','spoken_proficiency','user_id']);

        return $language = Language::create($languageData);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Language  $language
     * @return \Illuminate\Http\Response
     */
    public function show(Language $language)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Language  $language
     * @return \Illuminate\Http\Response
     */
    public function edit(Language $language)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Language  $language
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Language $language)
    {
        $request->validate([
            'name' => 'nullable|max:255',
            'written_proficiency' => 'nullable|max:255',
            'spoken_proficiency' => 'nullable|max:255',
            'user_id' => 'numeric|required|max:255',
        ]);
        

        $languageData = $request->only(['name','written_proficiency','spoken_proficiency','user_id']);

        $language->update($languageData);

        return $language;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Language  $language
     * @return \Illuminate\Http\Response
     */
    public function destroy(Language $language)
    {
        return $language->forceDelete();
    }

    public function patch(Request $request, Language $language)
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
        return $language->update([
            $request->field => $value
        ]);

        return $language->refresh();

    }
}
