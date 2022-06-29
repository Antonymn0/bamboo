<?php

namespace App\Http\Controllers\Api\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\Utilities;
use App\Helpers\Constants;
use Illuminate\Support\Facades\Schema;
use App\Models\Company;
use App\Models\Subscription;

class CompanyController extends Controller
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Patch the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function patch(Request $request, Company $company)
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
             
        if ( Schema::hasColumn('companies', $field ) ) 
                $company->update([
                    $field => $value
                ]);
        else if( $field != 'id' ) {
            $meta = $company->meta()->where('key',$field)->first();
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

            else $meta = $company->meta()->create($data);
        }

        return $company->refresh();

    }

    public function pluck( Request $request, Company $company )
    {
        $request->validate([
            'field' => 'required|max:255'
        ]);

        switch ($request->field) {
            case 'logo':
                $logo = $company->media()->where('purpose','logo')->first();
                return $logo ? $logo->public_uri : '';
            break;
            
            default:
            break;
        }
    }

    public function search_postal_codes(Request $request)
    {
        $request->validate([
            'string' => 'required|max:255'
        ]);

       $postal_codes = Constants::getPostalCodes();

       $itemCollection = collect($postal_codes);
       $filtered = $itemCollection->filter(function($item) use ($request) {
                return stripos($item['post_office_name'],$request->string) !== false || stripos($item['postal_code'],$request->string) !== false;
        });
        return $filtered ? array_values($filtered->toArray()) : $filtered;
    }

    public function search_banks(Request $request)
    {
        $request->validate([
            'string' => 'required|max:255'
        ]);

       $banks = Constants::getBanks();

       $itemCollection = collect($banks);
       $filtered = $itemCollection->filter(function($item) use ($request) {
                return stripos($item[0],$request->string) !== false || stripos($item[1],$request->string) !== false || stripos($item[2],$request->string) !== false;
        });
        return $filtered ? array_values($filtered->toArray()) : $filtered;
    }

    public function subscribe(Subscription $subscription, Company $company)
    {
        if( ! $subscription ||  ! $company )
            return response()->json([
                'success' => false,
                'message' => 'Resources not found',
                'data' => []
            ], 404); 


        $company->subscriptions()->attach($subscription->id,[
            'start_date' => now(),
            'end_date' => now()->addDays(30)
        ]);

        return $company->update([
            'registration_status' => 0,
        ]);

    }

}
