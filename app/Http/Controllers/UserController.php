<?php

namespace App\Http\Controllers;

use App\Oms\User\Requests\UserRequest;
use App\Oms\User\Manager as UserManager;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

/**
 * Class UserController
 * @package App\Http\Controllers
 */
class UserController extends AuthController
{
    /**
     * @var UserManager
     */
    protected $userManager;

    /**
     * UserController constructor.
     * @param UserManager $userManager
     */
    public function __construct(UserManager $userManager)
    {
        parent::__construct();
        $this->userManager = $userManager;
    }

    /**
     * @return $this
     */
    public function index()
    {
        $result = $this->userManager->all();
        return view('oms.pages.user')->with('result', $result);
    }

    /**
     * @param UserRequest $request
     * @return mixed
     */
    public function store(UserRequest $request)
    {
        $this->userManager->create($request->all());
        Session::flash('notice', 'User successfully created.');
        return Redirect::to('/users');
    }

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id)
    {
        $user = $this->userManager->find($id);
        $this->userManager->delete($user);

        Session::flash('notice', 'User successfully deleted.');
        return Redirect::to('/users');
    }
}