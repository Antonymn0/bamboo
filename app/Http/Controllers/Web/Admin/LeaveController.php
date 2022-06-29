<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Leave;
use Inertia\Inertia;
use App\Helpers\PageSettings;

class LeaveController extends Controller
{
    /**
     * Show all leaves requiring approval by admin
     */
    public function showLeavesPage(Request $request,  $username){

        // $data = PageSettings::dashboard();

        $data['user'] = User::with(['company'])
                    ->where('username', $username)
                    ->first();

        $data['leaves'] = Leave::with(['user'])
                        ->where('created_by', $data['user']->id)
                        ->orderBy('created_at', 'desc')
                        ->get();

        return Inertia::render('Admin/LeaveApprovals/LeavesApprovalsPage', $data);
    }

    /**
     * Show admin approve leave page
     */
    public function showapproveLeaveform(Request $request,  Leave $leave){        

        $data['user'] = User::with(['company'])
                        ->where('username', $request->user()->username)
                        ->first();

        $data['leave'] = Leave::with(['user'])
            ->where('id', $leave->id)
            ->first();  

        return Inertia::render('Admin/LeaveApprovals/ApproveLeave', $data);
    }

    


}
