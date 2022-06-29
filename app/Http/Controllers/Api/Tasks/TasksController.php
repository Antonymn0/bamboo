<?php

namespace App\Http\Controllers\Api\Tasks;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\User;
use App\Helpers\Employee;
use App\Helpers\Utilities;
use Illuminate\Http\Request;

class TasksController extends Controller
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
            'assigned_to' => 'numeric|nullable',
            'due_date' => 'nullable|max:255',
            'description' => 'nullable',
            'status' => 'nullable|max:255',
            'type' => 'nullable|max:255',
            'type_id'  => 'numeric|nullable',
            'user_id'  => 'numeric|nullable',
            'limit'   => 'numeric|nullable'
        ]);

        $name = $request->name;
        $assigned_to = $request->assigned_to;
        $due_date = $request->due_date;
        $description = $request->description;
        $status = $request->status;
        $type = $request->type;
        $type_id = $request->type_id;
        $user_id = $request->user_id;
        $limit = $request->limit ? $request->limit : env('PAGINATE_SIZE',10);


        return Task::when($name,function($query) use ($name) {
                        return $query->where('name',$name);
                    })
                    ->when($assigned_to,function($query) use ($assigned_to) {
                        return $query->where('assigned_to',$assigned_to);
                    })
                    ->when($due_date,function($query) use ($due_date) {
                        return $query->where('due_date',$due_date);
                    })
                    ->when($description,function($query) use ($description) {
                        return $query->where('description',$description);
                    })
                    ->when($status,function($query) use ($status) {
                        return $query->where('status',$status);
                    })
                    ->when($type,function($query) use ($type) {
                        return $query->where('type',$type);
                    })
                    ->when($type_id,function($query) use ($type_id) {
                        return $query->where('type_id',$type_id);
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
        if( $request->id ) return $this->update($request, Task::find( $request->id ));

        $request->validate([
            'name' => 'nullable|max:255',
            'custom_name' => 'nullable|max:255',
            'assigned_to' => 'nullable|numeric',
            'due_date' => 'nullable|max:255',
            'due_time' => 'nullable|max:255',
            'description' => 'nullable|max:255',
            'user_id' => 'numeric|required',
            'type' => 'nullable:max:255',
            'type_id' => 'numeric|nullable',
            'more_tasks' => 'nullable'
        ]);

        $taskData = $request->only(['name','custom_name','assigned_to','due_date','description','user_id','type','type_id','due_time']);
        
        if( isset($taskData['name']) )
        if( is_array($taskData['name']) ) {
            unset($taskData['name']);
            $this->createMultipleTasks($request->name,$taskData);
        }

        $moreTasks = $request->more_tasks ? explode(",",$request->more_tasks) : '';
        
        if( is_array($moreTasks) )
            $this->createMultipleTasks($moreTasks,$taskData);

        if( is_array($request->name) || is_array($moreTasks) )
            return;
        
        if( $request->name == 'other')
            $taskData['slug'] = isset($taskData['custom_name']) ? Utilities::getTaskSlug($taskData['custom_name']) : null;
        else 
            $taskData['slug'] = isset($taskData['name']) ? Utilities::getTaskSlug($taskData['name']) : null;


        $task = Task::create($taskData);
        $task->update(['url'=>$this->task_url_mapping($task)]);

        return $task;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $task)
    {
        $request->validate([
            'name' => 'nullable|max:255',
            'custom_name' => 'nullable|max:255',
            'assigned_to' => 'nullable|numeric',
            'due_time' => 'nullable|max:255',
            'due_date' => 'nullable|max:255',
            'description' => 'nullable|max:255',
            'user_id' => 'numeric|required',
            'type' => 'nullable:max:255',
            'type_id' => 'numeric|nullable',
            'more_tasks' => 'nullable'
        ]);

        $taskData = $request->only(['name','assigned_to','custom_name','due_date','description','user_id','type','type_id','due_time']);
        
        if( isset($taskData['name']) )
        if( is_array($taskData['name']) ) {
            unset($taskData['name']);
            $this->createMultipleTasks($request->name,$taskData);
        }

        $moreTasks = $request->more_tasks ? explode(",",$request->more_tasks) : '';
        
        if( is_array($moreTasks) )
            $this->createMultipleTasks($moreTasks,$taskData);

        if( is_array($request->name) || is_array($moreTasks) )
            return;

        if( $request->name == 'other')
            $taskData['slug'] = isset($taskData['custom_name']) ? Utilities::getTaskSlug($taskData['custom_name']) : null;
        else 
            $taskData['slug'] = isset($taskData['name']) ? Utilities::getTaskSlug($taskData['name']) : null;

        

        $taskData['url'] = $this->task_url_mapping($task);

        return $task->update($taskData);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        return $task->forceDelete();
    }

    public function patch(Request $request,Task $task)
    {
        $request->validate([
            'field' => 'required|max:255',
            'value' => 'required',
        ]);

        $field = $request->field;
        $value = $request->value;

        $task->update([
            $field => $value
        ]);

        return $task->refresh();
    }

    public function complete(Task $task)
    {
        switch ( $task->type ) {
            case 'employee_onboarding':
                $employee = User::find($task->type_id);
                $assignee = User::find($task->assigned_to);
                $admin = User::find($task->user_id);

                //check if employee details verified
                 //$verified = Employee::verified($employee);

                 //$employee->update([
                    // 'reg_status' => 4,
                 //]);
                 $task->update([
                     'status' => 'complete'
                 ]);

                 if( $employee->tasks()->where('status','<>','complete')->where('type','employee_onboarding')->count() )
                    $employee->update([
                        'reg_status' => 4,
                    ]);
               /* if( $verified )
                {
                }
                else 
                {
                    
                    $task->update([
                        'status' => 'pending'
                    ]);
                }*/
                 

                //if all details verified
                 /*
                 *using a job do the following
                 *update employee reg status to 4
                 *send employee pdf with details
                 *mark task as complete
                 *alert admin that task is complete if admin not assignee
                 */
                //if details inclomplete
                /**
                 * using a job do the following
                 * update employee reg status to 3
                 * send employee pdf with details with highlights
                 * mark task as pending
                 * 
                 */

            break;
            
            default:
                # code...
            break;
        }

        $task = $task->refresh();

        return $task;
    }

    protected function task_url_mapping(Task $task)
    {
        $employee = User::find($task->type_id);

        switch ($task->slug) 
        {
            case 'verify-bio-data-and-basic-details':
                return url('verify/employee-biodata',$employee->username);
            break;

            case 'verify-education-details':
                return url('verify/education',$employee->username);
            break;

            case 'contact-referees':
                return null;
            break;

            case 'assign-assets':
                return url('verify/assign-assets',$employee->username);
            break;

            case 'employee-orientation':
                return null;//url('verify/employee-orientation',$employee->username);
            break;
            
            default:
                return null;
            break;
        }
    }

    protected function createMultipleTasks($names = [], $data)
    {
        if(  ! isset($data['user_id']) || ! isset($data['type'])) return;


        foreach ($names as $name) {
            

            $data['name'] = $name;

            $task = Task::where('name',$name)
                          ->where('user_id',$data['user_id'])
                          ->where('type',$data['type'])
                          ->first();

            $data['slug'] = $task ? $task->slug : Utilities::getTaskSlug($name);

            if( $task ) $task->update($data);
            else $task = Task::create($data);

            $task->update(['url'=>$this->task_url_mapping($task)]);


        }

    }
}
