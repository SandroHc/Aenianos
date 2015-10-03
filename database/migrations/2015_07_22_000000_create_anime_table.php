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

			$table->string('status', 100)->default('Em lançamento');
			$table->date('airing_date')->nullable();
			$table->string('airing_week_day', 20)->nullable();

			$table->unsignedInteger('episodes')->default(0);
			$table->string('genres', 100);

			$table->string('producer', 100);
			$table->string('director', 100);
			$table->string('website', 255);

			$table->string('codec_video', 100);
			$table->string('codec_audio', 100);
			$table->string('subtitles_type', 50);
			$table->unsignedInteger('coordinator');
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
