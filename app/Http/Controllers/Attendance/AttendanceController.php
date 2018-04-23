<?php

namespace App\Http\Controllers\Attendance;

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use App\Oms\Attendance\Manager;
use Illuminate\Support\Facades\Session;

/**
 * Class AttendanceController
 * @package App\Http\Controllers\Attendance
 */
class AttendanceController extends AuthController
{
    /**
     * @var Manager
     */
    protected $attendanceManager;

    /**
     * AttendanceController constructor.
     * @param Manager $attendanceManager
     */
    public function __construct(Manager $attendanceManager)
    {
        $this->attendanceManager = $attendanceManager;
    }

    /**
     * @return $this
     */
    public function index()
    {
        $attendances = $this->attendanceManager->all();
        return view('oms.pages.attendance')->with('result', $attendances);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $attendanceDetails = $request->validate([
            'empName' => 'required',
            'date' => 'required|date'
        ]);

        $this->attendanceManager->create($attendanceDetails);
        Session::flash('attendance', 'Successfully performed attendance');
        return redirect()->intended('/attendances');
    }
}