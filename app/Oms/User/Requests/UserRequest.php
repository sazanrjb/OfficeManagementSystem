<?php

namespace App\Oms\User\Requests;

use App\Http\Requests\FormRequest;
use App\Oms\User\Models\User;

class UserRequest extends FormRequest
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
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'joined_date' => 'required|date',
            'designation' => 'required|in:'.ucfirst(User::ADMIN).','.ucfirst(User::EMPLOYEE),
        ];
    }
}