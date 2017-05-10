<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\NewsCategory;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class NewsController extends Controller {

	/**
	 * Show the show for the news article.
	 *
	 * @param  News $news
	 * @return View
	 */
	public function show(News $news) {
		return view('news.show', [ 'news' => $news ]);
	}

	public function index() {
		return view('news.index');
	}

	/**
	 * Show a index of news grouped by category.
	 *
	 * @param  string $slug
	 * @return View
	 */
	public function showNewsByCategory($slug) {
		try {
			// Collect all the needed information about the news article
			$data = NewsCategory::get($slug);

			return view('news.category', ['data' => $data ]);
		} catch(ModelNotFoundException $e) {
			return App::abort(404);
		}
	}

	/*
	 * ADMIN AREA
	 */
	public function create() {
		return $this->manage('new');
	}

	/**
	 * Shows a editor for the news article with ID $id.
	 * Only accessible to administrators.
	 *
	 * @param News $news
	 * @return View
	 */
	public function edit(News $news) {
		if($slug !== 'new') {
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
	 * @param News $news
	 * @return View
	 */
	public function update(News $news) {
		// Check if the form was correctly filled
		$rules = [
			'title' => 'required',
			'text' => 'required',
			'category' => 'required|integer',
		];

		$validator = Validator::make(Input::all(), $rules);

		if(!$validator->fails()) {
			// If adding a new article, create the Model.
			if($slug !== 'new') {
				$data = News::get($slug);
			} else {
				$data = new News();

				$data->created_by = Auth::id();
			}

			$data->title = Input::get('title');
			$data->text = Input::get('text');
			$data->category_id = Input::get('category');

			$data->updated_by = Auth::id();

			// Save the changes to the DB
			$data->save();

			return Redirect::action('NewsController@show', [ 'slug' => $data->slug ]);
		} else {
			// Go back to the form and highlight the errors
			return Redirect::back()->withErrors($validator)->withInput();
		}
	}

	/**
	 * Shows a view to confirm the deletion of the news article with ID $id.
	 * Only accessible to administrators.
	 *
	 * @param News $news
	 * @return View
	 */
	public function desotryWarning(News $news) {
		return view('admin.news.delete', [ $news->slug ]);
	}

	/**
	 * Delete the news article with ID $id from the DB.
	 *
	 * @param News $news
	 * @return View
	 */
	public function destroy(News $news) {
		$news->delete();

		Session::flash('message', "News '" . $news->title . "' deleted");
		Session::flash('alert-color', 'red');

		return Redirect::back();
	}
}