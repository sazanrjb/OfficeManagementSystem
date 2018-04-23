<?php

namespace App\Http\Controllers\Attendance;

use App\Http\Controllers\AuthController;
use App\Oms\Attendance\Manager;
use Illuminate\Http\Request;

class GetByDateController extends AuthController
{
    public function __invoke(Request $request, Manager $attendanceManager)
    {
        $attendanceDetails = $request->validate([
           'date' => 'required|date'
        ]);
        [$var, $att] = $attendanceManager->getByDate($attendanceDetails);
        return view('oms.pages.attendance')->with('result', $var)->with('att', $att);
    }
}