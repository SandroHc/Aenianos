<?php

namespace App;

class Util {
	private static $domainMap = [
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

	public static function trim($text, $maxchar, $end = '...') {
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

	public static function getHostName($url) {
		$domain = Util::urlToDomain($url);

		return array_key_exists($domain, Util::$domainMap) ? Util::$domainMap[$domain] : '';
	}

	public static function getHostDomain($name) {
		return array_search($name, Util::$domainMap);
	}

	public static function urlToDomain($url) {
		$host = @parse_url($url, PHP_URL_HOST);

		// If the URL can't be parsed, use the original URL
		// Change to "return false" if you don't want that
		if(!$host)
			$host = $url;

		if(substr($host, 0, 4) == "www.") // The "www." prefix isn't really needed
			$host = substr($host, 4);

		return $host;
	}
}