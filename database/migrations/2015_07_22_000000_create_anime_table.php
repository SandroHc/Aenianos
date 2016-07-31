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
			$table->string('original')->nullable();
			$table->string('slug')->unique();
			$table->text('synopsis'); // ->default('')
			$table->string('official_cover')->nullable();
			$table->string('cover')->nullable();
			$table->string('cover_offset')->default(0);

			$table->string('status', 100)->default('Em lançamento');
			$table->date('airing_date')->nullable();
			$table->string('airing_week_day', 20)->nullable();

			$table->unsignedInteger('episodes')->default(0);
			$table->string('genres', 255);

			$table->string('studio', 100)->nullable();
			$table->string('website', 255)->nullable();

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
