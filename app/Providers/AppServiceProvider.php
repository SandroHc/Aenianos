<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider {
	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot() {
		// Used to allow date's localized formatting
		date_default_timezone_set('America/Sao_Paulo');

		setlocale(LC_TIME, 'pt');
		Carbon::setLocale('pt_BR');
	}

	/**
	 * Register any application services.
	 *
	 * @return void
	 */
	public function register() {
		//
	}
}
