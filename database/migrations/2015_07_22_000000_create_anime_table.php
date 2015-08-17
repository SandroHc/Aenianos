<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnimeTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('anime', function (Blueprint $table) {
			$table->increments('id');
			$table->string('title');
			$table->string('slug');
			$table->text('synopsis')->default('');
			$table->string('cover')->default('');
			$table->string('cover_offset')->default(0);
			$table->string('official_cover')->default('');
			$table->string('status', 100)->default('Em andamento');
			$table->unsignedInteger('episodios_total')->default(0);
			$table->timestamps();
			$table->softDeletes();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('anime');
	}
}
