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

const UPLOAD_PATH = 'img/upload/';

function store_upload(Symfony\Component\HttpFoundation\File\UploadedFile $file = null) {
	if($file !== NULL && $file->isValid()) {
		$filename = $file->getClientOriginalName();

		// Save the uploaded file in the server
		$file->move(UPLOAD_PATH, $filename);

		// Generate a optimized version (graciously fails if not a image)
		optimize_image(UPLOAD_PATH, $filename);

		return UPLOAD_PATH . $filename;
	} else {
		return NULL;
	}
}

const OPTIMIZED_PATH = UPLOAD_PATH . 'opt/';
const OPTIMIZED_QUALITY = 90;
const OPTIMIZED_MAX_HEIGHT = 250;

function optimize_image($path, $filename = '', $height = OPTIMIZED_MAX_HEIGHT, $quality = OPTIMIZED_QUALITY) {
	$srcFile = $path . $filename;

	if(empty($srcFile))
		return false;

	$info = getimagesize($srcFile);
	switch($info[2]) { // Check for file type
	case IMAGETYPE_PNG:
		$image = imagecreatefrompng($srcFile);
		break;
	case IMAGETYPE_GIF:
		$image = imagecreatefromgif($srcFile); 
		break;
	case IMAGETYPE_JPEG:
		$image = imagecreatefromjpeg($srcFile); 
		break;
	default:
		return false;
	}

	// Only resize the image if bigger than the target height
	if($info[1] > $height) {
		$width = $height / $info[1] * $info[0]; // max_height / image_height * image_width
		$image = imagescale($image, $width, $height, IMG_BICUBIC);
	}

	// Save the optimized image
	$outputPath = OPTIMIZED_PATH . basename($srcFile);
	imagejpeg($image, $outputPath, $quality);
	imagedestroy($image);

	return $outputPath;
}

function get_optimized_path($originalPath) {
	return OPTIMIZED_PATH . basename($originalPath);
}