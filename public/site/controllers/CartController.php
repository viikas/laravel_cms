<?php

namespace App\Controllers\Site\Cart;

use App\Repo\Cart\InventoryRepo;
use App\Repo\Cart\OrdersRepo;
use App\Models\Cart\ShoppingCart;
use App\Services\Validators\Cart\OrdersValidator;
use Omnipay\Omnipay;
use App\Models\Cart\Orders;
use App\Models\Cart\Address;
use App\Models\Cart\Products;
use Image,
    Input,
    Notification,
    Redirect,
    Str,
    Cart;

class CartController extends \BaseController {

    public function __construct(InventoryRepo $repo, OrdersRepo $orderRepo) {
        $this->repo = $repo;
        $this->orderRepo = $orderRepo;
        $this->order_title = Cart::count() . ' products, ' . Cart::count(false) . ' items';
        $this->order_total = Cart::total();
        $this->shop = unserialize(\Session::get('billing_data'));
    }

    public function index() {
        $bread = array(array('url' => \URL::route('site.cart.index'), 'name' => 'my cart'));
        return \View::make('site::cart.index')->with('bread', $bread);
    }

    public function add($slug) {
        $model = $this->repo->getProductBySlug($slug);
        if (!is_null($model)) {
            try {
                Cart::add($model->id, $model->name, Input::get('qty'), $model->new_price);
                Notification::success('New product has been added to your shopping cart!');
                return Redirect::route('site.cart.index', $slug);
                
            } catch (\Exceptin $e) {
                Notification::error($e->getMessage());
            }
        } else {
            Notification::error('INVALID ATTEMPT');
        }
        return Redirect::route('site.product', $slug);
    }

    public function update() {
        if (Input::has('rows')) {
            $rows = Input::get('rows');
            if (Input::has('remove')) {
                $this->removeCart($rows);
            } else {
                $this->updateCart($rows);
            }
        } else {
            Notification::error('No item selected.');
        }
        return Redirect::route('site.cart.index');
    }

    private function removeCart($rows) {
        foreach ($rows as $item) {
            $rowid = substr($item, 4);
            Cart::remove($rowid);
        }
        Notification::success('Selected products removed from cart.');
    }

    private function updateCart($rows) {
        foreach ($rows as $item) {
            $rowid = substr($item, 4);
            $qty = Input::get('qty-' . $rowid);
            Cart::update($rowid, $qty);
        }
        Notification::success('Cart updated successfully!');
    }

    public function checkout() {
        if ($this->order_total == 0) {
            return Redirect::route('site.cart.index');
        }

        $shop = unserialize(\Session::get('billing_data'));
        if (!$shop)
            $shop = new ShoppingCart;
        //dd($shop);    
        $bread = array(array('url' => \URL::route('site.cart.index'), 'name' => 'my cart'), array('url' => \URL::route('site.cart.checkout'), 'name' => 'checkout'));
        return \View::make('site::cart.checkout')->with('bread', $bread)->with('shop', $shop);
    }

    public function cancelcheckout() {
        Notification::error('You cancelled the checkout process. However you can alway proceed the checkout whenever you like from this page.');
        return Redirect::route('site.cart.index');
    }

    public function payment() {
        if ($this->order_total == 0) {
            return Redirect::route('site.cart.index');
        }

        $validation = new OrdersValidator;
        if ($validation->passes()) {
            $all = Input::all();
            $shop = new ShoppingCart;
            $shop->title = Input::get('title');
            $shop->first_name = Input::get('first_name');
            $shop->last_name = Input::get('last_name');
            $shop->email = Input::get('email');
            $shop->country = Input::get('country');
            $shop->city = Input::get('city');
            $shop->address1 = Input::get('address1');
            $shop->zip = Input::get('zip');
            $shop->home_phone = Input::get('home_phone');

            $shop->title_s = Input::get('title_s');
            $shop->first_name_s = Input::get('first_name_s');
            $shop->last_name_s = Input::get('last_name_s');
            $shop->email_s = Input::get('email_s');
            $shop->country_s = Input::get('country_s');
            $shop->city_s = Input::get('city_s');
            $shop->address1_s = Input::get('address1_s');
            $shop->zip_s = Input::get('zip_s');
            $shop->home_phone_s = Input::get('home_phone_s');

            if (!Input::has('company'))
                $shop->company = null;
            if (!Input::has('address2'))
                $shop->address2 = null;
            if (!Input::has('state'))
                $shop->state = null;

            if (!Input::has('company_s'))
                $shop->company_s = null;
            if (!Input::has('address2_s'))
                $shop->address2_s = null;
            if (!Input::has('state_s'))
                $shop->state_s = null;

            $sess = serialize($shop);
            \Session::put('billing_data', $sess);

            return Redirect::route('site.cart.paynow');
        }

        return Redirect::back()->withInput()->withErrors($validation->errors);
    }

    public function paynow() {
        return \View::make('site::payment.paypal.process');
    }

    public function paypal_redirect() {

        $gateway = Omnipay::create('PayPal_Express');
        $gateway->setUsername(\Config::get('paypal.username'));
        $gateway->setPassword(\Config::get('paypal.password'));
        $gateway->setSignature(\Config::get('paypal.signature'));
        $gateway->setTestMode(\Config::get('paypal.sandbox'));

        $args = array('amount' => $this->get_grand_total(),
            'returnUrl' => \Config::get('paypal.return_url'),
            'cancelUrl' => \Config::get('paypal.cancel_url'),
            'description' => $this->order_title,
            'currency' => \Config::get('paypal.currency'));

        $response = $gateway->purchase($args)->send();

        if ($response->isRedirect()) {
            $response->redirect();
        } else {
            //dd($response->getMessage());
            Notification::error('<div id="head">ERROR OCCURRED</div>Payment could not be processed. Error has been logged and admin has been informed of it. If you have any query, please don\'t hesitate to contact us. You may try proceeding the payment process from this page.');
            return Redirect::route('site.cart.payment.result');
        }
    }

    public function paypal_cancel() {
        return \View::make('site::payment.paypal.paypalCancel');
    }

    public function paypal_return() {
        $token = Input::get('token');
        //dd($token);
        if (!$this->shop) {
            Notification::error('<div id="head">ERROR OCCURRED</div>Your session has expired. If you already paid for your purchase, please visit your email inbox for the invoice. If you did not get any invoice email or if you are having any problem with the purchase, please don\'t hesitate to contact us.');
            return Redirect::route('site.cart.payment.result');
        }

        if ($this->order_total == 0) {
            Notification::error('<div id="head">ERROR OCCURRED</div>Your cart is empty. If you already paid for your purchase, please visit your email inbox for the invoice. If you did not get any invoice email or if you are having any problem with the purchase, please don\'t hesitate to contact us.');
            return Redirect::route('site.cart.payment.result');
        }

        $gateway = Omnipay::create('PayPal_Express');
        $gateway->setUsername(\Config::get('paypal.username'));
        $gateway->setPassword(\Config::get('paypal.password'));
        $gateway->setSignature(\Config::get('paypal.signature'));
        $gateway->setTestMode(\Config::get('paypal.sandbox'));

        $access_code = \Helper::Guid();
        $args = array('transactionId' => $token,
            'transactionReference' => $access_code,
            'amount' => $this->get_grand_total(),
            'currency' => \Config::get('paypal.currency'));

        try {

            $response = $gateway->completePurchase($args)->send();
            if ($response->isSuccessful()) {
                $this->shop->payment_token = $token;
                $this->shop->transaction_number = $access_code;
                $sess = serialize($this->shop);
                \Session::put('billing_data', $sess);
                //return Redirect::route('site.cart.checkout.paypal_process');
                return \View::make('site::payment.paypal.placingOrder');
            } else {
                Notification::error('<div id="head">ERROR OCCURRED</div>' . $response->getMessage());
                return Redirect::route('site.cart.checkout.result');
            }
        } catch (\Exception $e) {
            Notification::error('<div id="head">ERROR OCCURRED</div>' . $e->getMessage());
            return Redirect::route('site.cart.checkout.result');
        }
    }

    public function paypal_process() {
        if (!$this->shop) {
            Notification::error('<div id="head">ERROR OCCURRED</div>Your session has expired. If you already paid for your purchase, please visit your email inbox for the invoice. If you did not get any invoice email or if you are having any problem with the purchase, please don\'t hesitate to contact us.');
            return Redirect::route('site.cart.payment.result');
        }

        $orderOld = $this->orderRepo->order_exists($this->shop->payment_token);
        if ($orderOld) {
            Notification::error('Your order has been placed already. Please check your email address for the invoice. Thank you.');
            return Redirect::route('site.cart.checkout.result');
        }

        $shop = $this->shop;

        try {
            $order = new Orders;
            $order->title = $this->order_title . ' - by ' . $shop->title . ' ' . $shop->first_name . ' ' . $shop->last_name;
            $order->order_date = \Helper::ToCurrentDateDB();
            $order->tax = $this->get_tax();
            $order->shipping_cost = $this->get_shipping();
            $order->amount = $this->order_total;
            $order->transaction_id = $shop->transaction_number;
            $order->payment_method = 'PayPal';
            $order->payment_ref_num = $shop->payment_token;
            $order->is_invoice_emailed = 0;

            $bill = new Address;
            $bill->title = $shop->title;
            $bill->first_name = $shop->first_name;
            $bill->last_name = $shop->last_name;
            $bill->email = $shop->email;
            $bill->company = $shop->company;
            $bill->country = $shop->country;
            $bill->state = $shop->state;
            $bill->city = $shop->city;
            $bill->zip = $shop->zip;
            $bill->address1 = $shop->address1;
            $bill->address2 = $shop->address2;
            $bill->home_phone = $shop->home_phone;

            $ship = new Address;
            $ship->title = $shop->title_s;
            $ship->first_name = $shop->first_name_s;
            $ship->last_name = $shop->last_name_s;
            $ship->email = $shop->email_s;
            $ship->company = $shop->company_s;
            $ship->country = $shop->country_s;
            $ship->state = $shop->state_s;
            $ship->city = $shop->city_s;
            $ship->zip = $shop->zip_s;
            $ship->address1 = $shop->address1_s;
            $ship->address2 = $shop->address2_s;
            $ship->home_phone = $shop->home_phone_s;

            \DB::transaction(function() use($order, $bill, $ship) {
                        $bill->save();
                        $ship->save();
                        $order->bill_id = $bill->id;
                        $order->ship_id = $ship->id;
                        $order->customer_id = null;
                        $order->save();
                        foreach (Cart::content() as $row) {
                            $order->products()->attach($row->id, array('qty' => $row->qty, 'order_id' => $order->id));
                        }
                    });

            $order2 = Orders::find($order->id);
            $msg = $this->sendOrderEmail($order2);
            if (empty($msg)) {
                $order->invoice_emailed_on = \Helper::ToCurrentDateDB();
                $order->is_invoice_emailed = true;
                $order->save();
            }
            Cart::destroy();
            Notification::success('<div id="head">PURCHASE ORDER SUCCESS</div>Your purchase order has been placed successfully! Your order number is <strong>' . $order->id . '</strong>. Please NOTE DOWN THE ORDER NUMBER since this will be helpful in case you need support regarding your order. An email has been sent to you. Please check your inbox. <div id="info"> If you did not the receive the email, please check you spam folder. If you have any problem please don\'t hesitate to contact us. We are just an email or a direct call away. Thank you!</div>');
        } catch (\Exception $e) {
            //Notification::error('<div id="head">ERROR OCCURRED</div>' . $e->getMessage());
        }

        return Redirect::route('site.cart.checkout.result');
    }

    private function sendOrderEmail($order) {
        $billing = $order->billing;
        $shipping = $order->shipping;
        $products = \App\Models\Cart\OrderProducts::where('order_id', $order->id)->get();

        $data = array('order' => $order, 'billing' => $billing, 'shipping' => $shipping, 'products' => $products);

        try {
            \Mail::send('site::email.order', $data, function($message) use ($order, $billing) {
                        $message->from(\Settings::GetEmailFrom(), \Settings::GetEmailFromName());
                        $message->to($billing->email, $billing->first_name . ' ' . $billing->last_name);
                        $message->subject('Order #' . $order->id . ' - ' . \Settings::GetSiteName());
                    });
            return "";
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function result() {
        return \View::make('site::payment.result');
    }

    private function get_tax() {
        return number_format($this->order_total * \Settings::GetTaxRate(), 2);
    }

    private function get_shipping() {
        return 2.00;
    }

    private function get_grand_total() {
        return $this->get_tax() + $this->get_shipping() + $this->order_total;
    }
}

