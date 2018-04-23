<?php

namespace App\Http\Controllers\Attendance;

use App\Http\Controllers\AuthController;
use App\Oms\Attendance\Manager;
use Illuminate\Http\Request;

class GetByMonthAndYearForUser extends AuthController
{
    public function __invoke(Request $request, Manager $attendanceManager)
    {
        $dateDetails = $request->validate([
           'year' => 'required',
           'month' => 'required'
        ]);

        $attendance = $attendanceManager->getByMonthAndYearForUser($request->user(), $dateDetails);
        return view('oms.pages.attendance')->with('empattendance', $attendance);
    }
}