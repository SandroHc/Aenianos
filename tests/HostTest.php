<?php

use App\Models\Host;

class HostTest extends TestCase {

	public function testRegex() {
		/**
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
		 */

		// Check against MEGA
		$links = [
			'https://mega.co.nz/#!ltFE2ZhI!D3kP8uAsyLEAkb8NhtcG4YzMRt-Ca2uPHBfgPnZQzhM',
			'https://mega.nz/#!B9t12CwI!SnhIQyJiL4q29UZn0hIGyLs3_3D6Wa_0A_7d1aRpCSI',
			'http://mega.nz/#!4px0UKzK!vt8yksoENVLLWqVfCMkMB8Ejpzlru4eNqXSGB8UvOe4',
			'http://www.mega.nz/#!4px0UKzK!vt8yksoENVLLWqVfCMkMB8Ejpzlru4eNqXSGB8UvOe4',
		];
		foreach($links as $link)
			$this->assertEquals('MEGA', $this->getHostByRegex($link)->name);

		// Check against Google Drive
		$links = [
			'http://docs.google.com/uc?id=0B8O5z12KKllkMkV4d1ZPS2IzOEk&export=download',
		];
		foreach($links as $link)
			$this->assertEquals('Google Drive', $this->getHostByRegex($link)->name);
	}

	public static function getHostByRegex($url) {
		foreach(Host::all() as $host) {
			if(!empty($host->regex)) {
				if(preg_match($host->regex, $url) === 1) {
					return $host;
				}
			}
		}

		// No host was found using the regex technique.
		return NULL;
	}
}
