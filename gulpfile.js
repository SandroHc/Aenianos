var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {
    mix
		.sass('app.scss')
		.coffee([
			'main.coffee'
		], 'public/js/build/')
		.coffee([
			'anime-page--modal.coffee'
		], 'public/js/build/anime-page--modal.js')
		.coffee([
			'defer-images.coffee'
		], 'public/js/build/defer-images.js');
});
