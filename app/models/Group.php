<?php namespace App\Models;

use Eloquent;
use Illuminate\Auth\GroupInterface;

class Group extends Cartalyst\Sentry\Groups\Eloquent\Group implements GroupInterface {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'groups';	
}
