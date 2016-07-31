<?php

use Illuminate\Database\Seeder;

class DownloadTableSeeder extends Seeder {

	public function run() {
		factory(App\Models\Download::class, 50)->create();
	}
}
