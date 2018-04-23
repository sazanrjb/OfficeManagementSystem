<?php

namespace App\Oms\Core\Services;

class DateRange
{
    public function date_range($first, $last, $step = '+1 day', $output_format = 'd/m/Y')
    {

        $dates = array();
        $current = strtotime($first);
        $last = strtotime($last);

        while ($current <= $last) {

            $dates[] = date($output_format, $current);
            $current = strtotime($step, $current);
        }

        return $dates;
    }

    public function date_diff($range, $task_range)
    {
        $flag = false;
        for ($i = 0; $i < count($range); $i++) {
            for ($j = 0; $j < count($task_range); $j++) {
                if ($range[$i] == $task_range[$j]) {
                    $flag = true;
                    return $flag;
                    break;
                } else {
                    $flag = false;
                }
            }
        }
        return $flag;
    }

    public function date_cal($range, $task_date)
    {
        for ($i = 0; $i < count($range); $i++) {
            if ($range[$i] == $task_date) {
                return true;
                break;
            } else {
                return false;
            }
        }
    }

    public function date_diff_task_leave($taskRange, $leaveRange)
    {
        $flag = false;
        for ($i = 0; $i < count($taskRange); $i++) {
            for ($j = 0; $j < count($leaveRange); $j++) {
                if ($taskRange[$i] == $leaveRange[$j]) {
                    $flag = true;
                    return $flag;
                    break;
                }
            }
        }
        return $flag;
    }
}