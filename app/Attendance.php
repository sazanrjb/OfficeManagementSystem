<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model {

	protected $table = 'attendances';
    protected $fillable =array('attendance_date','presence','user_id');

}
