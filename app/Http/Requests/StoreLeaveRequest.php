<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLeaveRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'employee_id' => 'required|integer',
            'created_by' => 'required|integer',
            'leave_type' => 'required|integer',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'reporting_date' => 'required|date',
            'status' => 'integer',
            'description' => 'string',
            'hr_comments' => 'string',
            'number_of_days' => 'required|integer',
        ];
    }
}
