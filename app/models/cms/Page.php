<?php namespace App\Models;

class Page extends \Eloquent {

	protected $table = 'cms_pages';

	public function author()
	{
		return $this->belongsTo('App\Models\User', 'user_id');
	}

}

