<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Episode extends Model {
	protected $table = 'episodes';

	protected $fillable = ['anime_id', 'title', 'num', 'type'];

	/**
	 * Get the anime associated with the episode.
	 */
	public function anime() {
		return $this->belongsTo('\App\Models\Anime');
	}

	/**
	 * Get the downloads for the episode.
	 */
	public function downloads() {
		return $this->hasMany('App\Models\Download');
	}

	public static function getEpisodeList($animeId) {
		return Episode::where([ 'anime_id' => $animeId ])->orderBy('type', 'ASC')->orderBy('num', 'ASC')->get();
	}

	/**
	 * @param $id	string Anime ID
	 * @param $type	string Episode type
	 * @param $num	string Episode number
	 *
	 * @return mixed
	 */
	public static function getByNumber($id, $type, $num) {
		return Episode::where('anime_id', '=', $id)->where('type', '=', $type)->where('num', '=', $num);
	}

	public static function getLatestEpisodes($number = 11) {
		return Download::join('episodes', 'episodes.id', '=', 'downloads.episode_id')
			->join('anime', 'anime.id', '=', 'episodes.anime_id')
			->select('anime.id', 'anime.slug', 'anime.title', 'anime.cover', 'anime.official_cover', DB::raw('max(downloads.updated_at) AS latest')) // episodes.num
			->groupBy('anime.id')
			->orderBy('latest', 'DESC')
			->limit($number)
			->get();
	}

	public function typeToStr() {
		switch($this['type']) {
			case 'episodio':	return 'Episódio';
			case 'filme':		return 'Filme';
			case 'especial':	return 'Especial';
			default:			return 'Desconhecido';
		}
	}
}