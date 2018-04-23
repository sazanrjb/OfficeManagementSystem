<?php

namespace App\Oms\Attendance;

use App\Oms\Attendance\Models\Attendance;
use App\Oms\Core\Services\DateRange;
use App\Oms\User\Manager as UserManager;
use App\Oms\User\Models\User;
use Illuminate\Support\Facades\DB;

/**
 * Class Manager
 * @package App\Oms\Attendance
 */
class Manager
{
    /**
     * @var Attendance
     */
    private $attendance;

    /**
     * @var DateRange
     */
    private $dateRange;

    /**
     * @var UserManager
     */
    private $userManager;

    public function __construct(
        Attendance $attendance,
        DateRange $dateRange,
        UserManager $userManager
    )
    {
        $this->attendance = $attendance;
        $this->dateRange = $dateRange;
        $this->userManager = $userManager;
    }

    /**
     * @return array
     */
    public function all()
    {
        $users = $this->userManager->getByDesignation(User::EMPLOYEE);
        $date_range = new DateRange();
        $var = array();
        foreach ($users as $user) {
            $leave_date = $user->leaves()->get();
            foreach ($leave_date as $le_date) {
                $range = $date_range->date_range($le_date->start_date, $le_date->end_date);
                $flag = $date_range->date_cal($range, date('d/m/Y'));
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
        return $var;
    }

    /**
     * @param array $attendanceDetails
     * @return array
     */
    public function getByDate(array $attendanceDetails)
    {
        $users = $this->userManager->getByDesignation(User::EMPLOYEE);
        $var = array();
        foreach ($users as $user) {
            $leave_date = $user->leaves()->get();
            foreach ($leave_date as $le_date) {
                $range = $this->dateRange->date_range($le_date->start_date, $le_date->end_date);
                $flag = $this->dateRange->date_cal($range, date('d/m/Y'));
                if ($flag) {
                    $user_id = $user->id;
                }
                unset($flag);
            }
            if (isset($user_id)) {
                if ($user_id != $user->id) {
                    array_push($var, $user);
                }
            } else {
                array_push($var, $user);
            }
        }

        $day = date('d', strtotime($attendanceDetails['date']));
        $att = \DB::select("SELECT * FROM attendances JOIN users ON attendances.user_id=users.id WHERE designation = 'Employee' AND DATE_FORMAT(attendance_date,'%d')= '" . $day . "' ");
        return [
          $var, $att
        ];
    }

    /**
     * @param array $attendanceDetails
     * @return mixed
     */
    public function create(array $attendanceDetails)
    {
        $var = array();
        $i = 0;
        $users = $this->userManager->getByDesignation(User::EMPLOYEE);
        foreach ($users as $user) {
            $var[$i]['attendance_date'] = date('Y-m-d', strtotime($attendanceDetails['date']));
            foreach ($attendanceDetails['empName'] as $em) {
                $var[$i]['presence'] = $em == $user->id ? 1 : 0;
            }
            $var[$i]['user_id'] = $user->id;
            $i++;
        }
        return $this->attendance->insert($var);
    }

    /**
     * @param User $user
     * @param array $dateDetails
     * @return mixed
     */
    public function getByMonthAndYearForUser(User $user, array $dateDetails)
    {
        return DB::select("SELECT * FROM users INNER JOIN attendances ON users.id = attendances.user_id WHERE users.id ='" . $user->id . "' AND DATE_FORMAT(attendance_date,'%Y')='" . $dateDetails['year'] . "' AND DATE_FORMAT(attendance_date,'%m')='" . $dateDetails['month'] . "'");
    }
}