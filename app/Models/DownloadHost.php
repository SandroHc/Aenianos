<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DownloadHost extends Model {
	protected $table = 'hosts';

	protected $fillable = [ 'name', 'icon' ];
}