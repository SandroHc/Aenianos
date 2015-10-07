<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::pattern('id', '\d+');
Route::pattern('type', '[a-z0-9-]+');
Route::pattern('slug', '[a-z0-9-]+');


Route::any('/', 'GeneralController@home');
Route::any('home', function() {
	return Redirect::guest('/');
});

// Anime-realted routes
Route::any('anime', 'AnimeController@showList');
Route::any('anime/{id}', 'AnimeController@showDetail');
Route::any('anime/{slug}', 'AnimeController@showDetailSlug');

// News-related routes
Route::any('noticias', 'NewsController@showList');
Route::any('noticias/{id}', 'NewsController@showDetail');
Route::any('noticias/{slug}', 'NewsController@showDetailSlug');
Route::any('noticias/categoria/{id}', 'NewsController@showCategoryList');
Route::any('noticias/categoria/{slug}', 'NewsController@showCategoryListSlug');

// Administration routes
Route::group([ 'before' => 'auth', 'prefix' => 'admin' ], function() {
	Route::any('/', 'AdminController@index');
	Route::any('rebuild_search', 'GeneralController@rebuildSearch');

	/** News **/
	Route::get('noticias', 'AdminController@showNewsList');
	// Edit
	Route::get('noticias/{id}', 'AdminController@showNewsEditor')->where('id', '[a-z0-9-]+');
	Route::post('noticias/{id}', 'AdminController@updateNews')->where('id', '[a-z0-9-]+');
	// Delete
	Route::get('noticias/{id}/eliminar', 'AdminController@deleteNewsPrompt');
	Route::post('noticias/{id}/eliminar', 'AdminController@deleteNews');

	/** Anime **/
	Route::get('anime', 'AdminController@showAnimeList');
	// Edit
	Route::get('anime/{id}', 'AdminController@showAnimeEditor')->where('id', '[a-z0-9-]+');
	Route::post('anime/{id}', 'AdminController@updateAnime')->where('id', '[a-z0-9-]+');
	// Delete
	Route::get('anime/{id}/eliminar', 'AdminController@deleteAnimePrompt');
	Route::post('anime/{id}/eliminar', 'AdminController@deleteAnime');

	/** Episodes **/
	// Edit
	Route::get('anime/{id}/{type}/{num}', 'AdminController@showEpisodeEditor');
	Route::post('anime/{id}/{type}/{num}', 'AdminController@updateEpisode');
	// Delete
	Route::get('anime/{id}/{type}/{num}/eliminar', 'AdminController@deleteEpisodePrompt');
	Route::post('anime/{id}/{type}/{num}/eliminar', 'AdminController@deleteEpisode');

	/** Episode downloads */
	Route::get('anime/{id}/raw', 'AdminController@showEpisodeRaw');
	Route::post('anime/{id}/raw', 'EpisodeController@parseRawEpisodeDownloads');

	Route::put('anime/{id}/{type}/{num}', 'EpisodeController@addLink');
	Route::delete('anime/{id}/{type}/{num}', 'EpisodeController@deleteLink');

	/** Users **/
	Route::get('utilizadores', 'UsersController@showUsersList');

	/** Misc **/
	Route::post('upload', 'GeneralController@upload');
});

// Authentication routes...
Route::get('login', 'Auth\AuthController@getLogin');
Route::post('login', 'Auth\AuthController@postLogin');
Route::get('logout', 'Auth\AuthController@getLogout');

Route::get('registar', 'Auth\AuthController@getRegister');
Route::post('registar', 'Auth\AuthController@postRegister');

Route::get('perfil', 'UsersController@showPreferences');
Route::post('perfil/geral', 'UsersController@savePreferencesGeneral');
Route::post('perfil/password', 'UsersController@savePreferencesPassword');
Route::post('perfil/email', 'UsersController@savePreferencesEmail');

Route::post('utilizador/{id}/desativar', 'UsersController@disableUser');

// Password reset link request routes...
Route::get('login/resetar', 'Auth\PasswordController@getEmail');
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


Route::post('editor/upload', function() {
	$validation = Validator::make(Input::all(), [ 'file' => 'image|max:10000' ]);
	if(!$validation->fails()) {
		$file = Input::file('file');

		if($file->isValid()) {
			$file->move('img/upload', $file->getClientOriginalName()); // uploading file to given path

			return Response::json([ 'filelink' => '/img/upload/'. $file->getClientOriginalName() ]);
		}
	}
	return false;
});


// Filters
Route::filter('auth', function() {
	if (Auth::guest())
		return Redirect::guest('login');
});