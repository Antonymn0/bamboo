<?php

namespace App\Http\Controllers\Api\Departments;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Company;
use App\Models\User;
use App\Helpers\Utilities;
use Illuminate\Http\Request;

class DepartmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $limit = $request->limit ? $request->limit : env('PAGINATE_SIZE',10);
        return Department::paginate($limit);
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
       $data = $request->validate([
                  'name'=> 'required|string|unique:departments',
                  'slug'=> 'required|string',
                  'company_id'=> 'required|integer',
                  'created_by'=> 'required|integer',
                 ]);

        $department = Department::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Success, Department created.',
            'data'=> true
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function show(Department $department)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function edit(Department $department)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Department $department)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function destroy(Department $department)
    {
       $department->delete();

        return response()->json([
            'success' => true,
            'message' => 'Success, department deleted.',
            'data' => true
        ], 200);
    }

    public function search(Request $request)
    {
        $request->validate([
            'string' => 'string|nullable|max:255'
        ]);

        $string = $request->string;
        $limit = $request->limit ? $request->limit : env('PAGINATE_SIZE',10);

        return Department::when($string,function($query) use ($string) {
                                return $query->where('name','like','%'.$string.'%');
                            })
                            ->paginate($limit);
    }

    /**
     * Fetch company departments
     */
    public function fetchDepartments(Request $request, Company $company)
    {
        $departments = $company->departments;

        return response()->json([
            'success' => true,
            'message' => 'A list of departments.',
            'data' => $departments
        ], 200);
    }

    public function set_departments(Request $request)
    {
        $request->validate([
            'user_id' => 'numeric|required',
            'departments' => 'required'
        ]);

        $user = User::find($request->user_id);
        $company = $user->company;

        if(  is_null($user) || is_null($company) ) return false;

        $company->departments()->forceDelete();

        $departments = explode(',',$request->departments);

        foreach ($departments as $name):

            //$name =  str_replace(' ', '', $name);

            $data = [
                'company_id' => $user->company ? $user->company->id : null,
                'created_by' => $user->id,
                'name' => $name,
                'slug' =>  Utilities::getDepartmentSlug($name)
            ];

            $department = Department::where('name',$name)->first();

            if( $department )
                $department->update($data);
            else 
                Department::create($data);

        endforeach;

        return true;
    }

}
