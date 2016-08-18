<?php
namespace App\Http\Controllers;

use App\Models\Anime;
use App\Models\News;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use Mail;
use Search;

class GeneralController extends Controller {

	public function home() {
		return view('home');
	}

	public function search() {
		// Trim the search term.
		// If the Input is empty, the trim method returns a empty string.
		$searchTerm = trim(Input::get('search'));

		// Check if the term is not empty.
		$search = NULL;
		if(!empty($searchTerm))
			$search = Search::search(NULL, $searchTerm, [ 'fuzzy' => 0 ])->paginate(10);

		return view('search', [ 'search' => $searchTerm, 'paginator' => $search ]);
	}

	/**
	 * Used to upload files to the folder '/img/upload/' on the server.
	 * Currently used by the anime editor to upload covers.
	 *
	 * Returns a JSON response with the web link.
	 *
	 * @return bool
	 */
	public function upload() {
		$rules = [ 'file' => 'max:10000' ];

		$validation = Validator::make(Input::all(), $rules);
		if(!$validation->fails()) {
			$file = Input::file('file');

			if($file->isValid()) {
				$file->move('img/upload', $file->getClientOriginalName()); // uploading file to given path

				return Response::json([ 'filelink' => asset('img/upload/'. $file->getClientOriginalName()) ]);
			}
		}

		return false;
	}

	/**
	 * Send the contact received from the contact form to Aeniano's e-mail and a confirmation e-mail to the sender.
	 *
	 * @return \Illuminate\View\View|string
	 */
	public function contactSend() {
		// Check if the form was correctly filled
		$rules = [
			'email' => 'required|email',
			'message' => 'required',
		];

		$validator = Validator::make(Input::all(), $rules);
		if(!$validator->fails()) {
			Mail::queue('emails.contact', [ 'email' => Input::get('email'), 'text' => Input::get('message') ], function ($message) {
				$message->to(env('MAIL_ADDRESS', 'aenianosfansub@gmail.com'))->subject('Mensagem de contato');
			});

			Mail::queue('emails.contact_confirmation', [], function ($message) {
				$message->to(Input::get('email'))->subject('Confirmação de contato');
			});

			return 'A sua mensagem foi enviada com sucesso!';
		} else {
			// Show the validation error page the the validator failed
			return view('errors.validator', [ 'validation' => $validator->messages() ]);
		}
	}

	/**
	 * For debugging only!
	 * Used to delete every index in the search dataset and add all news and anime back to the index. Effectively rebuilding it.
	 *
	 * @return string
	 */
	public function rebuildSearch() {
		// Delete the current index
		Search::deleteIndex();

		// Index all anime
		foreach(Anime::all() as $cur)
			$cur->index();

		// Index all news
		foreach(News::all() as $cur)
			$cur->index();

		return "Índice de pesquisa reconstruído!";
	}

	/*
	 * Basic views
	 */
	public function contact() {
		return view('other.contact');
	}

	public function about() {
		return view('other.about');
	}

	public function faq() {
		return view('other.faq');
	}

	public function donations() {
		return view('other.donations');
	}
}