<?php

namespace App\Oms\User\Models;

use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    protected $table = 'user_profiles';

    public function user(){
        return $this->belongsTo('App\User','user_id');
    }

}