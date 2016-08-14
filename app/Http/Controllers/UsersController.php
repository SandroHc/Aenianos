<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class UsersController extends Controller {

	public function page($username) {
		try {
			// Collect all the needed information about the news article
			$data = User::where('username', '=', $username)->firstOrFail();

			return view('user.page', [ 'data' => $data ]);
		} catch(ModelNotFoundException $e) {
			return App::abort(404);
		}
	}

	/**
	 * Shows a view with all the active and inactive users.
	 * @return View
	 */
	public function list() {
		return view('users.list', [ 'data' => User::withTrashed()->paginate(10) ]);
	}

	/**
	 * Shows the registration form.
	 * @return View
	 */
	public function showFormRegister() {
		return view('auth.register');
	}

	/**
	 * Shows the preferences form.
	 * @return View
	 */
	public function preferences() {
		return view('users.preferences', [ 'user' => Auth::user() ]);
	}

	public function savePreferencesGeneral() {
		// Check if the form was correctly filled
		$rules = [
			'name' => 'required',
			'avatar' => 'max:5000',
		];

		$validator = Validator::make(Input::all(), $rules);

		if(!$validator->fails()) {
			$data = Auth::user();

			$data->name = Input::get('name');

			$temp = save_upload(Input::file('avatar'));
			if($temp !== NULL)
				$data->avatar = $temp;

			// Save the changes to the DB
			$data->save();

			return Redirect::action('UsersController@showPreferences');
		} else {
			// Show the validation error page the the validator failed
			return view('errors.validator', [ 'validation' => $validator->messages() ]);
		}
	}

	public function savePreferencesPassword() {
		// Check if the form was correctly filled
		$rules = [
			'password' => 'required',
			'password_new' => 'required|confirmed|min:6',
		];

		$validator = Validator::make(Input::all(), $rules);

		if(!$validator->fails()) {
			$data = Auth::user();

			if(Hash::check(Input::get('password'), $data->password)) {
				$data->password = Hash::make(Input::get('password_new'));

				// Save the changes to the DB
				$data->save();
			}

			return Redirect::action('UsersController@showPreferences');
		} else {
			// Show the validation error page the the validator failed
			return view('errors.validator', [ 'validation' => $validator->messages() ]);
		}
	}

	public function savePreferencesEmail() {
		// Check if the form was correctly filled
		$rules = [
			'password' => 'required',
			'email' => 'required|email|unique:users',
		];

		$validator = Validator::make(Input::all(), $rules);

		if(!$validator->fails()) {
			$data = Auth::user();

			if(Hash::check(Input::get('password'), $data->password)) {
				$data->email = Input::get('email');

				// Save the changes to the DB
				$data->save();
			}

			return Redirect::action('UsersController@showPreferences');
		} else {
			// Show the validation error page the the validator failed
			return view('errors.validator', [ 'validation' => $validator->messages() ]);
		}
	}

	public function disableUser($id) {
		try {
			$data = User::withTrashed()->findOrFail($id);

			// If the user was already disabled, re-enable him. Else, "delete" (just a soft delete) him.
			if($data->trashed())
				$data->restore();
			else
				$data->delete();

			return Redirect::action('UsersController@showUsersList');
		} catch(ModelNotFoundException $e) {
			return App::abort(404);
		}
	}
}