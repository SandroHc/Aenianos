<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Anime;
use App\Models\Episode;
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
			'title' => 'required|min:5',
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
			// Show the validation error page the the validator failed
			return view('errors.validator', [ 'validation' => $validator->messages() ]);
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
		return view('admin.anime.list');
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

			$temp = Input::get('airing_date');
			$data->airing_date = empty($temp) ? NULL : $temp;

			$temp = Input::get('airing_week_day');
			$data->airing_week_day = empty($temp) ? NULL : $temp;

			$data->episodes = Input::get('episodes');
			$data->genres = Input::get('genres');

			$data->producer = Input::get('producer');
			$data->director = Input::get('director');
			$data->website = Input::get('website');

			// Save the changes to the DB
			$data->save();

			return Redirect::action('AdminController@showAnimeEditor', [ 'slug' => $data->slug ]);
		} else {
			// Show the validation error page the the validator failed
			return view('errors.validator', [ 'validation' => $validator->messages() ]);
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

	public function showEpisodeEditor($id, $type, $num) {
		$data = ['id' => $id, 'type' => $type, 'num' => $num, 'data' => NULL];

		if($num !== 'novo') {
			try {
				$data['data'] = Episode::getByNumber($id, $type, $num)->firstOrFail();
			} catch(ModelNotFoundException $e) {
				return App::abort(404);
			}
		}

		return view('admin.episode.editor', $data);
	}

	public function updateEpisode($id, $type, $num) {
		// Check if the form was correctly filled
		$rules = [
			'num' => 'required|integer',
			'type' => 'in:episodio,filme,especial',
		];

		$validator = Validator::make(Input::all(), $rules);

		if(!$validator->fails()) {
			$isTorrent = Input::get('torrent', false);

			// If the variable $id equals 'novo', create a new model
			if($num === 'novo') {
				$data = new Episode();
			} else {
				// Try to find the episode on the DB. If no episode is found, create a default.
				// In case it's a torrent with all the episodes, we assign a special number (zero)
				try {
					$data = Episode::getByNumber($id, $type, $isTorrent ? 0 : $num)->firstOrFail();
				} catch(ModelNotFoundException $e) {
					$data = new Episode();
				}
			}

			$data->anime_id = $id;
			$data->type = Input::get('type');

			$data->title = Input::get('title', '');
			// In case this 'episode' is a torrent, assign it zero. This way we know how to differentiate between normal episodes and torrents
			$data->num = $isTorrent ? 0 : Input::get('num');

			// Save the changes to the DB
			$data->save();

			return Redirect::action('AdminController@showEpisodeEditor', [ 'id' => $id, 'type' => $data->type, 'num' => $data->num ]);
		} else {
			// Show the validation error page the the validator failed
			return view('errors.validator', [ 'validation' => $validator->messages() ]);
		}
	}

	/**
	 * Shows a view to confirm the deletion of the the episode of type %type and number $id (from anime with ID $id).
	 * Only accessible to administrators.
	 *
	 * @param int $id
	 * @param $type
	 * @param int $num
	 * @return View
	 */
	public function deleteEpisodePrompt($id, $type, $num) {
		try {
			// Collect all the needed information about the news article
			$data = Episode::getByNumber($id, $type, $num)->firstOrFail();

			return view('admin.episode.delete', ['data' => $data ]);
		} catch(ModelNotFoundException $e) {
			return App::abort(404);
		}
	}

	/**
	 * Delete the episode of type %type and number $id (from anime with ID $id) from the DB.
	 *
	 * @param $id
	 * @param $type
	 * @param $num
	 * @return View
	 */
	public function deleteEpisode($id, $type, $num) {
		$episode = Episode::getByNumber($id, $type, $num)->first();
		$episode->delete($id);

		return Redirect::action('AdminController@showAnimeList');
	}

	public function showEpisodeRaw($id) {
		try {
			return view('admin.episode.raw', ['id' => $id]);
		} catch(ModelNotFoundException $e) {
			return App::abort(404);
		}
	}
}