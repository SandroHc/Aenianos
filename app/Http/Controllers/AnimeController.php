<?php

namespace App\Http\Controllers;

use App\Models\Anime;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\App;

class AnimeController extends Controller
{
	/**
	 * Show the details of the specified anime.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function showDetail($id) {
		try {
			$data = Anime::findOrFail($id);

			return view('anime.anime_page', ['data' => $data ]);
		} catch(ModelNotFoundException $e) {
			return App::abort(404);
		}
	}

	/**
	 * Same as the function showDetail($id), but using the slug instead of the ID.
	 *
	 * @param  string $slug
	 * @return Response
	 */
	public function showDetailSlug($slug) {
		try {
			// Collect all the needed information about the news article
			$data = Anime::where('slug', '=', $slug)->firstOrFail();

			return view('anime.anime_page', ['data' => $data]);
		} catch(ModelNotFoundException $e) {
			return App::abort(404);
		}
	}

	public function showList() {
		return view('anime.list');
	}
}