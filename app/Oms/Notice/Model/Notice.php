<?php

namespace App\Oms\Notice\Model;

use Illuminate\Database\Eloquent\Model;

class Notice extends Model
{
    protected $table = 'notices';

    protected $fillable = [
        'notice'
    ];
}