<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Mmanos\Search\Facade as Search;

class News extends Model {
	use SoftDeletes;

	protected $table = 'news';

	protected $fillable = [ 'title', 'slug', 'text', 'id_category', 'created_by', 'edited_by' ];

	protected $dates = [ 'deleted_at' ];

	public function save(array $options = []) {
		parent::save($options);

		$this->index();
	}

	/**
	 * Index this file to the search dataset
	 */
	public function index() {
		Search::insert(
			'news-'. $this['slug'],
			[
				'title'		=> $this['title'],
				'text'		=> $this['text'],
				'category'	=> $this['id_category'],
			],
			[
				'db_id'		=> $this['id'],
				'title'		=> $this['title'],
				'text'		=> $this['text'],
				'category'	=> $this['id_category'],
				'type'		=> 'news',
			]
		);
	}

	/**
	 * Set the title and the slug attributes.
	 *
	 * @param	mixed	$value
	 * @return	void
	 */
	public function setTitleAttribute($value) {
		$this->attributes['title'] = ucfirst($value);

		if(!$this->slug)
			$this->attributes['slug'] = News::createUniqueSlug($value);
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
		// Check if there is any entry if the current slug.
		while(News::where('slug', '=', $slug)->count() > 0) {
			// Concatenate the value with the incremental variable, so we may get a unique name
			$slug = $original .'-'. $i;
			$i++;
		}

		// Finally, we have a unique slug!
		return $slug;
	}
}