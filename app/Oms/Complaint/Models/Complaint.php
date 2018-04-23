<?php

namespace App\Oms\Complaint\Models;


use App\Oms\User\Models\User;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Complaint
 * @package App\Oms\Complaint\Models
 */
class Complaint extends Model
{
    /**
     * @var string
     */
    protected $table = 'complaints';

    /**
     * @var array
     */
    protected $fillable = ['complaint'];

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