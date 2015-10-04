<?php

class UserTest extends TestCase {

	public function testAddUser() {
		$user = factory(App\User::class)->create();

		$this->assertNotNull($user);

		$user->forceDelete();
	}

	public function testAdmin() {
		$user = factory(App\User::class)->create();

		// User should NOT be admin by default
		$this->assertFalse($user->admin);

		$user->admin = true;
		$user->save();
		$this->assertTrue($user->admin); // User should now be admin

		$user->admin = false;
		$user->save();
		$this->assertFalse($user->admin); // User should NOT be admin again

		$user->forceDelete();
	}
}
