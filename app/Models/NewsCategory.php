<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class NewsCategory extends Model {
    protected $table = 'news_category';

    protected $fillable = [ 'name', 'slug', 'description' ];

    public $timestamps = false;

	public function news() {
		return $this->belongsTo('\App\Models\News', 'id', 'category_id');
	}

	public static function get($slug) {
		return NewsCategory::where('slug', '=', $slug)->firstOrFail();
	}

	/**
	 * Set the title and the slug attributes.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	mixed	$value
	 * @return	void
	 */
	public function setNameAttribute($value) {
		$this->attributes['name'] = ucfirst($value);

		if(!$this->slug)
			$this->attributes['slug'] = Str::slug($value);
	}
}