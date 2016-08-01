<?php

namespace App\Http\Controllers;

use App\Models\Anime;
use App\Models\Episode;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class EpisodeController extends Controller {

	/**
	 * Add a link to the episode $num of anime $id
	 *
	 * @param  string $slug	Anime slug
	 * @param  string $type	Episode type
	 * @param  int $num		Episode number
	 * @param array $info
	 *
	 * @return View
	 */
	public function addLink($slug, $type, $num, $info = null) {
		// Bypass validation if the $info variable has the data.
		// Used by the raw function to add new links
		if($info != null) {
			// TODO Rewrite raw utility to be independent from "external" links...
		}

		try {
			// Check if the form was correctly filled
			$rules = [
				'link' => 'required',
				'quality' => 'required',
			];

			$validator = Validator::make(Input::all(), $rules);

			if(!$validator->fails()) {
				$data = new Episode();

				$data->anime = $slug;
				$data->type = $type;
				$data->num = $num;
				$data->link = Input::get('link');
				$data->quality = Input::get('quality');

				// Get the filesize and append the suffix
				$size = Input::get('size', '');
				if(!empty($size))
					$size .= ' '. Input::get('size-suffix', 'MB');

				$data->size = $size;

				// Save the changes to the DB
				$data->save();

				return Redirect::action('AdminController@showEpisodeEditor', [ 'slug' => $slug, 'type' => $type, 'num' => $num ]);
			} else {
				// Show the validation error page the the validator failed
				return view('errors.validator', [ 'validation' => $validator->messages() ]);
			}
		} catch(ModelNotFoundException $e) {
			return App::abort(404);
		}
	}

	/**
	 * Delete the link to the episode $num of anime $id
	 *
	 * @param  int  $id	Episode ID
	 * @return View
	 */
	public function deleteLink($id) {
		try {
			$data = Episode::findOrFail($id);

			// Remove the link from the DB
			$data->delete();

			return Redirect::action('AdminController@manageDownloads', [ 'slug' => $data->anime, 'type' => $data->type, 'num' => $data->num ]);
		} catch(ModelNotFoundException $e) {
			return App::abort(404);
		}
	}

	public function parseRawEpisodeDownloads($slug) {
		try {
			// Check if the form was correctly filled
			$rules = [
				'raw_text' => 'required',
			];

			$validator = Validator::make(Input::all(), $rules);
			if(!$validator->fails()) {
				$lines = explode(PHP_EOL, Input::get('raw_text'));

				foreach($lines as $line) {
					$fields = explode('|', $line);
					// Check if there are enough fields in the current line.
					// [episode_id, link, quality] are required fields are and [size] is optional.
					// If the fields array is too short, fail silently.
					if(sizeof($fields) >= 3) {
						$episodeNum = $fields[0];

						$arr = [];
						$arr['link'] = $fields[1];
						$arr['quality'] = $fields[2];
						$arr['size'] = sizeof($fields) >= 4 ? $fields[3] : '';

						EpisodeController::addLink($slug, $episodeNum, $arr);
					}
				}

				return Redirect::action('AnimeController@showAnimePage', [ 'slug' => $slug ]);
			} else {
				// Show the validation error page the the validator failed
				return view('errors.validator', [ 'validation' => $validator->messages() ]);
			}
		} catch(ModelNotFoundException $e) {
			return App::abort(404);
		}
	}

	/*
	 * ADMIN AREA
	 */
	public function add($slug, $type) {
		try {
			// Check if the form was correctly filled
			$rules = [
				'type' => 'in:Episódio,Filme,Especial',
				'num' => 'required|integer',
				'title' => 'string',
			];

			$validator = Validator::make(Input::all(), $rules);

			if(!$validator->fails()) {
				$data = new Episode();

				$data->anime = $slug;
				$data->type = Input::get('type');
				$data->num = Input::get('num');
				$data->title = Input::get('title');

				// Means we got a duplicate. Just redirect to its page
				if(Episode::where([ ['anime', '=', $data->anime], ['type', '=', $data->type], ['num', '=', $data->num] ])->exists()) {
					$data = Episode::where([ ['anime', '=', $data->anime], ['type', '=', $data->type], ['num', '=', $data->num] ])->get();
					return view('admin.episode.editor', $data);
				}

				// Save the changes to the DB
				$data->save();

				return Redirect::action('EpisodeController@manageDownloads', [ 'slug' => $slug, 'type' => $type, 'num' => $data->num ]);
			} else {
				// Show the validation error page the the validator failed
				return view('errors.validator', [ 'validation' => $validator->messages() ]);
			}
		} catch(ModelNotFoundException $e) {
			return App::abort(404);
		}
	}

	public function update($slug, $type, $num) {
		// Check if the form was correctly filled
		$rules = [
			'title' => 'string',
		];

		$validator = Validator::make(Input::all(), $rules);

		if(!$validator->fails()) {
			try {
				$data = Episode::get($slug, $type, $num);
			} catch(ModelNotFoundException $e) {
				return App::abort(404);
			}

			$data->title = Input::get('title');

			// Save the changes to the DB
			$data->save();

			return Redirect::action('AdminController@manageDownloads', $data);
		} else {
			// Go back to the form and highlight the errors
			return Redirect::back()->withErrors($validator);
		}
	}

	public function manageDownloads($slug, $type, $num) {
		try {
			$data = ['data' => Episode::get($slug, $type, $num)];
		} catch(ModelNotFoundException $e) {
			return App::abort(404);
		}

		return view('admin.episode.editor', $data);
	}

	/**
	 * Shows a view to confirm the deletion of the the episode of type %type and number $id (from anime with ID $id).
	 * Only accessible to administrators.
	 *
	 * @param string $slug	Anime slug
	 * @param string $type	Episode type
	 * @param int $num		Episode number
	 * @return View
	 */
	public function deleteWarning($slug, $type, $num) {
		try {
			// Collect all the needed information about the news article
			$data = Episode::get($slug, $type, $num)->first();

			return view('admin.episode.delete', [ 'data' => $data ]);
		} catch(ModelNotFoundException $e) {
			return App::abort(404);
		}
	}

	/**
	 * Delete the episode of type %type and number $id (from anime with slug $slug) from the DB.
	 *
	 * @param string $slug	Anime slug
	 * @param string $type	Episode type
	 * @param int $num		Episode number
	 * @return View
	 */
	public function delete($slug, $type, $num) {
		$episode = Episode::get($slug, $type, $num)->first();
		$episode->delete();

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