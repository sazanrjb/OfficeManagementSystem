<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class UserRequest extends Request {

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
//			'firstName' => 'required|min:5|max:40',
//			'lastName' => 'required|min:5|max:40',
//			'email' => 'required|min:5|max:40',
		];
	}

}
