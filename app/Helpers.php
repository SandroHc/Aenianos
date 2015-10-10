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