<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::pattern('id', '\d+');
//Route::pattern('type', '[A-Za-z0-9-]+');
Route::pattern('slug', '[a-z0-9-]+');

Route::bind('anime', function ($value) {
	return \App\Models\Anime::where('slug', '=', $value)->first();
});

Route::bind('news', function ($value) {
	return \App\Models\News::where('slug', '=', $value)->first();
});


Route::any('/', 'GeneralController@home');

Route::get('/logout', 'Auth\LoginController@logout');
Auth::routes();


// Anime-related routes
Route::any('projetos', 				'AnimeController@index');
Route::any('anime', 				'AnimeController@index');

Route::get('anime/create',			'AnimeController@create');
Route::post('anime',				'AnimeController@store');
Route::get('anime/{anime}', 		'AnimeController@show');
Route::get('anime/{anime}/edit',	'AnimeController@edit');
Route::put('anime/{anime}',			'AnimeController@update');
Route::get('anime/{anime}/delete',	'AnimeController@destroyWarning');
Route::delete('anime/{anime}', 		'AnimeController@destroy');


// News-related routes
Route::any('noticias', 					'NewsController@index');

Route::get('noticias/create',			'NewsController@create');
Route::post('noticias',					'NewsController@store');
Route::get('noticias/{news}', 			'NewsController@show');
Route::get('noticias/{news}/edit',		'NewsController@edit');
Route::put('noticias/{news}',			'NewsController@update');
Route::get('noticias/{news}/delete',	'NewsController@destroyWarning');
Route::delete('noticias/{anime}', 		'NewsController@destroy');

Route::any('noticias/categoria/{slug}','NewsController@showNewsByCategory');

// Administration routes
Route::group([ 'middleware' => 'auth', 'prefix' => 'admin' ], function() {
	Route::get('/', 				'AdminController@index');
	Route::get('config', 			'AdminController@config');
	Route::get('rebuild_search',	'GeneralController@rebuildSearch');

	/** News **/
	Route::get('noticias', 'AdminController@showNewsList');

	/** Anime **/
	Route::get('anime',				'AnimeController@admin');

	/** Episodes **/
	// Edit
	Route::put('anime/{anime}/{type}',			'EpisodeController@add');
	Route::get('anime/{anime}/{type}/{num}',	'EpisodeController@manage');
	Route::put('anime/{anime}/{type}/{num}',	'EpisodeController@update');
	Route::put('anime/{anime}/{type}/{num}/link','EpisodeController@addLink');
	Route::delete('anime/link/{id}',			'EpisodeController@deleteLink');
	// Delete
	Route::get('anime/{anime}/{type}/{num}/eliminar',  'EpisodeController@deleteWarning');
	Route::delete('anime/{anime}/{type}/{num}', 'EpisodeController@delete');

	/** Episode downloads */
	Route::get('anime/{anime}/raw',  'AdminController@showEpisodeRaw');
	Route::post('anime/{anime}/raw', 'EpisodeController@parseRawEpisodeDownloads');

	/** Users **/
	Route::get('utilizadores', 'UserController@index');

	/** Notifications **/
	Route::any('notificações', 'NotificationController@index');
	Route::any('notificações/send', 'NotificationController@send');

	/** Misc **/
	Route::post('upload', 'GeneralController@upload');
});

Route::get('perfil', 'UserController@preferences');
Route::post('perfil/geral', 'UserController@savePreferencesGeneral');
Route::post('perfil/password', 'UserController@savePreferencesPassword');
Route::post('perfil/email', 'UserController@savePreferencesEmail');

Route::post('utilizador/{name}', 'UserController@show');
Route::post('utilizador/{name}/desativar', 'UserController@disableUser');

// Password reset link request routes...
Route::get('login/resetar',  'Auth\PasswordController@getEmail');
Route::post('login/resetar', 'Auth\PasswordController@postEmail');

// Password reset routes...
Route::get('login/novapassword/{token}', 'Auth\PasswordController@getReset');
Route::post('login/novapassword', 'Auth\PasswordController@postReset');


// Search
Route::match([ 'get', 'post' ], 'procurar', 'GeneralController@search');

// Misc routes
Route::get('contato', 'GeneralController@contact');
Route::post('contato', 'GeneralController@contactSend');
Route::any('sobre', 'GeneralController@about');
Route::any('faq', 'GeneralController@faq');
Route::any('doacoes', 'GeneralController@donations');


// Used by the editor to avoid CSRF token validation
Route::post('editor/upload', 'GeneralController@upload');