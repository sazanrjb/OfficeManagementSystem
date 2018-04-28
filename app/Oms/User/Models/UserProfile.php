<?php

namespace App\Oms\User\Models;

use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    protected $table = 'user_profiles';

    protected $fillable = [
        'address',
        'contact',
        'profile_picture',
        'gender'
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

}