<?php

namespace App\Controllers\Admin\Cart;

use App\Services\Validators\Cart\ProductsValidator;
use App\Services\Validators\Cart\PhotosValidator;
use App\Repo\Cart\InventoryRepo;
use App\Repo\Cart\OrdersRepo;
use Image,
    Input,
    Notification,
    Redirect,
    Sentry,
    Str;

class OrdersController extends \BaseController {

    public function __construct(InventoryRepo $repoProduct,OrdersRepo $repo) {
        $this->repo = $repo;
        $this->repoProduct=$repoProduct;
    }

    public function index() {
        return \View::make('admin.cart.orders.index')->with('collection', $this->repo->get_orders());
    }

    public function show($id) {        
        $item=$this->repo->get_order($id);
         if (is_null($item)) {
            Notification::error('No such item exists.');
            return Redirect::route('admin.cart.orders.index');
        }
        $billing = $item->billing;
        $shipping = $item->shipping;
        $products=  \App\Models\Cart\OrderProducts::where('order_id',$item->id)->get();
               
        return \View::make('admin.cart.orders.show')->with('order', $item)->with('billing',$billing)->with('shipping',$shipping)->with('products',$products);
    }
    
    //ajax post method :: cancel
    public function ajax_action() {
        //check if its our form
        if (\Session::token() !== Input::get('_token')) {
            return \Response::json(array(
                        'msg' => \Session::token() . ' && ' . Input::get('_token')
                    ));
        }
        $type = Input::get('type');
        $id = Input::get('id');
        if($type=="email"){
            try {
                $order= $this->repo->get_order($id);
                $msg=$this->sendOrderEmail($order);
                if($msg=='')
                {
                    $response = array(
                        'status' => 'success',
                        'data' => date('Y-m-d h:i:s a')
                    );
                }
                else
                {
                    $response = array(
                        //'msg' => 'Email could not be sent. Please try again later.'
                        'msg' => $msg
                    );
                }
                return \Response::json($response);
            } catch (\Exception $e) {
                return \Response::json(array(
                            'msg' => $e->getmessage()
                        ));
            }
        }
    }
    
    private function sendOrderEmail($order) {
        $billing = $order->billing;
        $shipping = $order->shipping;
        $products=  \App\Models\Cart\OrderProducts::where('order_id',$order->id)->get();
       
        $data = array('order' => $order, 'billing' => $billing,'shipping'=>$shipping,'products'=>$products);

        try {
            \Mail::send('site::email.order', $data, function($message) use ($order, $billing) {
                        $message->from(\Settings::GetEmailFrom(), \Settings::GetEmailFromName());
                        $message->to($billing->email, $billing->first_name . ' ' . $billing->last_name);
                        $message->subject('Order #' . $order->id . ' - ' . \Settings::GetSiteName());
                    });
            return "";
        } catch (\Exception $e) {
            return 'ERROR::'.$e->getMessage();
        }
    }

}

