<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Complaint extends Model {

	protected $table = 'complaints';

    public function getEmpName($id){
        $comp = User::find($id);

        return $comp;
    }

}
