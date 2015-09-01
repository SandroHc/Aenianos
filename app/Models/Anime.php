<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Mmanos\Search\Facade as Search;

class Anime extends Model {
	use SoftDeletes;

	protected $table = 'anime';

	protected $fillable = ['title', 'slug', 'synopsis', 'status', 'cover', 'cover_offset', 'official_cover', 'episodios_total'];

	protected $dates = ['deleted_at'];

	public function save(array $options = []) {
		parent::save($options);

		$this->index();
	}

	/**
	 * Index this file to the search dataset
	 */
	public function index() {
		Search::insert(
			'anime-' . $this['slug'],
			[
				'title' => $this['title'],
				'synopsis' => $this['synopsis'],
				'status' => $this['status'],
			],
			[
				'db_id' => $this['id'],
				'title' => $this['title'],
				'synopsis' => $this['synopsis'],
				'status' => $this['status'],
				'type' => 'anime',
			]
		);
	}

	/**
	 * Set the title and the slug attributes.
	 *
	 * @param    mixed $value
	 * @return    void
	 */
	public function setTitleAttribute($value) {
		$this->attributes['title'] = $value;

		if(!$this->slug)
			$this->attributes['slug'] = Anime::createUniqueSlug($value);
	}

	/**
	 * Creates a slugs that's guaranteed to be unique in the dataset.
	 *
	 * The result is accomplished by concatenating an incrementing number at the end of the string and check for
	 * duplicates in the DB.
	 *
	 * @param  string $value	The value to be converted to slug
	 * @return string	The unique slug
	 */
	private static function createUniqueSlug($value) {
		$original = Str::slug($value);
		$slug = $original;

		$i = 2;
		// Check if there is any entry for the current slug.
		while(Anime::where('slug', '=', $slug)->count() > 0) {
			// Concatenate the value with the incremental variable, so we may get a unique name
			$slug = $original . '-' . $i;
			$i++;
		}

		// Finally, we have a unique slug!
		return $slug;
	}

	/**
	 * Get the episodes for the anime.
	 */
	public function episodes() {
		return $this->hasMany('App\Models\Episode');
	}

	public function hasMovies() {
		return $this->hasEpisodesFrom('filme');
	}

	public function hasSeries() {
		return $this->hasEpisodesFrom('episodio');
	}

	public function hasSpecials() {
		return $this->hasEpisodesFrom('especial');
	}

	private function hasEpisodesFrom($type) {
		return Episode::where('anime_id', '=', $this['id'])->where('type', '=', $type)->first() !== NULL;
	}

	public function qualityList($type) {
		return Anime::where('anime.id', '=', $this['id'])
			->join('episodes', 'anime.id', '=', 'episodes.anime_id')
			->where('type', '=', $type)
			->join('downloads', 'downloads.episode_id', '=', 'episodes.id')
			->groupBy('quality')
			->get(['quality']);
	}

	public function hostList($type, $quality) {
		return Anime::where('anime.id', '=', $this['id'])
			->join('episodes', 'anime.id', '=', 'episodes.anime_id')
			->where('type', '=', $type)
			->join('downloads', 'downloads.episode_id', '=', 'episodes.id')
			->where('quality', '=', $quality)
			->groupBy('host_name')
			->get(['host_name']);
	}

	public function episodeList($type, $quality, $host) {
		return Anime::where('anime.id', '=', $this['id'])
			->join('episodes', 'anime.id', '=', 'episodes.anime_id')
			->where('type', '=', $type)
			->join('downloads', 'downloads.episode_id', '=', 'episodes.id')
			->where('quality', '=', $quality)
			->where('host_name', '=', $host)
			->get(['episodes.num', 'episodes.title', 'downloads.host_link', 'downloads.notes']);
	}
}
