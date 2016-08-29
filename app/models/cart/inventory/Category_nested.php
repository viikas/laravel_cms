<?php

namespace App\Models\Cart;

class Category_nested extends \Eloquent {

    protected $table = 'cart_category';

    public function products() {
        //cart_products_category is the pivot table
        return $this->belongsToMany('Product', 'cart_products_category');
    }

    public function parent() {
        return $this->belongsTo('App\Models\Cart\Category', 'parent_id');
    }

    public function children() {
        return $this->hasMany('App\Models\Cart\Category', 'parent_id');
    }

}

