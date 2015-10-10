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
			$table->string('type', 20);
			$table->unsignedInteger('num');
			$table->string('host_id');
			$table->string('link');
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
	}
}
