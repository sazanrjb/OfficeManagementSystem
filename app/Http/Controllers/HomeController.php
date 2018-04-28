<?php namespace App\Http\Controllers;

use App\Complaint;
use App\Http\Requests;
use App\Notice;
use App\Oms\Task\Requests\TaskRequest;
use App\Oms\User\Exceptions\UserNotFoundException;
use App\Task;
use App\User;
use App\Leave;
use App\UserProfile;
use DatePeriod;
use DateTime;
use DateInterval;
use Illuminate\Support\Facades\DB;
use Request;
use Response;
use Auth;
use Redirect;
use Input;
use Hash;
use YEAR;
use App\Attendance;
use App\Repository\NoticeRepository;
use App\Repository\DateRange;

class HomeController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | Home Controller
    |--------------------------------------------------------------------------
    |
    | This controller renders your application's "dashboard" for users that
    | are authenticated. Of course, you are free to change or remove the
    | controller as you wish. It is just here to get your app started!
    |
    */

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $attendance;
    protected $user;
    protected $task;
    protected $leave;
    protected $userProfile;
    protected $notice;
    protected $savedUser;
    protected $dateRange;
    protected $leave_date;
    protected $range;
    protected $currentUser;
    protected $complaint;

    public function __construct(NoticeRepository $noticeRepositorynotice, DateRange $dateRange)
    {
        $this->middleware('auth');
        $this->dateRange = $dateRange;
        $this->user = new User();
        $this->userProfile = new UserProfile();
        $this->attendance = new Attendance();
        $this->task = new Task();
        $this->leave = new Leave();
        $this->complaint = new Complaint();
    }

    public function users()
    {
        $result = $this->user->all();
        $profile = $this->userProfile->all();
        return view('oms.pages.user')->with('result', $result)->with('profile', $profile);
    }

    public function report()
    {
        return view('oms.pages.report');
    }

    public function viewreport(Requests\ReportRequest $reportRequest)
    {
        $empID = $reportRequest['empID'];
        if ($this->user->find($empID)) {
            $user = $this->user->find($empID);
            if ($reportRequest['listCategory'] == 'Task') {
//                $task = $user->tasks()->first()->get();
                if ($user->tasks->count() == 0) {

                    \Session::flash('notice', 'No tasks are assigned to this user');
                    return redirect()->back();
                } else {
                    $task = $user->tasks()->first()->get();
                }
                return redirect()->back()->with('tasks', $task);
            } else if ($reportRequest['listCategory'] == 'Attendance') {
                $year = $reportRequest['year'];
                $month = $reportRequest['month'];
                $attendance = \DB::select("SELECT * FROM users INNER JOIN attendances ON users.id = attendances.user_id WHERE users.id ='" . $user->id . "' AND DATE_FORMAT(attendance_date,'%Y')='" . $year . "' AND DATE_FORMAT(attendance_date,'%m')='" . $month . "'");
//                var_dump($attendance);
                return redirect()->back()->with('att', $attendance);
            } else {
                if ($user->leaves->count() == 0) {
                    \Session::flash('notice', $user->first_name . " has not taken any leaves");
                    return redirect()->back();
                } else {
                    $leaves = $user->leaves()->get();
                    return redirect()->back()->with('leaves', $leaves);
                }
            }
        } else {
            \Session::flash('notice', 'No employee with this ID');
            return redirect()->back();
        }
    }

    public function broadcast()
    {
        return view('oms.pages.broadcast');
    }

    /**
     * LEAVE
     */
    public function leave()
    {
        return view('oms.pages.leave');
    }

    protected $flag;

    public function makeleave(Requests\LeaveRequest $leaveRequest)
    {
        $this->leave->start_date = date('Y-m-d', strtotime($leaveRequest['startingDate']));
        $this->leave->end_date = date('Y-m-d', strtotime($leaveRequest['endingDate']));
        $this->leave->reason = $leaveRequest['reason'];
        $this->leave->user_id = Auth::id();
        $range = $this->dateRange->date_range($this->leave->start_date, $this->leave->end_date);
        $user = User::find(Auth::id());
        $tasks = $user->tasks()->get();
        foreach ($tasks as $ta) {
            $task_date = $ta->assigned_date;
            $end_date = $ta->completion_date;
            $task_range = $this->dateRange->date_range($task_date, $end_date);
            $this->flag = $this->dateRange->date_diff($range, $task_range);
        }
        if ($this->flag) {
            \Session::flash('notice', 'You Have Task To Complete between the dates');
            return Redirect::back()->withInput();
        } else {

        }
        if ($this->leave->save()) {
            \Session::flash('notice', 'Leave registered');
            return view('oms.pages.leave');
        } else {
            \Session::flash('notice', 'Leave not registered');
            return view('oms.pages.leave');
        }

    }

    public function profile($username)
    {
        $result = $this->user->with('profile')->where('username', $username)->first();
        if (!$result) {
            throw new UserNotFoundException();
        }
        return view('oms.pages.profile')->with('user', $result);
    }

    public function editprofile()
    {
        $user = $this->user->find(Auth::id());
        $query = $this->userProfile->join('users', 'users.id', '=', 'user_profiles.user_id')->where('user_profiles.user_id', $user->id)->get();
        return view('oms.pages.editprofile')->with('user', $user)->with('profile', $query);
    }

    public function changePassword(Requests\ChangePasswordRequest $changePasswordRequest)
    {
        $oldPassword = $changePasswordRequest['oldPassword'];
        $newPassword = $changePasswordRequest['newPassword'];
        $confirmPassword = $changePasswordRequest['confirmPassword'];

        if ($newPassword != $confirmPassword) {
            \Session::flash('notice', 'Passwords do not match');
            return redirect()->back()->withInput();
        } else {
            $user = $this->user->find(Auth::id());

            $checkPassword = Auth::attempt(array(
                'password' => $oldPassword
            ));

            if ($checkPassword) {
                $user->password = Hash::make($newPassword);
                if ($user->save()) {
                    \Session::flash('notice', 'Successfully changed password');
                    return redirect()->back()->withInput();
                } else {
                    \Session::flash('notice', 'Cannot change password');
                    return redirect()->back()->withInput();
                }
            } else {

                \Session::flash('notice', 'Incorrect Password');
                return redirect()->back()->withInput();
            }
        }
    }

    public function ajax_users()
    {
        if (Request::ajax()) {
            $users = $this->user->where('designation', '=', 'Employee')->get();
            $date_range = new DateRange();
            $var = array();
            foreach ($users as $user) {
                $leave_date = $user->leaves()->get();
                foreach ($leave_date as $le_date) {
                    $range = $date_range->date_range($le_date->start_date, $le_date->end_date);
                    $flag = $date_range->date_cal($range, date('d/m/Y', strtotime(Input::get('date'))));
                    if ($flag) {
                        $user_id = $user->id;
                    }
                }
                if (isset($user_id)) {
                    if ($user_id != $user->id) {
                        array_push($var, $user);
                    }
                } else {
                    array_push($var, $user);
                }
            }
            $date = Input::get('date');
            return Response::json($var);
        } else {
            return Response::json(array('error'));
        }

    }

    public function notice($id)
    {
        $noticeList = new Notice();
        $result = $noticeList->where('id', $id)->get();
        return view('oms.pages.notice')->with('result', $result);
    }

    public function deletenotice($id)
    {
        $notice = new Notice();
        $not = $notice->find($id);
        if ($not->delete()) {
            \Session::flash('note', 'Deleted');
            return redirect()->back();
        } else {
            \Session::flash('note', 'Cannot be Deleted');
            return redirect()->back();
        }
    }

    public function broadcastprocess()
    {
        $notice = new Notice();
        $notice->notice = Input::get('message');
        $notice->user_id = Auth::id();

        if ($notice->save()) {
            \Session::flash('notice', 'Successfully broadcasted!');
            return Redirect::to('/dashboard');
        } else {
            \Session::flash('notice', 'Cannot be saved!');
            return Redirect::to('/dashboard');
        }
    }

    public function noticehistory()
    {
        $notice = new Notice();
        $result = $notice->all();
        return view('oms.pages.noticehistory')->with('result', $result);
    }

    public function select_user()
    {
        $start_date = Input::get('date');
        $complete_date = Input::get('date1');
        $TaskRange = $this->dateRange->date_range($start_date, $complete_date);
        $users = $this->user->all();
        $ranges = array();
        $user_profile = array();
//            $leave_date=$users[0]->leaves()->get();
        foreach ($users as $user) {
            $leave_date = $user->leaves()->get();
            foreach ($leave_date as $le_date) {
                array_push($ranges, $this->dateRange->date_range($le_date->start_date, $le_date->end_date));
            }
//                $flag=false;
            foreach ($ranges as $range) {
                $flag = $this->dateRange->date_diff_task_leave($TaskRange, $range);
            }
            var_dump($flag);
//                $flag=false;
            if ($flag != true) {
                array_push($user_profile, array($user->id, $user->first_name, $user->middle_name, $user->last_name));
            }
            unset($range);
            unset($flag);
            $range = array();
        }
//            var_dump($user_profile);
        return Response::json($user_profile);

    }

    public function logout()
    {
        Auth::logout();
        return redirect()->intended('/');
    }


}
