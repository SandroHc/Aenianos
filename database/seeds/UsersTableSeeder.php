<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder {

	public function run() {
		Eloquent::unguard();

		User::create([
			'name' => 'SandroHc',
			'email' => 'sandro123iv@gmail.com',
			'password' => Hash::make('biscoitos123'),
		]);

		Eloquent::reguard();
	}
}
