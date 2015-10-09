<?php
namespace App\Http\Controllers;

use App\Models\Anime;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\View;

class AnimeController extends Controller {

	/**
	 * Show the page of the specified anime.
	 *
	 * @param  string $slug
	 * @return View
	 */
	public function showAnimePage($slug) {
		try {
			// Collect all the needed information about the news article
			$data = Anime::get($slug);

			return view('anime.anime_page', ['data' => $data]);
		} catch(ModelNotFoundException $e) {
			return App::abort(404);
		}
	}

	public function showList() {
		return view('anime.list');
	}
}