<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Anime;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class AdminController extends Controller {

	/**
	 * Shows the administration dashboard.
	 *
	 * @return View
	 */
	public function index() {
		return view('admin.index');
	}

	public function config() {
		return view('admin.config');
	}
}