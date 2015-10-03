<?php

use Illuminate\Database\Seeder;
use App\Models\Episode;
use App\Models\Download;

class EpisodeTableSeeder extends Seeder {

	public function run() {
		factory(App\Models\Episode::class, 100)->create();
	}
}
