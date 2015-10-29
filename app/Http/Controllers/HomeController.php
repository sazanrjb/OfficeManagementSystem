<?php namespace App\Http\Controllers;

use App\Complaint;
use App\Http\Requests;
use App\Notice;
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
class HomeController extends Controller {

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
    protected  $savedUser;
    protected $dateRange;
    protected $leave_date;
    protected $range;
    protected $currentUser;
    protected $complaint;
    public function __construct(NoticeRepository $noticeRepositorynotice, DateRange $dateRange){
        $this->middleware('auth');

        $this->notice = $noticeRepositorynotice;
        \View::share('notice',$this->notice->getAll());
        $this->dateRange = $dateRange;
        $this->user = new User();
        $this->userProfile = new UserProfile();
        $this->attendance = new Attendance();
        $this->task = new Task();
        $this->leave = new Leave();
        $this->complaint = new Complaint();
    }

    public function dashboard()
    {
        return view('oms.pages.dashboard');
    }

    public function users(){
        $result = $this->user->all();
        $profile = $this->userProfile->all();
        return view('oms.pages.user')->with('result',$result)->with('profile',$profile);
    }

    public function report(){
        return view('oms.pages.report');
    }

    public function viewreport(Requests\ReportRequest $reportRequest){
        $empID = $reportRequest['empID'];
        if($this->user->find($empID)){
            $user = $this->user->find($empID);
            if($reportRequest['listCategory'] == 'Task'){
//                $task = $user->tasks()->first()->get();
                if($user->tasks->count() == 0){

                    \Session::flash('notice','No tasks are assigned to this user');
                    return redirect()->back();
                }else{
                    $task = $user->tasks()->first()->get();
                }
                return redirect()->back()->with('tasks',$task);
            }else if($reportRequest['listCategory'] == 'Attendance'){
                $year = $reportRequest['year'];
                $month = $reportRequest['month'];
                $attendance = \DB::select("SELECT * FROM users INNER JOIN attendances ON users.id = attendances.user_id WHERE users.id ='".$user->id."' AND DATE_FORMAT(attendance_date,'%Y')='".$year."' AND DATE_FORMAT(attendance_date,'%m')='".$month."'");
//                var_dump($attendance);
                return redirect()->back()->with('att',$attendance);
            }else{
//                $leaves = $user->leaves()->get();
//                var_dump($leaves);
                if($user->leaves->count() == 0){
                    \Session::flash('notice',$user->first_name." has not taken any leaves");
                    return redirect()->back();
                }else{
                    $leaves = $user->leaves()->get();
                    return redirect()->back()->with('leaves',$leaves);
                }
//
            }
        }else{
            \Session::flash('notice','No employee with this ID');
            return redirect()->back();
        }
    }

    public function broadcast(){
        return view('oms.pages.broadcast');
    }

    public function tasks(){
        $var = array();
        $result = $this->user->where('designation','=','Employee')->get();
        $tasks = $this->task->all();
        foreach($tasks as $task){
            $users = $task->users()->get();
            foreach($users as $user){
                if($user->id == Auth::id())
                array_push($var,$task);
            }
        }
//        var_dump($var);
        return view('oms.pages.tasks')->with('result',$result)->with('task',$tasks)->with('empTask',$var);
    }

    public function complaint(){
        $complaint = new Complaint();
        $all = $complaint->all();
        return view('oms.pages.complaint')->with('complaint',$all);
    }

    public function processcomplaint(){
        $message = Input::get('message');
        if($message == ''){
            \Session::flash('notice','Please enter a message!');
            return redirect()->back()->withInput();
        }else{
            $complaint = new Complaint();
            $complaint->complaint = Input::get('message');
            $complaint->user_id = Auth::id();
            if($complaint->save()){
                \Session::flash('notice','Successsfully reported Complaint');
                return redirect()->back();
            }else{
                \Session::flash('notice','Error reporting Complaint');
                return redirect()->back();
            }
        }
    }

    public function deletecomplaint($id){
        $complaint = $this->complaint->find($id);
        if($complaint->delete()){
            \Session::flash('notice','Successfully deleted');
//            return Redirect::to('/');
            return redirect('/');
        }else{
            \Session::flash('notice', 'Error deleting');
            return Redirect::to('/');
        }
    }

    public function viewcomplaint($id){
        $complaint = $this->complaint->where('id','=', $id)->get();
        return view('oms.pages.viewcomplaint')->with('complaint',$complaint);
    }
    /**
     * LEAVE
     */
    public function leave(){
        return view('oms.pages.leave');
    }

    protected $flag;
    public function makeleave(Requests\LeaveRequest $leaveRequest){
        $this->leave->start_date = date('Y-m-d',strtotime($leaveRequest['startingDate']));
        $this->leave->end_date = date('Y-m-d',strtotime($leaveRequest['endingDate']));
        $this->leave->reason = $leaveRequest['reason'];
        $this->leave->user_id = Auth::id();
        $range = $this->dateRange->date_range($this->leave->start_date,$this->leave->end_date);
//        foreach($range as $r){
//            echo $r.'<br>';
//        }
        $user=User::find(Auth::id());
        $tasks=$user->tasks()->get();
        foreach($tasks as $ta){
            $task_date=$ta->assigned_date;
            $end_date=$ta->completion_date;
            $task_range=$this->dateRange->date_range($task_date,$end_date);
            $this->flag=$this->dateRange->date_diff($range,$task_range);
        }
//        var_dump($flag);
        if($this->flag){
            \Session::flash('notice','You Have Task To Complete between the dates');
            return Redirect::back()->withInput();
        }
        else{

        }
        if($this->leave->save()){
            \Session::flash('notice','Leave registered');
            return view('oms.pages.leave');
        }else{
            \Session::flash('notice','Leave not registered');
            return view('oms.pages.leave');
        }

    }

    public function profile($username){
        $result = $this->user->where('username',$username)->get();
        if($result->count()==1){
//            $this->savedUser = \DB::select("SELECT * FROM users INNER JOIN user_profiles ON users.id = user_profiles.user_id WHERE user_profiles.user_id=" . $result[0]->id);
            $this->savedUser = $this->userProfile->join('users','users.id','=','user_profiles.user_id')->where('user_profiles.user_id',$result[0]->id)->get();
            return view('oms.pages.profile')->with('user',$result)->with('profile',$this->savedUser);
        }else{
            return Redirect::to('/');
        }
    }

    public function editprofile(){
        $user = $this->user->find(Auth::id());
//        $query = \DB::select("SELECT * FROM users INNER JOIN user_profiles ON users.id = user_profiles.user_id");
        $query = $this->userProfile->join('users','users.id','=','user_profiles.user_id')->where('user_profiles.user_id',$user->id)->get();
        return view('oms.pages.editprofile')->with('user',$user)->with('profile',$query);
    }

    public function editprocess(Requests\EditProfileRequest $editProfileRequest){

        $user = $this->user->find(Auth::id());
        $user->first_name = $editProfileRequest['firstName'];
        $user->middle_name = $editProfileRequest['middleName'];
        $user->last_name = $editProfileRequest['lastName'];
        $user->email = $editProfileRequest['email'];

            if($user->save()){
//                $profile = $this->userProfile->join('users', 'users.id', '=', 'user_profiles.user_id')->where('user_profiles.user_id',$user->id)->get();
                $profile = $user->profile;
                $profile->gender = $editProfileRequest['gender'];
                $profile->address = $editProfileRequest['address'];
                $profile->contact = $editProfileRequest['contact'];
                $file = Input::file('image');
                if(Input::file('image')->isValid()){
                    $destination = 'img';
                    $ext = $file->getClientOriginalExtension();
                    $filename = rand(1111,99999) . '.' . $ext;
                    $profile->profile_picture=$destination . '/' . $filename;
                    if($profile->save()){
                        Input::file('image')->move($destination,$filename);

                        $this->savedUser = \DB::select("SELECT * FROM users INNER JOIN user_profiles ON users.id = user_profiles.user_id WHERE user_profiles.id=" . $profile->id);

//                        return view('oms.pages.profile')->with('user',$user)->with('profile',$this->savedUser);
                        return redirect()->back();
                    }
                }

            }else{
                echo 'Cannot update profile';
            }
    }

    public function changePassword(Requests\ChangePasswordRequest $changePasswordRequest){
        $oldPassword = $changePasswordRequest['oldPassword'];
        $newPassword = $changePasswordRequest['newPassword'];
        $confirmPassword = $changePasswordRequest['confirmPassword'];

        if($newPassword != $confirmPassword){
            \Session::flash('notice','Passwords do not match');
            return redirect()->back()->withInput();
        }else{
            $user = $this->user->find(Auth::id());

            $checkPassword = Auth::attempt(array(
                'password' =>$oldPassword
            ));

            if($checkPassword){
                $user->password = Hash::make($newPassword);
                if($user->save()){
                    \Session::flash('notice','Successfully changed password');
                    return redirect()->back()->withInput();
                }else{
                    \Session::flash('notice','Cannot change password');
                    return redirect()->back()->withInput();
                }
            }else{

                \Session::flash('notice','Incorrect Password');
                return redirect()->back()->withInput();
            }
        }
    }


    public function attendance(){
//        $result = $this->user->all();
        $users = $this->user->where('designation','=','Employee')->get();
        $date_range=new DateRange();
        $var=array();
        foreach($users as $user){
//            echo $user->first_name;
            $leave_date=$user->leaves()->get();
            foreach($leave_date as $le_date){
                $range=$date_range->date_range($le_date->start_date,$le_date->end_date);
                $flag=$date_range->date_cal($range,date('d/m/Y'));
                if($flag){
                    $user_id=$user->id;
                }
            }
            if(isset($user_id)){
               if($user_id!=$user->id){
                    array_push($var,$user);
                }
            }
            else{
                array_push($var,$user);
            }
        }
    return view('oms.pages.attendance')->with('result',$var);
    }

    public function ajax_users(){
        if(Request::ajax()){
            $users = $this->user->where('designation','=','Employee')->get();
            $date_range=new DateRange();
            $var=array();
            foreach($users as $user){
                $leave_date=$user->leaves()->get();
                foreach($leave_date as $le_date){
                    $range=$date_range->date_range($le_date->start_date,$le_date->end_date);
                    $flag=$date_range->date_cal($range,date('d/m/Y',strtotime(Input::get('date'))));
                    if($flag){
                        $user_id=$user->id;
                    }
                }
                if(isset($user_id)){
                    if($user_id!=$user->id){
                        array_push($var,$user);
                    }
                }else{
                    array_push($var,$user);
                }
            }
            $date=Input::get('date');
            return Response::json($var);
        }
        else{
            return Response::json(array('error'));
        }

    }

    public function notice($id){
        $noticeList = new Notice();
        $result = $noticeList->where('id',$id)->get();
        return view('oms.pages.notice')->with('result',$result);
    }

    public function deletenotice($id){
        $notice = new Notice();
        $not = $notice->find($id);
        if($not->delete()){
            \Session::flash('note', 'Deleted');
            return redirect()->back();
        }else{
            \Session::flash('note', 'Cannot be Deleted');
            return redirect()->back();
        }
    }

    public function broadcastprocess(){
        $notice = new Notice();
        $notice->notice = Input::get('message');
        $notice->user_id = Auth::id();

        if($notice->save()){
            \Session::flash('notice','Successfully broadcasted!');
            return Redirect::to('/dashboard');
        }else{
            \Session::flash('notice','Cannot be saved!');
            return Redirect::to('/dashboard');
        }
    }

    public function noticehistory(){
        $notice = new Notice();
        $result = $notice->all();
        return view('oms.pages.noticehistory')->with('result',$result);
    }

    public function addusers(Requests\UserRequest $userRequest){
        $oldUsername = $this->user->select('username')->orderBy('id','desc')->first();
        $processUsername = substr($oldUsername->username,4);
        $newUsername = 'user'.($processUsername+1);
        $password = $newUsername;
        $this->user->first_name = $userRequest['firstName'];
        $this->user->middle_name = $userRequest['middleName'];
        $this->user->last_name = $userRequest['lastName'];
        $this->user->joined_date = date('Y-m-d',strtotime(Input::get('joined_date')));
        $this->user->email = $userRequest['email'];
        $this->user->username = $newUsername;
        $this->user->password = \Hash::make($password);
        $this->user->designation = $userRequest['designation'];

       if($this->user->save()){
           $user = $this->user->where('username',$newUsername)->get();
           $this->userProfile->profile_picture = 'img/user.bmp';
           $this->userProfile->user_id = $user[0]->id;
           $this->userProfile->save();
//        if($this->user->save()){
//            $user=$this->user->where('email',$userRequest['email'])->get();
//            $this->user->first_name = $userRequest['firstName'];
//            $this->user->middle_name = $userRequest['middleName'];
//            $this->user->last_name = $userRequest['lastName'];
//            $this->user->user_id = $user[0]->id;
//        }

               \Session::flash('notice','User successfully created with username: '.$newUsername);
               return Redirect::to('/users');
//            }else{
//               \Session::flash('notice','Cannot be saved!');
//                return Redirect::to('/users');
//            }
       }
    }

    public function edituser($id){
        echo $id;
    }

    public function deleteuser($id){
        $user = $this->user->find($id);
        $name = $user->first_name;
        if($user->delete()){
            \Session::flash('notice','Successfully removed ' . $name);
            return Redirect::to('/users');
        }else{
            \Session::flash('notice','Cannot remove ' . $name);
            return Redirect::to('/users');
        }
    }

    public function makeAttendance(Requests\Attendance $attendance){

        $var=array();
        $emp=Input::get('empName');

        $i=0;
        $users=$this->user->where('designation','=','Employee')->get();
        foreach($users as $user){

            $var[$i]['attendance_date']=date('Y-m-d',strtotime($attendance['date']));
            foreach($emp as $em){

                if($em==$user->id){
                    $var[$i]['presence']=1;
                    break;
                }
                else{
                    $var[$i]['presence']=0;

                }
            }
            $var[$i]['user_id']=$user->id;
//            var_dump($var);
//            echo $var[$i]['user_id'] . "-";
//            echo $var[$i]['presence'] . "<br><br>";
            $i++;

//            if($this->attendance->create($var)){
//                unset($var);
//                $var=array();
//            }
        }
        $this->attendance->insert($var);

//        $var = array();
//        die;
        \Session::flash('attendance','Successfully performed attendance');
        return redirect()->intended('/attendance');
    }

    public function viewAttendance(){

        $users = $this->user->where('designation','=','Employee')->get();
        $date_range=new DateRange();
        $var=array();
        foreach($users as $user){
//            echo $user->first_name;
            $leave_date=$user->leaves()->get();
            foreach($leave_date as $le_date){
                $range=$date_range->date_range($le_date->start_date,$le_date->end_date);
                $flag=$date_range->date_cal($range,date('d/m/Y'));
                if($flag){
                    $user_id=$user->id;
                }
                unset($flag);
            }
            if(isset($user_id)){
                if($user_id!=$user->id){
                    array_push($var,$user);
                }
            }
            else{
                array_push($var,$user);
            }
        }

        if(Input::get('date')==""){
            \Session::flash('attendance','Please choose a date first!');
            return Redirect::to('/attendance');
//            \Session::flash('attendance','Attendance of '.Input::get('date').":");
        }else{
            $date = date('Y-m-d',strtotime(Input::get('date')));
            $day = date('d',strtotime(Input::get('date')));
//            var_dump($date);
            $attendance = new Attendance();
//            $result = $attendance->where(MONTH('attendance_date'), '=', $month)->get();
//            $result = Attendance::select("SELECT * FROM attendances WHERE MONTH('attendance_date')= " . $month ."");
//            $result = \DB::select("SELECT * FROM attendances WHERE MONTH('attendance_date')= '" . $month ."'");
            $att = \DB::select("SELECT * FROM attendances JOIN users ON attendances.user_id=users.id WHERE designation = 'Employee' AND DATE_FORMAT(attendance_date,'%d')= '" . $day ."' ");
//            var_dump($att);
            return view('oms.pages.attendance')->with('result',$var)->with('att',$att);
        }
    }

    public function viewEmpAttendance(Requests\ViewEmpAttendance $empAttendance){
        $year = $empAttendance['year'];
        $month = $empAttendance['month'];

        $user = $this->user->find(Auth::id());
//        $attendance = $user->join('attendances','users.id','=','attendances.user_id')->where('attendances.user_id',$user->id)->where(DATE_FORMAT('attendances.attendance_date)',$year))->get();
        $attendance = \DB::select("SELECT * FROM users INNER JOIN attendances ON users.id = attendances.user_id WHERE users.id ='".$user->id."' AND DATE_FORMAT(attendance_date,'%Y')='".$year."' AND DATE_FORMAT(attendance_date,'%m')='".$month."'");
        return view('oms.pages.attendance')->with('empattendance',$attendance);
//        return redirect()->back()->with('empattendance',$attendance);

    }

    public function select_user(){
            $start_date=Input::get('date');
            $complete_date=Input::get('date1');
            $TaskRange=$this->dateRange->date_range($start_date,$complete_date);
            $users = $this->user->all();
            $ranges=array();
            $user_profile=array();
//            $leave_date=$users[0]->leaves()->get();
            foreach($users as $user){
                $leave_date=$user->leaves()->get();
                foreach($leave_date as $le_date){
                    array_push($ranges,$this->dateRange->date_range($le_date->start_date,$le_date->end_date));
                }
//                $flag=false;
                foreach($ranges as $range){
                    $flag=$this->dateRange->date_diff_task_leave($TaskRange,$range);
                }
                var_dump($flag);
//                $flag=false;
                if($flag!=true){
                    array_push($user_profile,array($user->id,$user->first_name,$user->middle_name,$user->last_name));
                }
                unset($range);
                unset($flag);
                $range=array();
            }
//            var_dump($user_profile);
            return Response::json($user_profile);

    }
    public function assigntask(Requests\TaskRequest $taskRequest){
        $task = new Task();
        $task->task_name = $taskRequest['taskName'];
        $task->task_description = $taskRequest['taskDescription'];
        $task->assigned_date = date('Y-m-d',strtotime($taskRequest['startingDate']));
        $task->completion_date = date('Y-m-d',strtotime($taskRequest['endingDate']));
        $taskRange = $this->dateRange->date_range($task->assigned_date,$task->completion_date);
        $task->slug = $taskRequest['slug'];
        $flag=false;
        $empNames = $taskRequest['empName'];
        $users = $this->user->where('designation','=','Employee')->get();
//        var_dump($empNames);
        $var=array();
        $leave_user = array(); //for users in leave
        $var2 = array(); //for users not in leave
        $notLeave = array();
        foreach($empNames as $empName) {
            $user=$this->user->find($empName);
            $leaves = $user->leaves()->get();//User That are in Leave
//            var_dump($leaves);
            if($leaves->isEmpty()){
                array_push($notLeave,$user);
            }
            else{
                array_push($leave_user,$user);
            }
        }
        foreach($leaves as $leave){
            $start_date = $leave->start_date;
            $end_date = $leave->end_date;
            $leaveRange = $this->dateRange->date_range($start_date,$end_date);
            $flag = $this->dateRange->date_diff_task_leave($taskRange,$leaveRange);
            if($flag){
                array_push($var,$user->id);
                break;
            }
        }
        if(empty($var)){
            if($task->save()){
                $task->users()->attach($empNames);
                \Session::flash('notice','Task Assigned');
                return Redirect::back();
            }
        }
        else{
            \Session::flash('notice','Certain User are Absent');
            return Redirect::back()->withInput();
        }
    }

    public function deletetask($id){
        $delete = $this->task->find($id);
        if($delete->delete()){
            \Session::flash('notice', 'Successfully deleted task');
            return Redirect::to('/tasks');
        }else{

            \Session::flash('notice', 'Cannot delete task');
            return Redirect::to('/tasks');
        }
    }

    public function logout(){
        Auth::logout();
        return redirect()->intended('/');
    }


}
