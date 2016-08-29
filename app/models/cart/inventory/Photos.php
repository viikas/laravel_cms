<?php

namespace App\Models\Cart;

class Photos extends \Eloquent {

    protected $table = 'cart_product_photos';
    public $timestamps=false;
    public function product() {
        return $this->belongsTo('App\Models\Cart\Product','product_id', 'id');
    }
    
    public function table_name() {
        return $this->table;
    }
}

