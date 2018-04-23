<?php

namespace App\Oms\User;


use App\Oms\Core\Services\DateRange;
use App\Oms\User\Exceptions\UserNotFoundException;
use App\Oms\User\Models\User;
use App\Oms\User\Models\UserProfile;
use Illuminate\Support\Facades\Hash;

class Manager
{
    private $user;

    private $userProfile;

    private $dateRange;

    public function __construct(User $user, UserProfile $userProfile, DateRange $dateRange)
    {
        $this->user = $user;
        $this->userProfile = $userProfile;
        $this->dateRange = $dateRange;
    }

    public function all()
    {
        return $this->user->all();
    }

    public function find($id)
    {
        $user = $this->user->find($id);
        throw_if(!$user, new UserNotFoundException(sprintf('User with id %s not found.', $id)));
        return $user;
    }

    public function findByUsername($username)
    {
        $user = $this->user->where('username', $username)->first();
        throw_if(!$user, new UserNotFoundException(sprintf('User with username %s not found.', $username)));
        return $user;
    }

    public function getByDesignation($designation)
    {
        return $this->user->where('designation', $designation)->get();
    }

    public function getRelatedUsernames($username)
    {
        return $this->user->where('username', 'LIKE', $username . '%')
            ->select('id', 'username')
            ->get();
    }

    public function create(array $userDetails)
    {
        $user = $this->user->newInstance();
        $user->fill($userDetails);
        $username = $this->createUserName($userDetails['first_name'] . $userDetails['last_name']);
        $user->forceFill([
            'username' => $username,
            'password' => Hash::make($username),
            'joined_date' => date('Y-m-d', strtotime($userDetails['joined_date']))
        ]);
        $user->save();

        return $user;
    }

    private function createUserName($name)
    {
        $currentUsername = str_slug($name);
        $usernames = $this->getRelatedUsernames($currentUsername);
        if (!$usernames->contains('username', $currentUsername)) {
            return $currentUsername;
        }
        for ($i = 1; $i <= 10; ++$i) {
            $newSlug = $currentUsername . $i;
            if (!$usernames->contains('username', $newSlug)) {
                return $newSlug;
            }
        }
    }

    public function delete(User $user)
    {
        return $user->delete();
    }

    public function getPresentUsersByDate($details)
    {
        $users = $this->getByDesignation(User::EMPLOYEE);
        $presentUsers = array();
        foreach ($users as $user) {
            $leave_date = $user->leaves()->get();
            foreach ($leave_date as $le_date) {
                $range = $this->dateRange->date_range($le_date->start_date, $le_date->end_date);
                $flag = $this->dateRange->date_cal($range, date('d/m/Y', strtotime($details['date'])));
                if ($flag) {
                    $user_id = $user->id;
                }
            }
            if (isset($user_id)) {
                if ($user_id != $user->id) {
                    array_push($presentUsers, $user);
                }
            } else {
                array_push($presentUsers, $user);
            }
        }

        return $presentUsers;

    }
}