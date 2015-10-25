<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;

class MainController extends Controller {

    public function __construct(){
        $this->middleware('guest');
    }
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        return view('oms.pages.login');
	}



    public function loginprocess(Requests\FormRequest $formRequest){

        $attempt = Auth::attempt(array(
            'username' => $formRequest['username'],
            'password' => $formRequest['password'],
            'designation' => $formRequest['designation']
        ));

        if($attempt){
            return Redirect::to('/dashboard');
        }else{
            \Session::flash('error','Invalid username or password');
            return Redirect::to('/');
        }
    }

}
