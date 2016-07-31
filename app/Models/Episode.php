<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string anime
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

    protected $fillable = ['anime', 'type', 'num', 'title' ];

	/**
	 * Get the anime associated with the download.
	 */
	public function anime() {
		return $this->belongsTo('\App\Models\Anime', 'anime', 'slug');
	}

	/**
	 * Get all the downloads for this episode.
	 */
	public function downloads() {
		return $this->hasMany('\App\Models\Download', 'episode_id', 'id');
	}

	public static function get($anime_slug, $episode_type, $episode_number) {
		return Episode::where('anime', '=', $anime_slug)->where('type', '=', $episode_type)->where('num', '=', $episode_number)->get();
	}

	public static function getLatest($limit = 11) {
		return Episode::groupBy([ 'type', 'num' ])->orderBy('created_at', 'DESC')->limit($limit)->get([ 'anime', 'type', 'num' ]);
	}
}