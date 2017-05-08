<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Model::unguard();

		 $this->call('UserTableSeeder');
	}

}

class UserTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->delete();

        \App\User::create(array(
            'first_name'=>'Sajan',
            'middle_name' => '',
            'last_name' => 'Rajbhandari',
            'joined_date'=> Carbon\Carbon::now(),
            'email'=>'sazanrjb@gmail.com',
            'username'=>'sazanrjb',
            'password'=>\Illuminate\Support\Facades\Hash::make('test123'),
            'designation'=>'Administrator'
        ));
    }

}
