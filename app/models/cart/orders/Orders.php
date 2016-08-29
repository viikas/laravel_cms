<?php

namespace App\Models\Cart;

class Orders extends \Eloquent {

    protected $table = 'cart_orders';
    public $timestamps=false;
    public function products() {
        return $this->belongsToMany('App\Models\Cart\Products', 'cart_order_products','products_id');
    }

    public function customer() {
        return $this->belongsTo('App\Models\Cart\Customers', 'customers_id');
    }

    public function billing() {
        return $this->belongsTo('App\Models\Cart\Address', 'bill_id');
    }
    
    public function shipping() {
        return $this->belongsTo('App\Models\Cart\Address', 'ship_id');
    }

    public function table_name() {
        return $this->table;
    }

}

