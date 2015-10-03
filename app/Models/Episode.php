<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Episode extends Model {
    protected $table = 'episodes';

    protected $fillable = ['anime_id', 'type', 'num', 'link', 'host_name', 'quality', 'size', 'notes'];

	/**
	 * Get the episode associated with the download.
	 */
	public function anime() {
		return $this->belongsTo('\App\Models\Anime');
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