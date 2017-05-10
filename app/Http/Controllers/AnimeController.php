<?php
namespace App\Http\Controllers;

use App\Models\Anime;
use Illuminate\Contracts\Session\Session;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class AnimeController extends Controller {

	const RULES = [
		'title' => 'required',
		'status' => 'required',
		'cover' => 'max:10000',
		'official_cover' => 'max:5000',
		'airing_week_day' => 'in:N/A,segunda,terça,quarta,quinta,sexta,sábado,domingo',
		'episodes' => 'integer',
	];


	public function index() {
		return view('anime.index');
	}

	/**
	 * Show the page of the specified anime.
	 *
	 * @param Anime $anime
	 * @return View
	 */
	public function show(Anime $anime) {
		return view('anime.show', compact('anime'));
	}

	public function create()
	{
		$anime = new Anime();
		return view('admin.anime.editor', compact('anime'));
	}

	public function store()
	{
		$validator = Validator::make(Input::all(), self::RULES);
		if ($validator->fails()) {
			// Go back to the form and highlight the errors
			return Redirect::back()->withErrors($validator)->withInput();
		}

		// Create the model
		$anime = Anime::create(Input::all());

		return Redirect::action('AnimeController@show', [ $anime->slug ]);
	}

	/**
	 * Shows a editor for the anime with ID $id.
	 * Only accessible to administrators.
	 *
	 * @param Anime $anime
	 * @return View
	 */
	public function edit(Anime $anime) {
		return view('admin.anime.editor', compact('anime'));
	}

	/**
	 * Update the information on the DB about the anime with ID $id.
	 *
	 * @param Anime $anime
	 * @return View
	 */
	public function update(Anime $anime) {
		$validator = Validator::make(Input::all(), self::RULES);
		if ($validator->fails()) {
			// Go back to the form and highlight the errors
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$anime->update(Input::all());

		// TODO upload files
//		$temp = save_upload(Input::file('cover'), $anime->slug . '-cover');
//		if($temp !== NULL)
//			$anime->cover = $temp;
//
//		$temp = save_upload(Input::file('official_cover'), $data->slug . '-cover-official');
//		if($temp !== NULL) {
//			$data->official_cover = $temp;
//
//			// Apply the official cover if no custom one was provided
//			if($data->cover == NULL)
//				$data->cover = $data->official_cover;
//		}

		// Save the changes to the DB
		$anime->save();

		return Redirect::action('AnimeController@show', [ $anime->slug ]);
	}


	public function admin() {
		return view('admin.anime.admin');
	}

	/**
	 * Shows a view to confirm the deletion of the anime with ID $id.
	 * Only accessible to administrators.
	 *
	 * @param Anime $anime
	 * @return View
	 */
	public function destroyWarning(Anime $anime) {
		return view('admin.anime.delete', [ $anime->slug ]);
	}

	/**
	 * Delete the anime with ID $id from the DB.
	 *
	 * @param Anime $anime
	 * @return View
	 */
	public function destroy(Anime $anime) {
		$anime->delete();

		Session::flash('message', "Anime '" . $anime->title . "' deleted");
		Session::flash('alert-color', 'red');

		return Redirect::back();
	}
}