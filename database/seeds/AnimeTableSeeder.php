<?php

use Illuminate\Database\Seeder;
use App\Models\Anime;
use App\Models\Episode;

class AnimeTableSeeder extends Seeder {

	public function run() {
		$this->seedFromFile();
		//factory(Anime::class, 10)->create();
	}

	public function seedFromFile($directory = 'database/seeds/anime/') {
		if(file_exists($directory))
			$dir = scandir($directory);
		else
			return;

		//var_dump($json);

		$faker = Faker\Factory::create();
		$uploads_dir = "/img/upload/";
		$uploads = [ ];
		if(file_exists('public' . $uploads_dir)) // Check if the upload folder exists
			$uploads = scandir('public' . $uploads_dir);

		foreach($dir as $filename) {
			if($filename == '.' || $filename == '..')
				continue;

			try {
				$text = file_get_contents($directory . $filename);
				$node = json_decode($text, true);

				if(!isset($node['title'])) continue;

				$anime = new \App\Models\Anime();
				$anime->title = $node['title'];
				if(isset($node['japanese'])) $anime->japanese = $node['japanese'];
				if(isset($node['synopsis'])) $anime->synopsis = $node['synopsis'];
				if(isset($node['episodes_total'])) $anime->episodes = $node['episodes_total'];
				if(isset($node['premiered'])) $anime->premiered = $node['premiered'];
				if(isset($node['status'])) $anime->status = $node['status'];
				if(isset($node['genres'])) $anime->genres = $node['genres'];
				if(isset($node['studio'])) $anime->studio = $node['studio'];
				if(isset($node['director'])) $anime->director = $node['director'];
				if(isset($node['website'])) $anime->website = $node['website'];

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

				if(isset($node['episodes'])) {
					$num = 0;
					foreach($node['episodes'] as $type => $episodes_node) {
						foreach($episodes_node as $ep_node) {
							$ep = new \App\Models\Episode();
							$ep->anime = $anime->slug;
							$ep->type = $type;
							$ep->num = isset($ep_node['num']) ? $ep_node['num'] : ++$num;
							if(!empty($ep_node['title'])) $ep->title = $ep_node['title'];
							$ep->save();

							if(isset($ep_node['dl'])) {
								foreach($ep_node['dl'] as $dl_node) {
									if(!isset($dl_node['quality']) || !isset($dl_node['link']))
										continue;

									$dl = new \App\Models\Download();
									$dl->episode_id = $ep->id;
									$dl->quality = $dl_node['quality'];
									$dl->link = $dl_node['link'];
									$dl->save();
								}
							} else {
								$this->createDownloads($faker, $ep->id);
							}
						}
					}
				}
			} catch (Exception $e) {
				\Illuminate\Support\Facades\Log::error("Error parsing '$filename': " . $e->getMessage());
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
		}
	}
}
