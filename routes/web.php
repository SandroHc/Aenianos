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


Route::any('/', 'GeneralController@home');

Route::get('/logout', 'Auth\LoginController@logout');
Auth::routes();


// Anime-related routes
Route::any('anime', 'AnimeController@index');
Route::any('anime/{slug}', 'AnimeController@show');

// News-related routes
Route::any('noticias', 'NewsController@index');
Route::any('noticias/{slug}', 'NewsController@show');
Route::any('noticias/categoria/{slug}', 'NewsController@showNewsByCategory');

// Administration routes
Route::group([ 'middleware' => 'admin', 'prefix' => 'admin' ], function() {
	Route::any('/', 'AdminController@index');
	Route::any('/config', 'AdminController@config');
	Route::any('rebuild_search', 'GeneralController@rebuildSearch');

	/** News **/
//	Route::get('noticias', 'AdminController@showNewsList');
	// Edit
	Route::get('noticias/new',		'NewsController@add');
	Route::get('noticias/{slug}',	'NewsController@manage');
	Route::post('noticias/{slug}',	'NewsController@update');
	// Delete
	Route::get('noticias/{slug}/eliminar',	'NewsController@deleteWarning');
	Route::delete('noticias/{slug}',		'NewsController@delete');

	/** Anime **/
	Route::get('anime',			'AnimeController@admin');
	// Edit
	Route::get('anime/new',		'AnimeController@add');
	Route::get('anime/{slug}',	'AnimeController@manage');
	Route::post('anime/{slug}',	'AnimeController@update');
	// Delete
	Route::get('anime/{slug}/eliminar',	'AnimeController@deleteWarning');
	Route::delete('anime/{slug}', 		'AnimeController@delete');

	/** Episodes **/
	// Edit
	Route::put('anime/{slug}/{type}',			'EpisodeController@add');
	Route::get('anime/{slug}/{type}/{num}',		'EpisodeController@manage');
	Route::put('anime/{slug}/{type}/{num}',		'EpisodeController@update');
	Route::put('anime/{slug}/{type}/{num}/link','EpisodeController@addLink');
	Route::delete('anime/link/{id}',			'EpisodeController@deleteLink');
	// Delete
	Route::get('anime/{slug}/{type}/{num}/eliminar',  'EpisodeController@deleteWarning');
	Route::delete('anime/{slug}/{type}/{num}', 'EpisodeController@delete');

	/** Episode downloads */
	Route::get('anime/{slug}/raw',  'AdminController@showEpisodeRaw');
	Route::post('anime/{slug}/raw', 'EpisodeController@parseRawEpisodeDownloads');

	/** Users **/
	Route::get('utilizadores', 'UserController@index');

	/** Notifications **/
	Route::any('notificações', 'NotificationController@index');
	Route::any('notificações/send', 'NotificationController@send');

	/** Misc **/
	Route::post('upload', 'GeneralController@upload');
});

// Authentication routes...
Route::get('login',  'Auth\AuthController@getLogin');
Route::post('login', 'Auth\AuthController@postLogin');
Route::get('logout', 'Auth\AuthController@getLogout');

Route::get('registar',  'Auth\AuthController@getRegister');
Route::post('registar', 'Auth\AuthController@postRegister');

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