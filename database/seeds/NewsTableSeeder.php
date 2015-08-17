<?php

use Illuminate\Database\Seeder;
use App\Models\News;

class NewsTableSeeder extends Seeder {

	public function run() {
		News::create([
			'title' => 'Notícia de teste',
			'text' => '<p>Não te importes comigo. Estou apenas a testar.</p>',
			'created_by' => 1,
			'updated_by' => 1,
			'id_category' => 2,
		]);

		News::create([
			'title' => 'Watashi kininarimasu',
			'text' => '<p>E é tudo, por agora!</p>',
			'created_by' => 1,
			'updated_by' => 1,
		]);

//		for($i = 0; $i < 3; $i++) {
//			factory(App\Models\News::class)->make();
//		}
	}
}
