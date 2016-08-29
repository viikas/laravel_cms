<?php namespace App\Models;

class Gallery extends \Eloquent {

	protected $table = 'cms_gallery';

	public function photos()
	{
		return $this->hasMany('App\Models\Photos', 'gallery_id');
	}

}

