<?php

namespace App\Http\Controllers\Web\Leave;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Helpers\PageSettings;
use Auth;
use App\Models\Leave;

class LeaveController extends Controller
{
    /**
     * Show apply leaave form
     */
    public function showApplyLeaveForm (Request $request){
        $user= $request->user();
        $data = PageSettings::profile();
        $data['user'] = $user;
        $data['formFields'] = PageSettings::form_fields('basic_details', $user);
        $data['permissions'] = $user->getAllPermissions()->pluck('name');

        return Inertia::render('Leave/LeaveApplicationForm', $data);
    }

    /**
     * Show apply leaave form
    */
    public function showEditLeaveForm (Request $request, Leave $leave){
        $user= $request->user();
        $data = PageSettings::profile();
        $data['user'] = $user;
        $data['leave'] = $leave;
        $data['formFields'] = PageSettings::form_fields('basic_details', $user);
        $data['permissions'] = $user->getAllPermissions()->pluck('name');

        return Inertia::render('Leave/EditLeaveForm', $data);
    }

}
