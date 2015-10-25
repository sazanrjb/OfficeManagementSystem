<?php
/**
 * Created by PhpStorm.
 * User: dell3542
 * Date: 7/10/15
 * Time: 1:02 PM
 */

namespace App\Repository;


class NoticeRepository {
    public function getAll(){
        $notice = new \App\Notice();
        return $notice->with('users')->get();
    }

}