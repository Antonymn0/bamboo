<?php

namespace App\Http\Controllers\Api\Employee;

use App\Models\User;
use App\Models\Company;
use App\Models\Attendance;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Inertia\Inertia;
use App\Helpers\PageSettings;
use App\Helpers\GeneratePDF;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        $per_page = $request->per_page ? $request->per_page : env('PAGINATE_SIZE',10);
        $employees = User::whereHas('roles', function ($query)  {
            $query->where('name', 'employee');
         })->with(['department','meta'])->paginate($per_page);
        return $employees;
    }

    /**
     * Clock in user
     * @param $request
     */
    public function clockin(Request $request, User $user){
        $request->validate([
            "selected_employees"    => "required",
            "company_id"    => "required|numeric",
            "selected_employees.*"  => "required|string|distinct|min:1",
        ]);

        $selected_records = explode(',', $request->selected_employees);

        $company = Company::find($request->company_id);

        if( ! $company ) return [];

        // fetch all selected employees user records
        $employees = $company->users()->whereIn('id', $selected_records)->get();                    

        // clock in all selected employees
        foreach ($employees as $employee) {
            
            // check if employee has been clocked in earlier today
            $clocked_in = $company->attendance()->where('user_id', $employee->id)
                            ->whereDay('created_at', now()->day)
                            ->first();
            if(! is_null($clocked_in)) {
                // continue;
                /*return response()->json([
                    'success' => false,
                    'message' => 'One or more clock in records exist',
                    'data' => true
                ],409);*/
                return;
            }
            $data=[
                'user_id'=> $employee->id,
                'clocked_in_by'=> $user->id,
                'clock_in_time' => date("h:i a")
            ];

           $attendance = $company->attendance()->create($data);
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Clock in successfull',
            'data' => true
        ], 200);
    }

    /**
     * Clock out user
     * @param $request
     */
    public function clockOut(Request $request, User $user){
        $request->validate([
            "selected_employees"    => "required",
            "company_id"    => "required|numeric",
            "selected_employees.*"  => "required|string|distinct|min:1",
        ]);

         $selected_records = explode(',', $request->selected_employees);

         $company = Company::find($request->company_id);

        if( ! $company ) return [];

        // fetch all selected employees user records
        $employees = $company->users()->whereIn('id', $selected_records)->get();                    

        // clock in all selected employees
        foreach ($employees as $employee) {
            $record = $company->attendance()->where('user_id', $employee->id)
                            ->whereDay('created_at', now()->day)
                            ->first();
            if(is_null($record)){
                return response()->json([
                    'success' => false,
                    'message' => 'One or more users have not been clocked in today!',
                    'data' => false
                ],404);
            }

            if( ! is_null($record->clocked_out_time)) {
                /*return response()->json([
                    'success' => false,
                    'message' => 'One or more records have already been clocked out',
                    'data' => false
                ],409);*/
                return;
            }

           $record->update([
               'clocked_out_time' => date("h:i a"),
               'clocked_out_by' => $user->id,
               ]);

            //mark employee absent
            $employee->update(['status'=>1]);
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Clock out successfull',
            'data' => true
        ], 200);
    }


    /**
     * Suspend user
     * @param $request
     */
    public function suspendEmployee(Request $request, User $user){
        $request->validate([
            "selected_employees"    => "required",
            "selected_employees.*"  => "required|string|distinct|min:1",
        ]);

        $selected_records = explode(',', $request->selected_employees);

        // fetch all selected employees user records
        $employees = User::whereIn('id', $selected_records)->get();                    

        // suspend all selected employees
        foreach ($employees as $employee) {

            if( $employee->status == 3) {
                return response()->json([
                    'success' => false,
                    'message' => 'User already suspended',
                    'data' => false
                ],409);
            }

           $employee->update([
              'status' => 3,
              'suspended_by' => $user->id,
              'suspended_at' => Carbon::today(),
               ]);
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Success, user(s) suspended',
            'data' => true
        ], 200);
    }

    /**
     * Suspend user
     * @param $request
     */
    public function unSuspendEmployee(Request $request, User $user){
        $request->validate([
            "selected_employees"    => "required",
            "selected_employees.*"  => "required|string|distinct|min:1",
        ]);

        $selected_records = explode(',', $request->selected_employees);

        // fetch all selected employees user records
        $employees = User::whereIn('id', $selected_records)->get();                    

        // suspend all selected employees
        foreach ($employees as $employee) {

            if( $employee->status !== 3) {
                return response()->json([
                    'success' => false,
                    'message' => 'This user is not suspended yet',
                    'data' => false
                ],409);
            }

           $employee->update([
              'status' => null,
              'un_suspended_by' => $user->id,
              'un_suspended_at' => Carbon::today()
               ]);
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Success, user restored',
            'data' => true
        ], 200);
    }

    /**
     * Offboard user
     * @param $request
     */
    public function offboardEmployee(Request $request, User $user){                  

        $data['employee'] = $user ;
        $data['formFields'] = PageSettings::form_fields('onboard_step_3',$user);

        return Inertia::render('Employees/Offboard/AssignTasks', $data);
    }

    /**
     * show finish Offboard user
     * @param $request
     */
    public function ShowFinishOffboardingEmployee(Request $request, User $user){                  

        $data['employee'] = $user ;
        $data['formFields'] = PageSettings::form_fields('onboard_step_3',$user);

        return Inertia::render('Employees/Offboard/FinnishOffboarding', $data);
    }

    /**
     * Show finish Offboard user
     * @param $request
     */
    public function processOffboardingEmployee(Request $request, User $user){                  

         $user->update([
             'status' => 3,
             'suspended_by' => $request->user()->id,
             'suspended_at' => now(),
         ]) ;


        return redirect()->route('employees');
    }

    /**
     * Download employee details data
     * @param array of user ids
     */
    public function downloadEmployeesData(Request $request, $selected_employees){

        $pdf = GeneratePDF::generateEmployeesDataPDF( json_decode($selected_employees) );

        return $pdf->stream('employee_data.pdf');
    }

    public function attendance(Company $company)
    {
        return 
        [
            'present' => $company->attendance()->whereDate('created_at', Carbon::today())->where('clock_in_time','<>','')->where('clocked_out_time',null)->count(),
            'on_leave' => $company->users()->where('status', 2)->count(),
            'absent' => $company->users()->where('status', 1)->count(),
            'on_leave_tomorrow' => $company->users()->whereHas('media',function($query){
                                            $query->where('purpose','avatar');
                                        })
                                        ->with([ 
                                            'media' => function($query){
                                                $query->where('purpose','avatar');
                                            }
                                        ])->limit(10)->get(),
        ];
    }

}
