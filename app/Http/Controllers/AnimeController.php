<?php
namespace App\Http\Controllers;

use App\Models\Anime;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class AnimeController extends Controller {

	/**
	 * Show the page of the specified anime.
	 *
	 * @param  string $slug
	 * @return View
	 */
	public function page($slug) {
		try {
			// Collect all the needed information about the news article
			$data = Anime::get($slug);

			return view('anime.anime_page', ['data' => $data]);
		} catch(ModelNotFoundException $e) {
			return App::abort(404);
		}
	}

	public function list() {
		return view('anime.list');
	}

	public function admin() {
		return view('admin.anime.admin');
	}

	/*
	 * ADMIN AREA
	 */
	public function add() {
		return $this->manage('new');
	}

	/**
	 * Shows a editor for the anime with ID $id.
	 * Only accessible to administrators.
	 *
	 * @param string $slug
	 * @return View
	 */
	public function manage($slug) {
		if($slug !== 'new') {
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
	public function update($slug) {
		// Check if the form was correctly filled
		$rules = [
			'title' => 'required',
			'status' => 'required',
			'cover' => 'max:10000',
			'official_cover' => 'max:5000',
			'airing_week_day' => 'in:N/A,segunda,terça,quarta,quinta,sexta,sábado,domingo',
			'episodes' => 'integer',
		];

		$validator = Validator::make(Input::all(), $rules);

		if(!$validator->fails()) {
			// If adding a new anime, create the Model.
			if($slug === 'new') {
				$data = new Anime();
			} else {
				$data = Anime::get($slug);
			}

			$data->title = Input::get('title');
			$data->synopsis = Input::get('synopsis');
			$data->episodes = Input::get('episodes');

			$temp = save_upload(Input::file('cover'), $data->slug . '-cover');
			if($temp !== NULL)
				$data->cover = $temp;

			$temp = save_upload(Input::file('official_cover'), $data->slug . '-cover-official');
			if($temp !== NULL) {
				$data->official_cover = $temp;

				// Apply the official cover if no custom one was provided
				if($data->cover == NULL)
					$data->cover = $data->official_cover;
			}

			$data->cover_offset = Input::get('cover_offset', 0);

			$data->status = Input::get('status');
			$data->premiered = Input::get('premiered');

			$temp = Input::get('airing_week_day');
			$data->airing_week_day = empty($temp) ? NULL : $temp;

			$data->genres = Input::get('genres');

			$data->japanese = Input::get('japanese');
			$data->studio = Input::get('studio');
			$data->website = Input::get('website');

			// Save the changes to the DB
			$data->save();

			return Redirect::action('AnimeController@page', [ 'slug' => $data->slug ]);
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
	public function deleteWarning($slug) {
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
	public function delete($slug) {
		Anime::where('slug', '=', $slug)->delete();

		// Don't delete any episode/links as the anime will only be 'soft-deleted'.
		// This means that the anime will still be on the DB and thus the episodes should also stay.

		return Redirect::action('AnimeController@list');
	}
}