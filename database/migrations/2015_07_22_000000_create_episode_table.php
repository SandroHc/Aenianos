<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEpisodeTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('episodes', function(Blueprint $table) {
			$table->increments('id');
			$table->unsignedInteger('anime_id');
			$table->string('type');
			$table->integer('num');
			$table->string('title')->default('');
			$table->timestamps();

			//$table->foreign('anime_id')->references('id')->on('anime');
		});

		Schema::create('downloads', function(Blueprint $table) {
			$table->increments('id');
			$table->unsignedInteger('episode_id');
			$table->string('host_name')->default('');
			$table->string('host_link');
			$table->string('quality')->default('');
			$table->string('size')->default('');
			$table->string('notes')->default('');
			$table->timestamps();

			//$table->foreign('episode_id')->references('id')->on('anime_episodios');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('episodes');
		Schema::drop('downloads');
	}
}
