<?php

namespace App\Http\Controllers\Api\Media;

use App\Http\Controllers\Controller;
use App\Models\Media;
use App\Helpers\Utilities;
use Illuminate\Http\Request;

class MediaController extends Controller
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
        $request->validate([
            'file' => 'required|file',
            'name' => 'required|max:255',
            'purpose' => 'nullable|max:255',
            'mediaable_id'  => 'nullable|numeric',
            'mediaable_type' => 'nullable|max:255',
        ]);

        if( ! $request->hasFile('file') )
            return response()->json([
                'success' => false,
                'message' => 'file not attached',
                'data' => null
            ], 403);

        $name = $request->name;
        $file = $request->file('file');
        $purpose = $request->purpose;
        $mediaable_id = $request->mediaable_id;
        $mediaable_type = $request->mediaable_type;

        return Utilities::storeMediaFile( $name , $purpose ,$file, $mediaable_id, $mediaable_type, "public" );
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Media  $media
     * @return \Illuminate\Http\Response
     */
    public function show(Media $media)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Media  $media
     * @return \Illuminate\Http\Response
     */
    public function edit(Media $media)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Media  $media
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Media $media)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Media  $media
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $media = Media::find($id);
        if( $media )
        return Utilities::destroyMedia($media);
    }
}
