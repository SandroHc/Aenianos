<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHostTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('hosts', function(Blueprint $table) {
			$table->increments('id');
			$table->string('name');
			$table->string('icon')->nullable();
			$table->string('regex')->nullable();
			$table->string('regex_size')->nullable();
			$table->string('regex_link_down')->nullable();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('hosts');
	}
}
