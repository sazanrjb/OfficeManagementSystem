<?php

namespace App\Oms\Task\Models;

use App\Oms\User\Models\User;
use Illuminate\Database\Eloquent\Model;

class Task extends Model {

    protected $table = 'tasks';

    protected $fillable = [
        'task_name',
        'task_description',
        'assigned_date',
        'completion_date',
        'slug'
    ];

    public function users(){
        return $this->belongsToMany(User::class,'user_task','task_id','user_id');
    }

}