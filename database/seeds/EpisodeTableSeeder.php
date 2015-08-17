<?php

use Illuminate\Database\Seeder;
use App\Models\Episode;
use App\Models\Download;

class EpisodeTableSeeder extends Seeder {

	public function run() {
		for($i = 1; $i <= 22; $i++) {
			if($i != 22) {
				$data = [
					'anime_id' => 1,
					'numero' => $i,
					'type' => 'episodio',
				];
			} else {
				$data = [
					'anime_id' => 1,
					'titulo' => 'Sayonara',
					'numero' => $i,
					'nota' => 'v2',
					'type' => 'episodio',
				];
			}

			Episode::create($data);
		}

		Download::create([
			'episode_id' => 21,
			'host_nome' => 'MEGA',
			'host_link' => 'http://mega.nz',
			'qualidade' => 'BD',
			'tamanho' => '2 fiddy',
		]);

		Download::create([
			'episode_id' => 22,
			'host_nome' => 'MEGA',
			'host_link' => 'http://mega.nz',
			'qualidade' => 'BD',
			'tamanho' => '3 fiddy',
		]);

		Download::create([
			'episode_id' => 22,
			'host_nome' => 'MEGA',
			'host_link' => 'http://mega.nz',
			'qualidade' => 'HD',
			'tamanho' => '3 fiddy',
		]);

//		for($i = 0; $i < 30; $i++) {
//			factory(App\Models\Episode::class)->make();
//		}
//
//		for($i = 0; $i < 90; $i++) {
//			factory(App\Models\Download::class)->make();
//		}
	}
}
