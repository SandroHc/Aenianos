<?php
namespace App\Http\Controllers;

use App\Models\Anime;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\App;
use Illuminate\View\View;

class NotificationController extends Controller {

	/**
	 * Show the notifications administration page.
	 *
	 * @return View
	 */
	public function index() {
		return view('admin.notification.list');
	}

	public function send() {
		return view('admin.notification.send');
	}
}