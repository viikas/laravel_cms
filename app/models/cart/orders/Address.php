<?php

namespace App\Models\Cart;

class Address extends \Eloquent {

    protected $table = 'cart_address';
    
    public function table_name() {
        return $this->table;
    }
}

