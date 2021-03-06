<?php

use App\Models\Host;
use Illuminate\Database\Seeder;

class HostTableSeeder extends Seeder {

	public function run() {
		Host::create([
			'name' => 'MEGA',
			'icon' => '/img/hosts/mega.png',
			'regex' => '(mega.(nz|co.nz))',
			'regex_size' => 'download info-txt small-txt">(.+)<\/div>',
			'regex_link_down' => NULL,
		]);

		Host::create([
			'name' => 'Google Drive',
			'icon' => '/img/hosts/google-drive.png',
			'regex' => '((drive|docs).google.com)',
			'regex_size' => NULL,
			'regex_link_down' => NULL,
		]);

		Host::create([
			'name' => 'Dropbox',
			'icon' => '/img/hosts/dropbox.png',
			'regex' => '(dropbox.com)',
			'regex_size' => NULL,
			'regex_link_down' => NULL,
		]);

		Host::create([
			'name' => 'MediaFire',
			'icon' => '/img/hosts/mediafire.png',
			'regex' => '(mediafire.com)',
			'regex_size' => NULL,
			'regex_link_down' => NULL,
		]);

		Host::create([
			'name' => 'Fansubber',
			'icon' => '/img/hosts/fansubber.png',
			'regex' => '(fansubber.com.br)',
			'regex_size' => NULL,
			'regex_link_down' => NULL,
		]);

		Host::create([
			'name' => 'OMDA',
			'icon' => '/img/hosts/omda.png',
			'regex' => '(omda-fansubs.com)',
			'regex_size' => NULL,
			'regex_link_down' => NULL,
		]);
	}
}
