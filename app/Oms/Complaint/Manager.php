<?php

namespace App\Oms\Complaint;

use App\Oms\Complaint\Exceptions\ComplaintNotFoundException;
use App\Oms\Complaint\Models\Complaint;
use App\Oms\User\Models\User;

/**
 * Class Manager
 * @package App\Oms\Complaint
 */
class Manager
{
    /**
     * @var Complaint
     */
    private $complaint;

    /**
     * Manager constructor.
     * @param Complaint $complaint
     */
    public function __construct(Complaint $complaint)
    {
        $this->complaint = $complaint;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function find($id)
    {
        $complaint = $this->complaint->find($id);
        throw_if(!$complaint, new ComplaintNotFoundException());
        return $complaint;
    }

    /**
     * @param $id
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null|static|static[]
     */
    public function getDetail($id)
    {
        return $this->complaint->with('user')->find($id);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function all()
    {
        return $this->complaint->with('user')->get();
    }

    /**
     * @param array $complaintDetails
     * @param User $user
     * @return bool
     */
    public function create(array $complaintDetails, User $user)
    {
        return $this->complaint->fill($complaintDetails)
            ->associateUser($user)
            ->save();
    }

    /**
     * @param Complaint $complaint
     * @return bool|null
     */
    public function delete(Complaint $complaint)
    {
        return $complaint->delete();
    }
}