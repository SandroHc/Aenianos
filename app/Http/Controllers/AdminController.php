<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Anime;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class AdminController extends Controller {

	/**
	 * Shows the administration dashboard.
	 *
	 * @return View
	 */
	public function index() {
		return view('admin.admin');
	}

	/**
	 * Shows a view to manage all news articles.
	 *
	 * @return View
	 */
	public function showNewsList() {
		return view('admin.news.list', [ 'data' => News::orderBy('created_at', 'DESC')->paginate(10) ]);
	}

	/**
	 * Shows a editor for the news article with ID $id.
	 * Only accessible to administrators.
	 *
	 * @param string $slug
	 * @return View
	 */
	public function showNewsEditor($slug) {
		if($slug !== 'novo') {
			try {
				$data = News::get($slug);
			} catch(ModelNotFoundException $e) {
				return App::abort(404);
			}
		} else {
			$data = NULL;
		}

		return view('admin.news.editor', ['data' => $data]);
	}

	/**
	 * Update the information on the DB about the news article with ID $id.
	 *
	 * @param string $slug
	 * @return View
	 */
	public function updateNews($slug) {
		// Check if the form was correctly filled
		$rules = [
			'title' => 'required',
			'text' => 'required',
			'category' => 'required|integer',
		];

		$validator = Validator::make(Input::all(), $rules);

		if(!$validator->fails()) {
			// If adding a new article, create the Model.
			if($slug !== 'novo') {
				$data = News::get($slug);
			} else {
				$data = new News();

				$data->created_by = Auth::id();
			}

			$data->title = Input::get('title');
			$data->text = Input::get('text');
			$data->id_category = Input::get('category');

			$data->updated_by = Auth::id();

			// Save the changes to the DB
			$data->save();

			return Redirect::action('NewsController@showNewsPage', [ 'slug' => $data->slug ]);
		} else {
			// Go back to the form and highlight the errors
			return Redirect::back()->withErrors($validator);
		}
	}

	/**
	 * Shows a view to confirm the deletion of the news article with ID $id.
	 * Only accessible to administrators.
	 *
	 * @param string $slug
	 * @return View
	 */
	public function deleteNewsPrompt($slug) {
		try {
			// Collect all the needed information about the news article
			$data = News::get($slug);

			return view('admin.news.delete', ['data' => $data ]);
		} catch(ModelNotFoundException $e) {
			return App::abort(404);
		}
	}

	/**
	 * Delete the news article with ID $id from the DB.
	 *
	 * @param string $slug
	 * @return View
	 */
	public function deleteNews($slug) {
		News::where('slug', '=', $slug)->delete();

		return Redirect::action('AdminController@showNewsList');
	}

	/**
	 * Shows a view to manage all anime.
	 *
	 * @return View
	 */
	public function showAnimeList() {
		return App::abort(404);
		// FIXME: There is no longer a admin view. Use "anime.list" instead. | return view('anime.list');
	}

	/**
	 * Shows a editor for the anime with ID $id.
	 * Only accessible to administrators.
	 *
	 * @param string $slug
	 * @return View
	 */
	public function showAnimeEditor($slug) {
		if($slug !== 'novo') {
			try {
				$data = Anime::get($slug);
			} catch(ModelNotFoundException $e) {
				return App::abort(404);
			}
		} else {
			$data = NULL;
		}

		return view('admin.anime.editor', ['data' => $data]);
	}

	/**
	 * Update the information on the DB about the anime with ID $id.
	 *
	 * @param $slug
	 * @return View
	 */
	public function updateAnime($slug) {
		// Check if the form was correctly filled
		$rules = [
			'title' => 'required|min:1',
			'status' => 'required',
			'cover' => 'max:10000',
			'official_cover' => 'max:5000',
			'airing_week_day' => 'in:segunda,terça,quarta,quinta,sexta,sábado,domingo',
			'episodes' => 'integer',
		];

		$validator = Validator::make(Input::all(), $rules);

		if(!$validator->fails()) {
			// If adding a new anime, create the Model.
			if($slug === 'novo') {
				$data = new Anime();
			} else {
				$data = Anime::get($slug);
			}

			$data->title = Input::get('title');
			$data->synopsis = Input::get('synopsis');
			$data->episodes = Input::get('episodes');

			$temp = store_upload(Input::file('official_cover'));
			if($temp !== NULL)
				$data->official_cover = $temp;

			$temp = store_upload(Input::file('cover'));
			if($temp !== NULL)
				$data->cover = $temp;

			$data->cover_offset = Input::get('cover_offset');

			$data->status = Input::get('status');
			$data->premiered = Input::get('premiered');

			$temp = Input::get('airing_week_day');
			$data->airing_week_day = empty($temp) ? NULL : $temp;

			$data->episodes = Input::get('episodes');
			$data->genres = Input::get('genres');

			$data->japanese = Input::get('japanese');
			$data->studio = Input::get('studio');
			$data->website = Input::get('website');

			// Save the changes to the DB
			$data->save();

			return Redirect::action('AnimeController@showAnimePage', [ 'slug' => $data->slug ]);
		} else {
			// Go back to the form and highlight the errors
			return Redirect::back()->withErrors($validator);
		}
	}

	/**
	 * Shows a view to confirm the deletion of the anime with ID $id.
	 * Only accessible to administrators.
	 *
	 * @param string $slug
	 * @return View
	 */
	public function deleteAnimePrompt($slug) {
		try {
			// Collect all the needed information about the news article
			$data = Anime::get($slug);

			return view('admin.anime.delete', ['data' => $data ]);
		} catch(ModelNotFoundException $e) {
			return App::abort(404);
		}
	}

	/**
	 * Delete the anime with ID $id from the DB.
	 *
	 * @param string $slug
	 * @return View
	 */
	public function deleteAnime($slug) {
		Anime::where('slug', '=', $slug)->delete();

		// Don't delete any episode/links as the anime will only be 'soft-deleted'.
		// This means that the anime will still be on the DB and thus the episodes should also stay.

		return Redirect::action('AdminController@showAnimeList');
	}
}