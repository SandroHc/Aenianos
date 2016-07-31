<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int id
 * @property int episode_id
 * @property string link
 * @property int host_id
 * @property string quality
 * @property string size
 */
class Download extends Model {
    protected $table = 'downloads';

    protected $fillable = ['episode_id', 'link', 'host_id', 'quality', 'size' ];

	/**
	 * Get this download's episode.
	 */
	public function episode() {
		return $this->belongsTo('\App\Models\Episode', 'id', 'episode_id');
	}

	public function host() {
		return $this->hasOne('\App\Models\Host', 'id', 'host_id');
	}

	/**
	 * Set the link attribute.
	 * If no host_id was set, try to find one through regex.
	 *
	 * @param	mixed	$value
	 * @return	void
	 */
	public function setLinkAttribute($value) {
		$this->attributes['link'] = $value;

		if(!$this->host_id)
			$this->attributes['host_id'] = Host::getHostByRegex($value)->id ?? NULL;
	}
}