<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDownloadTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('downloads', function(Blueprint $table) {
			$table->increments('id');
			$table->unsignedInteger('episode_id');
			$table->string('host_id');
			$table->string('link');
			$table->string('quality');
			$table->string('size');
			$table->timestamps();

			//$table->foreign('episode_id')->references('id')->on('episodes');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('downloads');
	}
}
