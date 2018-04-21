<?php

namespace App\Oms\Task\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskRequest extends FormRequest
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
			'task_name' => 'required|min:3',
            'task_description' => 'required',
            'assigned_date' => 'required|date',
            'completion_date' => 'required|date',
            'slug' => 'required',
            'emp_name' => 'required'
        ];
    }
}