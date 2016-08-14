<?php

use Illuminate\Database\Seeder;
use App\Models\Anime;
use App\Models\Episode;

class AnimeTableSeeder extends Seeder {

	public function run() {
		$this->seedFromFile();
		//factory(Anime::class, 10)->create();
	}

	public function seedFromFile($filename = 'database/seeds/anime_dump.json') {
//		\Illuminate\Support\Facades\Log::debug('cwd: ' . getcwd());
		$text = file_get_contents($filename);
		$json = json_decode($text, true);

		//var_dump($json);

		$faker = Faker\Factory::create();
		$uploads_dir = "/img/upload/";
		$uploads = NULL;
		if(file_exists('public' . $uploads_dir)) // Check if the upload folder exists
			$uploads = scandir('public' . $uploads_dir);

		foreach($json['anime'] as $node) {
			if(!isset($node['title'])) continue;

			$anime = new \App\Models\Anime();
			$anime->title = $node['title'];
			if(isset($node['japanese'])) $anime->japanese = $node['japanese'];
			if(isset($node['synopsis'])) $anime->synopsis = $node['synopsis'];
			//if(isset($node['episodes_total'])) $anime->episodes = $node['episodes_total'];
			if(isset($node['premiered'])) $anime->premiered = $node['premiered'];
			if(isset($node['status'])) $anime->status = $node['status'];

			foreach($uploads as $file) {
				$filename = pathinfo($file)['filename'];

				if(empty($anime->cover) && $filename === $anime->slug . '-cover') {
					$anime->cover = $uploads_dir . $file;
					$anime->cover_offset = 0;
					optimize_image('public' . $anime->cover, 'public/' . get_optimized_path($anime->cover));
				}

				if(empty($anime->official_cover) && $filename === $anime->slug . '-cover-official') {
					$anime->official_cover = $uploads_dir . $file;
					optimize_image('public' . $anime->official_cover, 'public/' . get_optimized_path($anime->official_cover));
				}
			}

			$anime->save();

//			echo "ANIME:", $anime->title, '<br>';

			if(isset($node['episodes'])) {
				static $ep_types = [ 'Episódio', 'Especial', 'Filme' ];
				foreach($ep_types as $type) {
					if(!isset($node['episodes'][$type])) continue;

					$num = 0;
					foreach($node['episodes'][$type] as $ep_node) {
						$ep = new \App\Models\Episode();
						$ep->anime = $anime->slug;
						$ep->type = $type;
						$ep->num = isset($ep_node['num']) ? $ep_node['num'] : ++$num;

						if(isset($ep_node['title']))
							$ep->title = $ep_node['title'];

						$ep->save();

//						echo "EP:", $ep->type, ':', $ep->num, ':', $ep->title, '<br>';

						$this->createDownloads($faker, $ep->id);
					}
				}
			}
		}
	}

	public function createDownloads($faker, $ep_id) {
		static $hosts = [ 'http://mega.nz/', 'https://drive.google.com/file/d/0B8KL1BNoXI0jblotVS1YQkE3TEE/view?usp=sharing', 'http://example.com/' ];

		for($i=0; $i < $faker->numberBetween(0,3); $i++) {
			$host = $faker->numberBetween(1,3);
			$quality = $faker->randomElement([ 'BD', 'HD', 'SD' ]);

			$dl = new \App\Models\Download();
			$dl->episode_id = $ep_id;
			$dl->link = $hosts[$host-1] . $quality;
			$dl->host_id = $host;
			$dl->quality = $quality;
			$dl->size = $faker->biasedNumberBetween(50, 500);
			$dl->save();

//				echo "DL!<br>";
		}
	}
}
