<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int id
 * @property string name
 * @property string icon
 * @property string regex
 * @property string regex_offline
 */
class Host extends Model {
	protected $table = 'hosts';

	protected $fillable = [ 'name', 'icon', 'regex', 'regex_size', 'regex_link_down' ];
}