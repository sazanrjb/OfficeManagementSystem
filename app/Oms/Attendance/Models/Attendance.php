<?php

namespace App\Oms\Attendance\Models;

use App\Oms\User\Models\User;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Attendance
 * @package App\Oms\Attendance
 */
class Attendance extends Model
{
    /**
     * @var string
     */
    protected $table = 'attendances';

    /**
     * @var array
     */
    protected $fillable = ['attendance_date','presence'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * @param User $user
     * @return Model
     */
    public function associateUser(User $user)
    {
        return $this->user()->associate($user);
    }
}