<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use App\User;

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Model::unguard();

		$this->call('UsersTableSeeder');
	}
}

class UsersTableSeeder extends Seeder {

	public function run()
	{
		DB::table('Operateri')->delete();

		$user = new User;
		$user->Username = 'Sasa';
		$user->Email = 'sasa.muhtic@gmail.com';
		$user->Password = Hash::make('Sasa');
		$user->save();

		$user = new User;
		$user->Username = 'Marko';
		$user->Email = 'sasa.muhtic2@gmail.com';
		$user->Password = Hash::make('Sasa');
		$user->save();

		$user = new User;
		$user->Username = 'Titan';
		$user->Email = 'sasa.muhtic3@gmail.com';
		$user->Password = Hash::make('Sasa');
		$user->save();

		$user = new User;
		$user->Username = 'Kosta';
		$user->Email = 'sasa.muhtic4@gmail.com';
		$user->Password = Hash::make('Sasa');
		$user->save();

	}
}