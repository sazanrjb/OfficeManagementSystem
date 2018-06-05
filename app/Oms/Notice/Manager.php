<?php

namespace App\Oms\Notice;


use App\Oms\Notice\Exceptions\NoticeNotDeletedException;
use App\Oms\Notice\Exceptions\NoticeNotFoundException;
use App\Oms\Notice\Model\Notice;

/**
 * Class Manager
 * @package App\Oms\Notice
 */
class Manager
{
    /**
     * @var Notice
     */
    protected $notice;

    /**
     * Manager constructor.
     * @param Notice $notice
     */
    public function __construct(Notice $notice)
    {
        $this->notice = $notice;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getDetail($id)
    {
        $notice = $this->notice->join('users', 'users.id', 'notices.user_id')
            ->where('notices.id', $id)
            ->select(
                'notices.id',
                'notices.notice'
            )
            ->first();

        throw_if(!$notice, new NoticeNotFoundException(
            sprintf('Notice with id %s not found.', $id)
        ));

        return $notice;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function find($id)
    {
        $notice = $this->notice->find($id);
        throw_if(!$notice, new NoticeNotFoundException(
            sprintf('Notice with id %s not found.', $id)
        ));

        return $notice;
    }

    public function create(array $noticeDetails)
    {
        return $this->notice->fill($noticeDetails)
            ->forceFill(['user_id' => $noticeDetails['user_id']])
            ->save();
    }

    /**
     * @param Notice $notice
     * @return bool
     */
    public function delete(Notice $notice)
    {
        throw_if(!$notice->delete(), new NoticeNotDeletedException(
            sprintf('Notice with id %s not deleted.', $notice->id)
        ));

        return true;
    }
}