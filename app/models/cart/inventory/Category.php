<?php

namespace App\Models\Cart;

class Category extends \Eloquent {

    protected $table = 'cart_category';

    public function products() {
        return $this->hasMany('App\Models\Cart\Products', 'category_id','id');
    }
}

