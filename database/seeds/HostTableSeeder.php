<?php

use App\Models\Host;
use Illuminate\Database\Seeder;

class HostTableSeeder extends Seeder {

	public function run() {
		Host::create([
			'name' => 'MEGA',
			'icon' => '/img/hosts/mega.png',
			'regex' => '(mega.(nz|co.nz))',
			'regex_offline' => NULL,
		]);

		Host::create([
			'name' => 'Google Drive',
			'icon' => '/img/hosts/google-drive.png',
			'regex' => '((drive|docs).google.com)',
			'regex_offline' => NULL,
		]);
	}
}
