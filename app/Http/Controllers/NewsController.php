<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\NewsCategory;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\App;

class NewsController extends Controller {
	/**
	 * Show the details of the specified news article.
	 *
	 * @param  int  $id
	 *
	 * @return Response
	 */
	public function showDetail($id) {
		try {
			// Collect all the needed information about the news article
			$data = News::findOrFail($id);

			return view('news.news_page', ['data' => $data ]);
		} catch(ModelNotFoundException $e) {
			return App::abort(404);
		}
	}

	/**
	 * Same as the function showDetail($id), but using the slug instead of the ID.
	 *
	 * @param  string $slug
	 *
	 * @return Response
	 */
	public function showDetailSlug($slug) {
		try {
			// Collect all the needed information about the news article
			$data = News::where('slug', '=', $slug)->firstOrFail();

			return view('news.news_page', ['data' => $data ]);
		} catch(ModelNotFoundException $e) {
			return App::abort(404);
		}
	}

	/**
	 * Show a list of news by category ID.
	 *
	 * @param $id
	 *
	 * @return Response
	 */
	public function showCategoryList($id) {
		try {
			// Collect all the needed information about the news article
			$data = NewsCategory::findOrFail($id);

			return view('news.category', ['data' => $data ]);
		} catch(ModelNotFoundException $e) {
			return App::abort(404);
		}
	}

	/**
	 * Same as showCategoryList($id), but using the slug instead of the ID.
	 *
	 * @param  string $slug
	 *
	 * @return Response
	 */
	public function showCategoryListSlug($slug) {
		try {
			// Collect all the needed information about the news article
			$data = NewsCategory::where('slug', '=', $slug)->firstOrFail();

			return view('news.category', ['data' => $data ]);
		} catch(ModelNotFoundException $e) {
			return App::abort(404);
		}
	}

	public function showList() {
		return view('news.list');
	}
}