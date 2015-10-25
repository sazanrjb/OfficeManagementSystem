<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Leave extends Model {

	protected $table = 'leaves';

    public function user(){
        return $this->belongsTo('App\User','user_id');
    }

}
