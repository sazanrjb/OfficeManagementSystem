<?php

namespace App\Oms\Notice\Queries;


use App\Oms\Notice\Model\Notice;

/**
 * Class ListNotice
 * @package App\Oms\Notice\Queries
 */
class ListNotices
{
    /**
     * @var Notice
     */
    private $notice;

    /**
     * ListNotice constructor.
     * @param Notice $notice
     */
    public function __construct(Notice $notice)
    {
        $this->notice = $notice;
    }

    /**
     * @return mixed
     */
    public function baseQuery()
    {
        return $this->notice->join('users', 'users.id', 'notices.user_id')
            ->select(
              'notices.id',
              'notices.notice',
              'notices.created_at',
              'users.id as user_id',
              'users.first_name',
              'users.middle_name',
              'users.last_name'
            );
    }

    /**
     * @return mixed
     */
    public function all()
    {
        return $this->baseQuery()->get();
    }
}