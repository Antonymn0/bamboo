<?php

namespace App\Http\Controllers\Api\Assets;

use App\Http\Controllers\Controller;
use App\Models\Asset;
use App\Models\Company;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class AssetsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Asset::with(['meta'])->get();
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
        $data = $request->all();

        $asset = null;
        $assetData = [];
        $metaData = [];
         
        if( !count($data) ) return;


        foreach( $data as $key => $value )
        {
                if ( Schema::hasColumn('assets', $key ) ) 
                    $assetData [$key] = $value;
                else
                    $metaData [$key] = $value;
        }

        //generate slug
        //check if asset exists

        $asset = Asset::create($assetData);

        foreach( $metaData as $key => $value )
            $asset->meta()->create([
                'key' => $key,
                'value' =>$value,
            ]);

        return $asset;



    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Asset  $asset
     * @return \Illuminate\Http\Response
     */
    public function show(Asset $asset)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Asset  $asset
     * @return \Illuminate\Http\Response
     */
    public function edit(Asset $asset)
    {
        //
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Asset  $asset
     * @return \Illuminate\Http\Response
     */
    public function destroy(Asset $asset)
    {
        //
    }

    public function patch(Request $request, Asset $asset)
    {
        $request->validate([
            'field' => 'required|string|max:255',
            'value' => 'nullable',
            'type' => 'nullable|string',
            'category' => 'nullable|string',
        ]);

        $value = $request->value;
        $field = $request->field;
        $category = $request->category;

        if( $request->type == 'current_time' ) 
            if(  $value ) $value = now();
            else $value = null;


        if( $request->type == 'phone' || $request->field == 'phone' && $value ) $value = Utilities::cleanPhoneNumber( $value, '254' );
        
       
        if ( Schema::hasColumn('assets', $field ) ) 
                $asset->update([
                    $field => $value
                ]);
        else if( $field != 'id' ) {
            $meta = $asset->meta()->where('key',$field)->first();
            $data = ['key' => $field, 'value' => $value, 'category' => $category];
            if( $meta ) 
                if( $request->type == 'current_time' )
                        $meta->update([
                        'verified_at' => $value
                    ]);
                else 
                    $meta->update([
                        'value' => $value
                    ]);

            else $meta = $asset->meta()->create($data);
        }

        return $asset->refresh();

    }


    /**
     * show assets form
     */
    public function showAssetsForm(Request $request, Company $company){

        return Inertia::render('Preferences/EmployeeAssets/EmployeeAssets');
    }

    /**
     * show add assets form
     */
    public function showAddAssetsForm(Request $request, Company $company){

        return Inertia::render('Preferences/EmployeeAssets/AddAsset');
    }

    /**
     * show edit assets form
     */
    public function showEditAssetsForm(Request $request, Asset $asset){
        $data['asset'] = $asset;

        return Inertia::render('Preferences/EmployeeAssets/EditAsset', $data);
    }

    /**
     * Fetch assets
     */
    public function fetchAssets(Request $request, Company $company){

        $assets = Asset::where('company_id', $company->id)->get();

        return response() ->json([
            'success' => true,
            'message' => 'A list of company assets',
            'data'=> $assets
        ],200);
    }

    /**
     * Fetch assets
     */
    public function deleteAsset(Request $request, Asset $asset){

        $asset->delete();

        return response() ->json([
            'success' => true,
            'message' => 'Succsess asset deleted',
            'data'=> true
        ],200);
    }

    /**
     * Update asset
     */
    public function update(Request $request, Asset $asset){
       $data= $request->validate([
            'name' => 'string|required',
            'type' => 'string|required',
            'assigned_to' => 'integer|nullable',
            'asset_registration_no' => 'string|required',
        ]);

        $asset->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Succsess asset updated',
            'data' => true
        ],200);
    }


}
