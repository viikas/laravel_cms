<?php

namespace App\Repo\Cart;

use App\Models\Cart\Products;
use App\Models\Cart\Orders;
use App\Models\Cart\Customers;
use App\Models\Cart\Address;
use App\Repo\BaseRepo;
use Illuminate\Support\Collection;

class OrdersRepo extends BaseRepo {

    public function order_exists($transaction_id)
    {
        $order=Orders::where('payment_ref_num',$transaction_id)->first();
        if(is_null($order))
            return false;
        else return true;      
    }
    
    public function get_orders()
    {
        return Orders::all();
    }
    
    public function get_order($id)
    {
        return Orders::find($id);
    }
    

}
