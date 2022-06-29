<?php

namespace App\Http\Controllers\Api\Benefits;

use App\Http\Controllers\Controller;
use App\Models\Benefit;
use Illuminate\Http\Request;

class BenefitsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->validate([
            'name' => 'nullable|max:255',
            'other_name' => 'nullable|max:255',
            'assigned_by' => 'numeric|nullable',
            'user_id' => 'numeric|nullable',
            'limit'   => 'numeric|nullable'
        ]);

        $name = $request->name;
        $assigned_by = $request->assigned_by;
        $type_id = $request->type_id;
        $user_id = $request->user_id;
        $limit = $request->limit ? $request->limit : env('PAGINATE_SIZE',10);

        return Benefit::when($name,function($query) use ($name) {
                return $query->where('name',$name);
            })
            ->when($assigned_by,function($query) use ($assigned_by) {
                return $query->where('assigned_by',$assigned_by);
            })
            ->when($user_id,function($query) use ($user_id) {
                return $query->where('user_id',$user_id);
            })
            ->paginate($limit);
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
            'name' => 'nullable|max:255',
            'other_name' => 'nullable|max:255',
            'user_id' => 'required|numeric',
            'assigned_by' => 'required|numeric',
        ]);

        $data = $request->only(['name','other_name','user_id','assigned_by']);
        
        return Benefit::create($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Benefit  $benefit
     * @return \Illuminate\Http\Response
     */
    public function show(Benefit $benefit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Benefit  $benefit
     * @return \Illuminate\Http\Response
     */
    public function edit(Benefit $benefit)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Benefit  $benefit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Benefit $benefit)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Benefit  $benefit
     * @return \Illuminate\Http\Response
     */
    public function destroy(Benefit $benefit)
    {
        return $benefit->forceDelete();
    }

    public function patch(Request $request,Benefit $benefit)
    {
        $request->validate([
            'field' => 'required|max:255',
            'value' => 'required',
        ]);

        $field = $request->field;
        $value = $request->value;

        $benefit->update([
            $field => $value
        ]);

        return $benefit->refresh();
    }
}
