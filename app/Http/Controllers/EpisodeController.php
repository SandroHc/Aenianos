<?php

namespace App\Http\Controllers;

use App\Models\Anime;
use App\Models\Episode;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
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

			return Redirect::action('AdminController@showEpisodeEditor', [ 'slug' => $data->anime, 'type' => $data->type, 'num' => $data->num ]);
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
}