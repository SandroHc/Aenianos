<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder {

	public function run() {
		User::create([
			'name' => 'admin',
			'email' => 'admin@mail.com',
			'password' => Hash::make('admin'),
		]);
	}
}
