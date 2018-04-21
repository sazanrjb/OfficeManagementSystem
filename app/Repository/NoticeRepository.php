<?php

namespace App\Repository;


use App\Notice;

class NoticeRepository
{
    /**
     * @param null $limit
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function get($limit = null)
    {
        $notice = resolve(Notice::class);
        $query = $notice->with('users');

        if ($limit) {
            $query->take($limit);
        }

        return $query->get();
    }
}