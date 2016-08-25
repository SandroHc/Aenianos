<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

/**
 * @property  string name
 * @property  string email
 * @property  string password
 * @property  string avatar
 * @property  bool admin
 */
class User extends Model implements AuthenticatableContract, CanResetPasswordContract {
	use Authenticatable, CanResetPassword, SoftDeletes;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['name', 'email', 'password', 'avatar', 'admin'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['password', 'remember_token'];

	protected $dates = ['deleted_at'];

	public function isAdmin() {
		return $this->attributes['admin'] == true;
	}

	public function setEmailAttribute($value) {
		$this->attributes['email'] = $value;

		// If no avatar was provived, fall to Gravatar
		if(!$this->avatar)
			$this->attributes['avatar'] = $this->getGravatarUrl();
	}

	public function getGravatarUrl($options = []) {
		if(!array_key_exists('default', $options))
			$options['default'] = 'retro'; //urlencode('https://aenianos.sandrohc.me/img/unknown_circle.png');

		if(!array_key_exists('size', $options))
			$options['size'] = '250'; //urlencode('https://aenianos.sandrohc.me/img/unknown_circle.png');

		$base = 'https://www.gravatar.com/avatar/' . md5(strtolower(trim($this->attributes['email'])));

		$first = true;
		foreach($options as $key => $value) {
			$base .= $first ? '?' : '&';
			$base .= $key . '=' . $value;
			$first = false;
		}

		return $base;
	}
}
