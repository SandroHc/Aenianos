<?php

namespace App\Http\Controllers;

use App\Models\Episode;
use App\Models\Download;
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
	public function addLink($slug, $type, $num) {
		try {
			// Check if the form was correctly filled
			$rules = [
				'link' => 'required',
				'quality' => 'required',
			];

			$validator = Validator::make(Input::all(), $rules);

			if(!$validator->fails()) {
				$episode = Episode::where([ ['anime', '=', $slug], ['type', '=', $type], ['num', '=', $num] ])->firstOrFail();

				$data = new Download();
				// link', 'host_id', 'quality', 'size

				$data->episode_id = $episode->id;
				$data->link = Input::get('link');
				$data->quality = Input::get('quality');

				// Save the changes to the DB
				$data->save();

				return Redirect::action('EpisodeController@manage', [ 'slug' => $slug, 'type' => $type, 'num' => $num ]);
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
			$data = Download::findOrFail($id);

			$episode = $data->episode;

			// Remove the link from the DB
			$data->delete();

			return Redirect::action('EpisodeController@manage', [ 'slug' => $episode->anime, 'type' => $episode->type, 'num' => $episode->num ]);
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

	public function manage($slug, $type, $num) {
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
			$data = Episode::get($slug, $type, $num)->firstOrFail();

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
		try {
			$episode = Episode::get($slug, $type, $num)->firstOrFail();
			$episode->delete();

			// Delete all downloads related to the episode
			Download::where('episode_id', '=', $episode->id)->delete();

			return Redirect::action('AdminController@showAnimeEditor', ['slug' => $slug]);
		} catch(ModelNotFoundException $e) {
			return App::abort(404);
		}
	}

	public function showEpisodeRaw($id) {
		try {
			return view('admin.episode.raw', ['id' => $id]);
		} catch(ModelNotFoundException $e) {
			return App::abort(404);
		}
	}
}