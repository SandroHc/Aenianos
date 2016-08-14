<?php

/**
 * Check if the currently logged on user as Administrator privileges
 */
function is_admin() {
	$user = Auth::user();
	return $user !== NULL && $user->admin;
}

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

function save_upload(Symfony\Component\HttpFoundation\File\UploadedFile $file = null, $filename = NULL) {
	if($file !== NULL && $file->isValid()) {
		// If the filename is provided, append the extension of the original file to it. Else, use the original filename
		if($filename) {
			$ext = $file->getClientOriginalExtension();
			if($ext)
				$filename .= '.' . $ext;
		} else {
			$filename = $file->getClientOriginalName();
		}

		// Save the uploaded file in the server
		if(!file_exists(UPLOAD_PATH)) mkdir(UPLOAD_PATH, 0775, true); // Make sure all directories exist
		$file->move(UPLOAD_PATH, $filename);

		// Generate a optimized version (graciously fails if not a image)
		if(!file_exists(OPTIMIZED_PATH)) mkdir(OPTIMIZED_PATH, 0775, true); // Make sure all directories exist
		optimize_image(UPLOAD_PATH, $filename);

		return '/' . UPLOAD_PATH . $filename;
	} else {
		return NULL;
	}
}

const OPTIMIZED_PATH = UPLOAD_PATH . 'opt/';
const OPTIMIZED_QUALITY = 90;
const OPTIMIZED_MAX_HEIGHT = 250;

const IMG_INFO_WIDTH = 0;
const IMG_INFO_HEIGHT = 1;
const IMG_INFO_TYPE = 2;
const IMG_INFO_SIZE = 3;

function optimize_image($path, $filename = '', $height = OPTIMIZED_MAX_HEIGHT, $quality = OPTIMIZED_QUALITY) {
	$srcFile = $path . $filename;
	if(empty($srcFile))
		return false;

	$info = getimagesize($srcFile);
	switch($info[IMG_INFO_TYPE]) { // Check for file type
		case IMAGETYPE_PNG:		$image = imagecreatefrompng($srcFile); break;
		case IMAGETYPE_GIF:		$image = imagecreatefromgif($srcFile); break;
		case IMAGETYPE_JPEG:	$image = imagecreatefromjpeg($srcFile); break;
		default:
			return false;
	}

	// Only resize the image if bigger than the target height
	if($info[IMG_INFO_HEIGHT] > $height) {
		$width = floor($height / $info[IMG_INFO_HEIGHT] * $info[IMG_INFO_WIDTH]); // max_height / image_height * image_width
//		$image = imagescale($image, $width, $height, IMG_BICUBIC);
		$image_p = imagecreatetruecolor($width, $height);
		imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $info[IMG_INFO_WIDTH], $info[IMG_INFO_HEIGHT]);
		imagedestroy($image); // Free up the resources of the original image
		$image = $image_p; // Swap the original with the resized one
	}

	// Save the optimized image
	$outputPath = get_optimized_path($srcFile);
	imagejpeg($image, $outputPath, $quality);
	imagedestroy($image);

	return $outputPath;
}

function get_optimized_path($originalPath) {
	return OPTIMIZED_PATH . basename($originalPath);
}

/**
 * Get the contents of a URL webpage, with support for POST parameters.
 *
 * Source:
 * https://github.com/tazotodua/useful-php-scripts/blob/master/get-remote-url-content-data.php
 *
 * @param $url
 * @param bool $post_parameters
 * @param bool $return_full_array
 * @return array|mixed|string
 */
function get_remote_data($url, $post_parameters = false, $return_full_array = false) {
	$c = curl_init();
	curl_setopt($c, CURLOPT_URL, $url);
	curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
	if($post_parameters) {
		curl_setopt($c, CURLOPT_POST, TRUE);
		curl_setopt($c, CURLOPT_POSTFIELDS, $post_parameters);
	}
	curl_setopt($c, CURLOPT_SSL_VERIFYHOST, false);
	curl_setopt($c, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($c, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; rv:33.0) Gecko/20100101 Firefox/33.0");
	//curl_setopt($c, CURLOPT_COOKIE, 'CookieName1=Value;');

	curl_setopt($c, CURLOPT_MAXREDIRS, 10);
	//if SAFE_MODE or OPEN_BASEDIR is set,then FollowLocation cant be used.. so...
	$follow_allowed = (ini_get('open_basedir') || ini_get('safe_mode')) ? false : true;
	if($follow_allowed) curl_setopt($c, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($c, CURLOPT_CONNECTTIMEOUT, 9);
	curl_setopt($c, CURLOPT_REFERER, $url);
	curl_setopt($c, CURLOPT_TIMEOUT, 60);
	curl_setopt($c, CURLOPT_AUTOREFERER, true);
	curl_setopt($c, CURLOPT_ENCODING, 'gzip,deflate');
	$data = curl_exec($c);
	$status = curl_getinfo($c);
	curl_close($c);

	preg_match('/(http(|s)):\/\/(.*?)\/(.*\/|)/si', $status['url'], $link);
	//correct assets URLs(i.e. retrieved url is: http://site.com/DIR/SUBDIR/page.html... then href="./image.JPG" becomes href="http://site.com/DIR/SUBDIR/image.JPG", but  href="/image.JPG" needs to become href="http://site.com/image.JPG")

	//inside all links(except starting with HTTP,javascript:,HTTPS,//,/ ) insert that current DIRECTORY url (href="./image.JPG" becomes href="http://site.com/DIR/SUBDIR/image.JPG")
	$data = preg_replace('/(src|href|action)=(\'|\")((?!(http|https|javascript:|\/\/|\/)).*?)(\'|\")/si', '$1=$2' . $link[0] . '$3$4$5', $data);
	//inside all links(except starting with HTTP,javascript:,HTTPS,//)    insert that DOMAIN url (href="/image.JPG" becomes href="http://site.com/image.JPG")
	$data = preg_replace('/(src|href|action)=(\'|\")((?!(http|https|javascript:|\/\/)).*?)(\'|\")/si', '$1=$2' . $link[1] . '://' . $link[3] . '$3$4$5', $data);
	// if redirected, then get that redirected page
	if($status['http_code'] == 301 || $status['http_code'] == 302) {
		//if we FOLLOWLOCATION was not allowed, then re-get REDIRECTED URL
		//p.s. WE dont need "else", because if FOLLOWLOCATION was allowed, then we wouldnt have come to this place, because 301 could already auto-followed by curl  :)
		if(!$follow_allowed) {
			//if REDIRECT URL is found in HEADER
			if(empty($redirURL)) {
				if(!empty($status['redirect_url'])) $redirURL = $status['redirect_url'];
			}
			//if REDIRECT URL is found in RESPONSE
			if(empty($redirURL)) {
				preg_match('/(Location:|URI:)(.*?)(\r|\n)/si', $data, $m);
				if(!empty($m[2])) $redirURL = $m[2];
			}
			//if REDIRECT URL is found in OUTPUT
			if(empty($redirURL)) {
				preg_match('/moved\s\<a(.*?)href\=\"(.*?)\"(.*?)here\<\/a\>/si', $data, $m);
				if(!empty($m[1])) $redirURL = $m[1];
			}
			//if URL found, then re-use this function again, for the found url
			if(!empty($redirURL)) {
				$t = debug_backtrace();
				return call_user_func($t[0]["function"], trim($redirURL), $post_parameters);
			}
		}
	} elseif($status['http_code'] != 200) {
		// if not redirected,and nor "status 200" page, then error..
		$data = "ERRORCODE22 with $url!!<br/>Last status codes:" . json_encode($status) . "<br/><br/>Last data got:$data";
	}
	return $return_full_array ? ['data' => $data, 'info' => $status] : $data;
}