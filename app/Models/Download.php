<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Log;

/**
 * @property int id
 * @property int episode_id
 * @property string link
 * @property int host_id
 * @property string quality
 * @property string size
 * @property null is_down
 */
class Download extends Model {
    protected $table = 'downloads';

    protected $fillable = ['episode_id', 'link', 'host_id', 'quality', 'size', 'is_down' ];

	/**
	 * Get this download's episode.
	 */
	public function episode() {
		return $this->belongsTo('\App\Models\Episode', 'episode_id', 'id');
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

		$this->fillData();
	}

	private function fillData() {
		$this->findHost();
//		$this->findSize();
//		$this->isDown();
	}

	/**
	 * Attempts to find a valid host through regex queries
	 */
	private function findHost() {
		if($this->host_id)
			return;

		$url = $this->link;

		foreach(Host::all() as $host) {
			if(!empty($host->regex)) {
				if(preg_match($host->regex, $url)) {
					$this->attributes['host_id'] = $host->id;
					return;
				}
			}
		}
	}

	private function findSize() {
		if($this->size)
			return;

		$host = $this->host;
		if(!$host || !$host->regex_size)
			return;

		$this->attributes['size'] = $this->findInLink($host->regex_size);
	}

	private function isDown() {
		$host = $this->host;
		if(!$host || !$host->regex_link_down)
			return;

		$this->attributes['is_down'] = $this->findInLink($host->regex_link_down);
	}

	private function findInLink($pattern) {
		$data = get_remote_data($this->attributes['link']);
		preg_match('/' . $pattern . '/', $data, $match);
		Log::debug('REGEX on ' . $this->attributes['link'] . '\n\n\n' . $data . '\n\n\n' . serialize($match));
		return !empty($match[1]) ? $match[1] : NULL;
	}
}