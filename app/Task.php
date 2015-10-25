<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model {

	protected $table = 'tasks';

    public function users(){
        return $this->belongsToMany('App\User','user_task','task_id','user_id');
    }

}
