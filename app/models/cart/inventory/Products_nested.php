<?php

namespace App\Models\Cart;

class Products_nested extends \Eloquent {

    protected $table = 'cart_products';

    public function category() {
        return $this->belongsToMany('App\Models\Cart\Category', 'cart_products_category');
    }

    public function unit() {
        return $this->belongsTo('App\Models\Cart\Units', 'unit_id');
    }
    
    public function photos() {
        return $this->hasMany('App\Models\Cart\Photos', 'product_id');
    }

    public function table_name() {
        return $this->table;
    }

}

