<?php

namespace App\Http\Controllers;

use App\Models\Episode;
use App\Models\Download;
use App\Util;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Redirect;

class EpisodeController extends Controller {
	/**
	 * Add a link to the episode $num of anime $id
	 *
	 * @param  int $id		Anime ID
	 * @param  int $num		Episode number
	 * @param null $info
	 *
	 * @return Response
	 */
	public function addLink($id, $type, $num, $info = null) {
		// Bypass validation if the $info variable has the data.
		// Used by the raw function to add new links
		if($info != null) {
			$data = new Download();

			// try to find the episode in teh DB. If no episode is found, create one.
			try {
				$episode = Episode::getByNumber($id, $type, $num)->firstOrFail();
			} catch(ModelNotFoundException $e) {
				$episode = new Episode();
				$episode->anime_id = $id;
				$episode->type = $type;
				$episode->num = $num;
				$episode->save();
			}

			$data->episode_id = $episode->id;
			$data->host_link = $info['link'];
			$data->host_name = Util::getHostName($info['link']);

			// Don't store the quality in case it's a "special episode", normally a torrent.
			$data->quality = $num > 0 ? $info['quality'] : '';
			$data->size = $info['size'];

			// Save the changes to the DB
			$data->save();

			return Redirect::action('AdminController@showEpisodeEditor', [ 'id' => $id, 'type' => $type, 'num' => $num ]);
		}

		try {
			// Check if the form was correctly filled
			$rules = [
				'host_link' => 'required',
				'quality' => 'required'
			];

			$validator = Validator::make(Input::all(), $rules);

			if(!$validator->fails()) {
				$data = new Download();

				$episode = Episode::getByNumber($id, $type, $num)->firstOrFail();

				$data->episode_id = $episode->id;
				$data->host_link = Input::get('host_link');
				$data->host_name = Util::getHostName($data->host_link);

				// Don't store the quality in case it's a "special episode", normally a torrent.
				// This way we can distinguish between separate episodes and torrents.
				$data->quality = $num > 0 ? Input::get('quality') : '';

				// Get the filesize and append the suffix
				$size = Input::get('size', '');
				if(!empty($size))
					$size .= ' ' . Input::get('size-suffix', 'MB');

				$data->size = $size;

				// Save the changes to the DB
				$data->save();

				return Redirect::action('AdminController@showEpisodeEditor', [ 'id' => $id, 'type' => $type, 'num' => $num ]);
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
	 * @param  int  $id	Anime ID
	 * @param  int $num	Episode number
	 * @return Response
	 */
	public function deleteLink($id, $num) {
		try {
			// Check if the form was correctly filled
			$rules = [
				'download_id' => 'required',
			];

			$validator = Validator::make(Input::all(), $rules);
			if(!$validator->fails()) {
				$data = Download::findOrFail(Input::get('download_id'));

				// Remove the link from the DB
				$data->delete();

				return Redirect::action('AdminController@showEpisodeEditor', [ 'id' => $id, 'num' => $num ]);
			} else {
				// Show the validation error page the the validator failed
				return view('errors.validator', [ 'validation' => $validator->messages() ]);
			}
		} catch(ModelNotFoundException $e) {
			return App::abort(404);
		}
	}

	public function parseRawEpisodeDownloads($id) {
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

						EpisodeController::addLink($id, $episodeNum, $arr);
					}
				}

				return Redirect::action('AnimeController@showDetail', [ 'id' => $id ]);
			} else {
				// Show the validation error page the the validator failed
				return view('errors.validator', [ 'validation' => $validator->messages() ]);
			}
		} catch(ModelNotFoundException $e) {
			return App::abort(404);
		}
	}
}