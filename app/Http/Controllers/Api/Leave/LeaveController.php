<?php

namespace App\Http\Controllers\Api\Leave;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreLeaveRequest;
use App\Models\Leave;
use App\Models\User;
use App\Events\Leave\LeaveCreatedEvent;
use App\Events\Leave\LeaveApprovedEvent;
use App\Events\Leave\LeaveUnderReviewEvent;
use App\Events\Leave\LeaveDeclinedEvent;

class LeaveController extends Controller
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
     * @param  \Illuminate\Http\Request\StoreLeaveRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreLeaveRequest $request)
    {
        $data = $request->validated();

        $leave= Leave::create($data);
        
        event(new LeaveCreatedEvent($leave));

        return response()->json([
            'success' => true,
            'message' => 'Success, Leave created',
            'data' => $leave
        ], 201);
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
    public function update(Request $request, Leave $leave)
    {
        $data = $request->validate([
            'start_date'=> 'required|date',
            'end_date'=> 'required|date',
            'leave_type'=> 'required|integer',
            'description'=> 'required|string'
        ]);

        $leave->update($data);

        event(new LeaveCreatedEvent($leave));

        return response()->json([
            'success' => true,
            'message' => 'Success, Leave updated',
            'data' => $leave
        ], 200);
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
     * Fetch all leaves for a specific employee/user
     */
    public function fetchEmployeeLeaves (Request $request, User $user) {

        $leaves = $user->leaves;

        return response()->json([
            'success' => true,
            'message' => 'A list of leaves',
            'data'=> $leaves
        ], 200);
    }

    /**
     *  admin approve leave page
     */
    public function approveLeave(Request $request,  Leave $leave)
    {   
         $request->validate([
            'hr_comments' => 'required|string',
            'approved_by' => 'required|integer',
        ]);

        $leave->update([
            'status' => 0,
            'hr_comments' => $request->hr_comments,
            'approved_by' => $request->approved_by
        ]);

        event(new LeaveApprovedEvent($leave));

        return response()->json([
            'success' => true,
            'message' => 'Success, leave approved',
            'data' => true
        ], 200);
    }
    /**
     *  mark leave under review
     */
    public function makLeaveUnderReview(Request $request,  Leave $leave)
    {   
         $request->validate([
            'hr_comments' => 'required|string',
            'approved_by' => 'required|integer',
        ]);

        $leave->update([
            'status' => 2,
            'hr_comments' => $request->hr_comments,
            'approved_by' => $request->approved_by
        ]);

        event(new LeaveUnderreviewEvent($leave));

        return response()->json([
            'success' => true,
            'message' => 'Success, leave marked under review',
            'data' => true
        ], 200);
    }

    /**
     *  admin approve leave page
     */
    public function declineLeave(Request $request,  Leave $leave)
    {

        $request->validate([
            'hr_comments' => 'required|string',
            'declined_by' => 'required|integer',
        ]);

        $leave->update([
            'status' => 0,
            'hr_comments' => $request->hr_comments,
            'declined_by' => $request->declined_by
        ]);

        event(new LeaveDeclinedEvent($leave));

        return response()->json([
            'success' => true,
            'message' => 'Success, leave declined',
            'data' => true
        ], 200);
    }

}
