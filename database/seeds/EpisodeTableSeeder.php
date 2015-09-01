<?php

use Illuminate\Database\Seeder;
use App\Models\Episode;
use App\Models\Download;

class EpisodeTableSeeder extends Seeder {

	public function run() {
		Episode::create([
			'anime_id' => 1,
			'title' => 'Sayonara',
			'num' => 22,
			'type' => 'episodio',
		]);

		factory(App\Models\Episode::class, 30)->create();
		factory(App\Models\Download::class, 90)->create();
	}
}
