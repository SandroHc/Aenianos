<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string name
 * @property string icon
 * @property string regex
 */
class Host extends Model {
	protected $table = 'hosts';

	protected $fillable = [ 'name', 'icon', 'regex' ];

	public static function getHostByRegex($url) {
		foreach(Host::all() as $host) {
			if(!empty($host->regex)) {
				if(preg_match($host->regex, $url) === 1) {
					return $host->id;
				}
			}
		}

		// No host was found using the regex technique.
		return NULL;
	}
}