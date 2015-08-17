<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('news', function(Blueprint $table) {
			$table->increments('id');
			$table->string('title');
			$table->string('slug');
			$table->longText('text');
			$table->unsignedInteger('id_category')->default(1); // Foreign key linking to "newsCategory" table
			$table->unsignedInteger('created_by')->default(0); // Foreign key linking to "newsCategory" table
			$table->unsignedInteger('updated_by')->default(0); // Foreign key linking to "newsCategory" table
			$table->timestamps();
			$table->softDeletes();

			//$table->foreign('categoria')->references('id')->on('noticias_categorias');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('news');
	}
}
