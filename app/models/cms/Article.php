<?php namespace App\Models;

class Article extends \Eloquent {

	protected $table = 'cms_articles';

	public function author()
	{
		return $this->belongsTo('App\Models\User', 'user_id');
	}
        
        public function category()
	{
		return $this->belongsTo('App\Models\Category', 'category_id');
	}

}

