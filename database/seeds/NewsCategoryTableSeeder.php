<?php

use Illuminate\Database\Seeder;
use App\Models\NewsCategory;

class NewsCategoryTableSeeder extends Seeder {

	public function run() {
		NewsCategory::create(['name' => 'Geral', 'description' => '']);
		NewsCategory::create(['name' => 'Atualizações', 'description' => '']);
	}
}
