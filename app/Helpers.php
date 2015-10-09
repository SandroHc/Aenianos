<?php

function cut_string($text, $maxchar, $end = '...') {
	if(!empty($text) && strlen($text) > $maxchar) {
		$words = preg_split('/\s/', $text);
		$output = '';
		$i = 0;
		while(true) {
			if(strlen($output) + strlen($words[$i]) <= $maxchar) {
				$output .= " ". $words[$i];
				++$i;
			} else
				break;
		}
		$output .= $end;
	} else
		$output = $text;
	return $output;
}

function trailing_zeros($num, $digits = 2) {
	// Calculate the "fill" numbers that need to be added to the string for it to get the desired number of characters.
	$diff = $digits - strlen($num);
	for($i = 0; $i < $diff; $i++)
		$num = '0'. $num;

	return $num;
}

const UPLOAD_PATH = "img/upload/";

function store_upload(Symfony\Component\HttpFoundation\File\UploadedFile $file = null) {
	if($file !== NULL && $file->isValid()) {
		$file->move(UPLOAD_PATH, $file->getClientOriginalName()); // uploading file to given path

		return '/'. UPLOAD_PATH . $file->getClientOriginalName();
	} else {
		return NULL;
	}
}

function get_hostname($url) {
	$_list = _get_domain_list();
	$domain = url_to_domain($url);

	return array_key_exists($domain, $_list) ? $_list[$domain] : '';
}

function get_host_domain($name) {
	return array_search($name, _get_domain_list());
}

function url_to_domain($url) {
	$host = @parse_url($url, PHP_URL_HOST);

	// If the URL can't be parsed, use the original URL
	// Change to "return false" if you don't want that
	if(!$host) $host = $url;

	// Remove the "www." prefix
	if(substr($host, 0, 4) == "www.")
		$host = substr($host, 4);

	return $host;
}

function _get_domain_list() {
	return [
		'mega.co.nz' => 'MEGA',
		'mega.nz' => 'MEGA',

		'drive.google.com' => 'Google Drive',
		'docs.google.com' => 'Google Drive',
		'google.com' => 'Google Drive',

		'dropbox.com' => 'Dropbox',
		'nyaa.se' => 'NYAA',
		'fansubber.com.br' => 'Fansubber',

		'omda-fansubs.com' => 'OMDA',
		'bt.omda-fansubs.com' => 'OMDA',
	];
}