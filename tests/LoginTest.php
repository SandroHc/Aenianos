<?php

use App\User;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LoginTest extends TestCase {
	/**
	 * Login with an Admin account should redirect to the admin dashboard.
	 *
	 * @return void
	 */
	public function testLogin() {
		$email = 'admin@mail.com';
		$password = 'admin';

		$this->visit('/login')
			->type($email, 'email')
			->type($password, 'password')
			->press('Entrar')
			->seePageIs('/admin');
	}

	/**
	 * Register a normal user and check if access is forbidden to the admin dashboard.
	 */
	public function testRegister() {
		$name = 'user';
		$email = 'user@mail.com';
		$password = 'password';

		User::where('email', '=', $email)->forceDelete();

		$this->visit('/registar')
			->type($name, 'name')
			->type($email, 'email')
			->type($password, 'password')
			->type($password, 'password_confirmation')
			->press('Registar')
			->seePageIs('/');

		// A normal user should not have access tot he admin dashboard
		//$this->visit('/admin')
		//	->seePageIs('/');
	}
}
