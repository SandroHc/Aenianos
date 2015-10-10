<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int anime_id
 * @property string type
 * @property int num
 * @property string link
 * @property int host_id
 * @property string quality
 * @property string size
 * @property string notes
 */
class Episode extends Model {
    protected $table = 'episodes';

    protected $fillable = ['anime_id', 'type', 'num', 'link', 'host_id', 'quality', 'size', 'notes'];

	/**
	 * Get the episode associated with the download.
	 */
	public function anime() {
		return $this->belongsTo('\App\Models\Anime');
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
			$this->attributes['host_id'] = Host::getHostByRegex($value);
	}

	public static function getList($id) {
		return Episode::where([ 'anime_id' => $id ])->get();
	}

	public static function getLatest($limit = 11) {
		return Episode::groupBy([ 'type', 'num' ])->orderBy('created_at', 'DESC')->limit($limit);
	}

	public function getType() {
		switch($this['type']) {
			case 'episodio':	return 'Episódio';
			case 'filme':		return 'Filme';
			case 'especial':	return 'Especial';
			default:			return '?';
		}
	}
}