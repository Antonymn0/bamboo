<?php

namespace App\Http\Controllers\Web\Leave;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LeaveType;
use App\Models\Company;

class LeaveTypesController extends Controller
{
    /**
     * Fetch leave types
     */
    public function fetchLeaveTypes(Request $request, Company $company)
    {
        $leave_types = LeaveType::where('company_id', $company->id)->get();
        return response()->json([
            'message' => 'A list of leave types',
            'success' => true,
            'data' => $leave_types
        ],200);
    }

    /**
     * Store leave type
     */
    public function store(Request $request, Company $company)
    {
        $data = $request->validate([
            'created_by'=> 'required|integer',
            'company_id'=> 'required|integer',
            'leave_type_id'=> "required|string|distinct|min:1",
        ]);

        $selected_leave_type_ids = explode(',', $request->leave_type_id);
        
        // get all leave type records 
        $record = LeaveType::where('company_id', $request->company_id)
                            ->where('leave_type_id', end($selected_leave_type_ids) )
                            ->first();
        if( is_null($record)){
            $data['leave_type_id'] = end($selected_leave_type_ids);
            LeaveType::create($data);
            return 'true';
        } 
        return 'false';
       
    }

    /**
     * Delete leave_type
     */
    public function delete(Request $request, LeaveType $leave_type)
    {
        $leave_type->delete();

        return response()->json([
            'message' => 'Success, leave type deleted',
            'success' => true,
            'data' => true
        ], 200);
    }

}
