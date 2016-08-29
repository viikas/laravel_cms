<?php

namespace App\Models\Cart;

class Products extends \Eloquent {

    protected $table = 'cart_products';

    public function category() {
        return $this->belongsTo('App\Models\Cart\Category', 'category_id');
    }

    public function unit() {
        return $this->belongsTo('App\Models\Cart\Units', 'unit_id');
    }
    
    public function photos() {
        return $this->hasMany('App\Models\Cart\Photos', 'product_id','id');
    }
    
    public function orders() {
        return $this->belongsToMany('App\Models\Cart\Orders', 'cart_order_products','order_id');
    }

    public function table_name() {
        return $this->table;
    }

}

