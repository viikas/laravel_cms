<?php

namespace App\Models\Cart;

class Customers extends \Eloquent {

    protected $table = 'cart_customers';

    public function address() {
        return $this->belongsTo('App\Models\Cart\Address', 'address_id');
    }
    
    public function table_name() {
        return $this->table;
    }
}

