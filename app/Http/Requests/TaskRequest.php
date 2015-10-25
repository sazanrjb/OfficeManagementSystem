<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class TaskRequest extends Request {

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
//			'taskName' => 'required|min:3',
//            'taskDescription' => 'required|3',
//            'startingDate' => 'required',
//            'endingDate' => 'required',
//            'slug' => 'required'
		];
	}

}
