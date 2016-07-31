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
			$table->string('anime');
			$table->string('type', 16);
			$table->unsignedInteger('num');
			$table->string('title');
			$table->timestamps();

			$table->unique([ 'anime', 'type', 'num' ]);
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
