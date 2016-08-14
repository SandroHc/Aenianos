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
		], 'public/js/build/app-main.js')
		.coffee([
			'anime-editor.coffee'
		], 'public/js/build/anime-editor.js');
});
