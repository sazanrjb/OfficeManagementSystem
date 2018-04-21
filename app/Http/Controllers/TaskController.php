<?php

namespace App\Http\Controllers;

use App\Oms\Task\Manager;
use App\Oms\Task\Requests\TaskRequest;
use App\Oms\User\Models\User;
use App\Oms\User\Manager as UserManager;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

/**
 * Class TaskController
 * @package App\Http\Controllers
 */
class TaskController extends AuthController
{
    /**
     * @var UserManager
     */
    private $userManager;
    /**
     * @var Manager
     */
    private $taskManager;
    /**
     * @var Guard
     */
    private $auth;

    /**
     * TaskController constructor.
     * @param Manager $taskManager
     * @param UserManager $userManager
     * @param Guard $auth
     */
    public function __construct(
        Manager $taskManager,
        UserManager $userManager,
        Guard $auth
    )
    {
        parent::__construct();
        $this->taskManager = $taskManager;
        $this->userManager = $userManager;
        $this->auth = $auth;
    }

    /**
     * @return $this
     */
    public function index()
    {
        $var = array();
        $result = $this->userManager->getByDesignation(User::EMPLOYEE);
        $tasks = $this->taskManager->all();
        foreach($tasks as $task){
            $users = $task->users()->get();
            foreach($users as $user){
                if($user->id == $this->auth->id())
                    array_push($var,$task);
            }
        }

        return view('oms.pages.tasks')
            ->with('result',$result)
            ->with('task',$tasks)
            ->with('empTask',$var);
    }

    public function store(TaskRequest $request)
    {
        if ($this->taskManager->create($request->all())) {
            Session::flash('notice','Task Assigned');
            return Redirect::back();
        }

        Session::flash('notice','Certain User are Absent');
        return Redirect::back()->withInput();
    }

    public function destroy($id)
    {
        $task = $this->taskManager->find($id);
        $this->taskManager->delete($task);
        Session::flash('notice','Task deleted successfully.');
        return Redirect::back();
    }
}