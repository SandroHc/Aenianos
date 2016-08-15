<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		Model::unguard();

		$this->call(UsersTableSeeder::class);
		$this->call(NewsCategoryTableSeeder::class);
		$this->call(HostTableSeeder::class);

		$this->call(AnimeTableSeeder::class);
		$this->call(EpisodeTableSeeder::class);
		$this->call(DownloadTableSeeder::class);
		$this->call(NewsTableSeeder::class);

		Model::reguard();
	}
}