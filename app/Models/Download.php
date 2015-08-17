<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Download extends Model {
    protected $table = 'downloads';

    protected $fillable = ['episode_id', 'host_name', 'host_link', 'quality', 'size', 'notes'];

	/**
	 * Get the episode associated with the download.
	 */
	public function episode() {
		return $this->belongsTo('\App\Models\Episode');
	}

	public static function getList($id) {
		return Download::where([ 'episode_id' => $id ])->get();
	}
}