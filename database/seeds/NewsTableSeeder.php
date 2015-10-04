<?php

use Illuminate\Database\Seeder;

class NewsTableSeeder extends Seeder {

	public function run() {
		factory(App\Models\News::class, 11)->create();
	}
}
