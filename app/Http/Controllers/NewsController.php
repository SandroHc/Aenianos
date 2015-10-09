<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\NewsCategory;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Redirect;

class NewsController extends Controller {

	public function showNewsList() {
		return view('news.list');
	}

	/**
	 * Show the page for the news article.
	 *
	 * @param  string $slug
	 *
	 * @return Response
	 */
	public function showNewsPage($slug) {
		try {
			// Collect all the needed information about the news article
			$data = News::where('slug', '=', $slug)->firstOrFail();

			return view('news.news_page', ['data' => $data ]);
		} catch(ModelNotFoundException $e) {
			return App::abort(404);
		}
	}

	/**
	 * Show a list of news grouped by category.
	 *
	 * @param  string $slug
	 *
	 * @return Response
	 */
	public function showNewsByCategory($slug) {
		try {
			// Collect all the needed information about the news article
			$data = NewsCategory::where('slug', '=', $slug)->firstOrFail();

			return view('news.category', ['data' => $data ]);
		} catch(ModelNotFoundException $e) {
			return App::abort(404);
		}
	}
}