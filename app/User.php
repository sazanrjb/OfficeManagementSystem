<?php namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract {

	use Authenticatable, CanResetPassword;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';
    public $timestamps = false;

    const EMPLOYEE = 'employee';
    const ADMIN = 'admin';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['name', 'email', 'password'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['password', 'remember_token'];


    public function notice(){
        return $this->hasMany('App\Notice');
    }

    public function tasks(){
        return $this->belongsToMany('App\Task','user_task','user_id','task_id');
    }

    public function profile(){
        return $this->hasOne('App\UserProfile','user_id');
    }
    public function leaves(){
        return $this->hasMany('App\Leave','user_id');
    }

}

