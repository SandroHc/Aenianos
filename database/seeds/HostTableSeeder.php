<?php

use Illuminate\Database\Seeder;

class HostTableSeeder extends Seeder {

	public function run() {
		factory(App\Models\Host::class, 4)->create();
	}
}
