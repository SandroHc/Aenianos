<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Mmanos\Search\Facade as Search;

/**
 * @property int id
 * @property string title
 * @property string japanese
 * @property string slug
 * @property string synopsis
 * @property string cover
 * @property int cover_offset
 * @property string official_cover
 * @property string status
 * @property string premiered
 * @property string airing_week_day
 * @property int episodes
 * @property string genres
 * @property string studio
 * @property string director
 * @property string website
 */
class Anime extends Model {
	use SoftDeletes;

	protected $table = 'anime';

	protected $fillable = [ 'title', 'japanese', 'slug', 'synopsis', 'cover', 'cover_offset', 'official_cover', 'status',
		'premiered', 'airing_week_day', 'episodes', 'genres', 'studio', 'director', 'website' ];

	protected $dates = [ 'deleted_at', 'airing_date' ];

	public function save(array $options = []) {
		parent::save($options);

		$this->index();
	}

	public function delete() {
		parent::delete();

		$this->deindex();
	}

	public static function get($slug) {
		return Anime::where('slug', '=', $slug)->firstOrFail();
	}

	/**
	 * Index this file to the search dataset
	 */
	public function index() {
		Search::index($this->table)->insert(
			$this['slug'],
			[
				'title'		=> $this['title'],
				'synopsis'	=> $this['synopsis'],
				'status'	=> $this['status'],
				'genres'	=> $this['genres'],
			],
			[
				'_type'		=> $this->table,
			]
		);
	}

	public function deindex() {
		Search::index($this->table)->delete($this['slug']);
	}

	/**
	 * Set the title and the slug attributes.
	 *
	 * @param    mixed $value
	 * @return    void
	 */
	public function setTitleAttribute($value) {
		$this->attributes['title'] = $value;

		// Prevent the slug from changing, if already created.
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
		return $this->hasMany('App\Models\Episode', 'anime', 'slug');
	}

	public function hasEpisodesFrom($type) {
		return Episode::where('anime', '=', $this['slug'])->where('type', '=', $type)->exists();
	}

	public function qualityList($type) {
		return Download::join('episodes', 'episodes.id', '=', 'downloads.episode_id')
			->where('anime', '=', $this['slug'])
			->where('type', '=', $type)
			->groupBy('quality')
			->get(['quality']);
	}

	public function episodeList($type, $quality) {
		return Episode::join('downloads', 'episodes.id', '=', 'downloads.episode_id')
			->where('anime', '=', $this['slug'])
			->where('type', '=', $type)
			->where('quality', '=', $quality)
			->groupBy('num')
			->orderBy('num', 'ASC')
			->get(['episodes.*']); // Strip all download data from the result. Only used to filter by quality
	}

	/**
	 * This ignores the host and quality. Only returns a list of
	 * @param $type
	 * @param $quality
	 * @param $host
	 * @return mixed
	 */
	public function availableEpisodes($type) {
		return Episode::where('anime', '=', $this['slug'])
			->where('type', '=', $type)
			->groupBy('num')
			->orderBy('num', 'ASC')
			->get(['num', 'title']);
	}
}
