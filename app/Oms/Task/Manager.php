<?php

namespace App\Oms\Task;

use App\Oms\Core\Services\DateRange;
use App\Oms\Task\Exceptions\TaskNotFoundException;
use App\Oms\Task\Models\Task;
use App\Oms\User\Manager as UserManager;
use Carbon\Carbon;

/**
 * Class Manager
 * @package App\Oms\Task
 */
class Manager
{
    /**
     * @var Task
     */
    private $task;

    private $dateRange;

    private $userManager;

    /**
     * Manager constructor.
     * @param Task $task
     */
    public function __construct(
        Task $task,
        DateRange $dateRange,
        UserManager $userManager
    ) {
        $this->task = $task;
        $this->dateRange = $dateRange;
        $this->userManager = $userManager;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function find($id)
    {
        $task = $this->task->find($id);
        throw_if(!$task, new TaskNotFoundException(sprintf('Task with id %s not found.', $id)));

        return $task;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function all()
    {
        return $this->task->all();
    }

    public function create(array $taskDetails)
    {
        $taskDetails['assigned_date'] = Carbon::parse($taskDetails['assigned_date']);
        $taskDetails['completion_date'] = Carbon::parse($taskDetails['completion_date']);
        $task = $this->task->newInstance();
        $task->fill($taskDetails);
        $taskRange = $this->dateRange->date_range(
            $taskDetails['assigned_date'],
            $taskDetails['completion_date']
        );
        $empNames = $taskDetails['emp_name'];
        $leave_user = array(); //for users in leave
        $absentees = [];
        $notLeave = [];
        foreach ($empNames as $empName) {
            $user = $this->userManager->find($empName);
            $leaves = $user->leaves()->get(); //User That are in Leave
            if ($leaves->isEmpty()) {
                array_push($notLeave, $user);
            } else {
                array_push($leave_user, $user);
            }
        }
        foreach ($leaves as $leave) {
            $start_date = $leave->start_date;
            $end_date = $leave->end_date;
            $leaveRange = $this->dateRange->date_range($start_date, $end_date);
            if ($this->dateRange->date_diff_task_leave($taskRange, $leaveRange)) {
                array_push($absentees, $user->id);
                break;
            }
        }
        if (!count($absentees)) {
            if ($task->save()) {
                $task->users()->attach($empNames);
                return true;
            }
        }
        return false;
    }

    public function delete(Task $task)
    {
        return $task->delete();
    }
}