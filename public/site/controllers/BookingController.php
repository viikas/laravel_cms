<?php

namespace App\Controllers\Site;

use App\Models\Booking;
use App\Models\BookingEx;
use App\Models\Destination;
use Omnipay\Omnipay;
use Image,
    Input,
    Notification,
    Redirect,
    Sentry,
    Str,
    \Illuminate\Http\Request;

class BookingController extends \Controller {

    public function index() {
        $destinations = Destination::select('name as text', 'id as value', 'type', 'price_cbd', 'price_dom', 'price_int')->get();
        //$limousines=\App\Models\Limousine::get()->lists('name','id');
        //return \View::make('site::booking')->with('destinations', json_encode($destinations))->with('limousines', \App\Models\Limousine::select('id', 'name', 'details', 'price_factor')->get());

        return \View::make('site::booking')->with('destinations', $destinations)->with('limousines', \App\Models\Limousine::all())->with('hours', \Helper::GetHours(false, '', ''))->with('minutes', \Helper::GetMinutes(false, '', '', 5));
    }

    public function payment() {
        $bookX = new BookingEx();
        $bookX = unserialize(\Session::get('booking_data'));
        if ($bookX == null) {
            Notification::error('<div id="head">ERROR OCCURRED</div>Your session has expired. If you already paid for your booking, please visit your email inbox for the invoice. If you did not get any invoice email or if you are having any problem with booking, please contact us.');
            return Redirect::to('booking/result');
        }
        $cost = sprintf("%0.2f", $bookX->cost);
        $tax = sprintf("%0.2f", $bookX->tax);
        $total = sprintf("%0.2f", $bookX->total);
        $return = $bookX->return;
        $data = array('source' => Destination::find($bookX->source_id)->name,
            'destination' => Destination::find($bookX->dest_id)->name,
            'cost' => $cost, 'tax' => $tax, 'total' => $total, 'return' => $return,'currency'=>\Settings::GetCurrency());
        return \View::make('site::payment.paymentMethod')->with($data);
    }

    public function paypal() {
        $gateway = Omnipay::create('PayPal_Express');
        $gateway->setUsername(\Config::get('paypal.username'));
        $gateway->setPassword(\Config::get('paypal.password'));
        $gateway->setSignature(\Config::get('paypal.signature'));
        $gateway->setTestMode(\Config::get('paypal.sandbox'));

        $bookX = new BookingEx();
        $bookX = unserialize(\Session::get('booking_data'));

        //dd($bookX->cost.' - ' .$bookX->tax.' - '.$bookX->total);

        $args = array('amount' => $bookX->total,
            'returnUrl' => \Config::get('paypal.return_url'),
            'cancelUrl' => \Config::get('paypal.cancel_url'),
            'description' => 'Booking Order of Limousine',
            'currency' => \Config::get('paypal.currency'));

        $response = $gateway->purchase($args)->send();

        if ($response->isRedirect()) {
            $response->redirect();
        } else {
            //display error
        }
    }

    public function paypalCancel() {
        return \View::make('site::payment.paypal.paypalCancel');
    }

    public function paypalProcess() {
        $bookX = new BookingEx();
        $bookX = unserialize(\Session::get('booking_data'));

        if ($bookX == null) {
            Notification::error('<div id="head">ERROR OCCURRED</div>Your session has expired. If you already paid for your booking, please visit your email inbox for the invoice. If you did not get any invoice email or if you are having any problem with booking, please contact us.');
            return Redirect::to('booking/result');
        }

        $bookOld = Booking::where('payment_ref_number', $bookX->payment_token)->first();
        if ($bookOld) {
          Notification::error('Your order has been placed already. Please check your email address for the invoice. Thank you.');
          return Redirect::to('booking/payment');
          }

        //$x = $bookX->date_time . ' ' . $bookX->time_hour . ':' . $bookX->time_min . ':00 ' . $bookX->time_ampm;
        //$date = \DateTime::createFromFormat('m/d/Y H:i:s T', $x)->format('Y-m-d');
        //$ymd = \DateTime::createFromFormat('m/d/Y H:i:s A', $x); //->format('Y-m-d H:i:s');
        //$z = date_format($ymd, 'Y-m-d G:ia');
        //print_r($z);

        try {
            $client = new \App\Models\Client();
            $client->first_name = $bookX->first_name;
            $client->last_name = $bookX->last_name;
            $client->email = $bookX->email;
            $client->phone_mobile = $bookX->phone;
            $client->city = $bookX->city;
            $client->country = $bookX->country;

            $book = new Booking();
            $raw_date = $bookX->date_time . ' ' . $bookX->time_hour . ':' . $bookX->time_min . ':00 ' . $bookX->time_ampm;
            //$date = \DateTime::createFromFormat('m/d/Y H:i:s A', $raw_date)->format('Y-m-d h:i:s a');
            //$date = \DateTime::createFromFormat('m/d/Y H:i:s A', $raw_date);
            $date = \DateTime::createFromFormat('m/d/Y H:i:s A', $raw_date);

            //dd($date);

            $book->service_date = $date;
            $book->total_passengers = (int) $bookX->adult + (int) $bookX->children + (int) $bookX->baby;
            $book->total_adult = (int) $bookX->adult;
            $book->total_children = (int) $bookX->children;
            $book->total_baby = (int) $bookX->baby;
            $book->baby_age_group = $bookX->baby_age;
            $book->total_baggage = (int) $bookX->baggage;

            $book->limousine_id = $bookX->limousine;
            $book->cost = $bookX->cost;
            $book->tax = $bookX->tax;
            $book->total_price = $bookX->total;

            $book->airport = $bookX->airport;
            $book->airline = $bookX->airline;
            $book->flight_number = $bookX->flight;

            $book->payment_method = $bookX->pay_method;
            $book->payment_ref_number = $bookX->payment_token;
            $book->payment_details = '';

            $book->booked_on = \Helper::ToCurrentDateDB();
            $book->limo_source_id = $bookX->source_id;
            $book->limo_destination_id = $bookX->dest_id;

            $book->source_address_line_1 = $bookX->source_address1;
            $book->source_address_line_2 = $bookX->source_address2;
            $book->destination_address_line_1 = $bookX->destination_address1;
            $book->destination_address_line_2 = $bookX->destination_address2;

            if ($bookX->return == 'true') {
                $book->is_return = 1;
                $raw_date_return = $bookX->return_date . ' ' . $bookX->return_hour . ':' . $bookX->return_min . ':00 ' . $bookX->return_ampm;
                $date_return = \DateTime::createFromFormat('m/d/Y H:i:s A', $raw_date_return);
                $book->return_date = $date_return;
            } else {
                $book->is_return = 0;
            }

            $book->confirmed = 0;
            $book->access_code = $bookX->access_code;

            \DB::transaction(function() use($client, $book) {
                        $client->save();
                        $last_id = $client->id;

                        $book->client_id = $last_id;
                        //initially not confirmed

                        $book->save();
                    });
            //send first email to client
            //send email for confirmation to admin
            
                    $book2=Booking::find($book->id);
            $msg1 = $this->sendInitialEmail($book2, $book2->client);
            $msg2 = $this->sendInitialEmailAdmin($book2, $book2->client);
            if ($msg1 == '' && $msg2 == '') {
                $book->invoice_emailed_on = \Helper::ToCurrentDateDB();
                $book->is_invoice_emailed = true;
                $book->save();
            }
            Notification::success('<div id="head">BOOKING ORDER SUCCESS</div>Your booking order has been placed successfully! Your order number is <strong>' . $book->id . '</strong>. Your order is <b>UNDER REVIEW</b> by one of our sales representative. An email has been sent to you. Please check your inbox. <div id="info"> If you did not the receive the email, please check you spam folder. If you have any problem you can contact us. We are pleased to support you. Thank you!</div>');
        } catch (\Exception $e) {
            Notification::error('<div id="head">ERROR OCCURRED</div>' . $e->getMessage());
        }

        //return \View::make('site::payment.paypal.paypalReturn');
        return Redirect::to('booking/result');
        //return Redirect::route('booking.payment');
        //print_r($msg);
    }

    public function paypalReturn() {
        $token = Input::get('token');
        $bookX = new BookingEx();
        $bookX = unserialize(\Session::get('booking_data'));
        if ($bookX == null) {
            Notification::error('<div id="head">ERROR OCCURRED</div>Your session has expired. If you already paid for your booking, please visit your email inbox for the invoice. If you did not get any invoice email or if you are having any problem with booking, please contact us.');
            return Redirect::to('booking/result');
        }

        $bookOld = Booking::where('payment_ref_number', $token)->first();
        if ($bookOld) {
          Notification::error('Your order has been placed already. Please check your email address for the invoice. Thank you.');
          return Redirect::to('booking/payment');
          } 

        $gateway = Omnipay::create('PayPal_Express');
        $gateway->setUsername(\Config::get('paypal.username'));
        $gateway->setPassword(\Config::get('paypal.password'));
        $gateway->setSignature(\Config::get('paypal.signature'));
        $gateway->setTestMode(\Config::get('paypal.sandbox'));

        $access_code = $this->guid();
        $args = array('transactionId' => $token,
            'transactionReference' => $access_code,
            'amount' => $bookX->total,
            'currency' => \Config::get('paypal.currency'));

        try {

            $response = $gateway->completePurchase($args)->send();
            if ($response->isSuccessful()) {
                $bookX->payment_token = $token;
                $bookX->access_code = $access_code;
                $sess = serialize($bookX);
                \Session::put('booking_data', $sess);
                return Redirect::to('booking/paypal-process');
            } else {
                Notification::error('<div id="head">ERROR OCCURRED</div>' . $response->getMessage());
                return Redirect::to('booking/result');
            }
        } catch (\Exception $e) {
            Notification::error('<div id="head">ERROR OCCURRED</div>' . $e->getMessage());
            return Redirect::to('booking/result');
        }
    }

    public function success() {
        return \View::make('site::payment.result');
    }

    public function bank() {
        
    }

    public function store() {
        $book = new BookingEx();
        $book->source_id = Input::get('hiddenSID');
        $book->dest_id = Input::get('hiddenDID');

        $book->date_time = Input::get('datetime');
        $book->time_hour = Input::get('time-hour');
        $book->time_min = Input::get('time-min');
        $book->time_ampm = Input::get('time-ampm');
        $book->return = Input::get('hidden-return');

        $book->return_date = Input::get('returndate');
        $book->return_hour = Input::get('time-hour-return');
        $book->return_min = Input::get('time-min-return');
        $book->return_ampm = Input::get('time-ampm-return');

        $book->adult = Input::get('adult');
        $book->children = Input::get('children');
        $book->baby = Input::get('baby');
        $book->baby_age = Input::get('babyage');
        $book->baggage = Input::get('baggage');

        $book->first_name = Input::get('fname');
        $book->last_name = Input::get('lname');
        $book->email = Input::get('email');
        $book->phone = Input::get('phone');
        $book->city = Input::get('city');
        $book->country = Input::get('country');

        $book->airport = Input::get('airport');
        $book->airline = Input::get('airline');
        $book->flight = Input::get('flight');

        $book->limousine = Input::get('limousine');
        $limo = \App\Models\Limousine::find(Input::get('limousine'));

        $cost = 0.00;
        $tax = 0.00;
        $total = 0.00;
        $base_price = $this->GetPrice(Input::get('hiddenSID'), Input::get('hiddenDID'));
        $this->SetPrices($book->return, $limo->price_factor, $base_price, $cost, $tax, $total);

        $book->cost = $cost;
        $book->tax = $tax;
        $book->total = $total;

        $book->source_address1 = Input::get('source-address-line-1');
        $book->source_address2 = Input::get('source-address-line-2');

        $book->destination_address1 = Input::get('destination-address-line-1');
        $book->destination__address2 = Input::get('destination-address-line-2');


        ////dd($book->cost.' '.$book->tax.' '.$book->total);
        $sess = serialize($book);
        \Session::put('booking_data', $sess);

        return Redirect::to('booking/payment');
    }

    public function paystore() {
        $bookX = new BookingEx();
        $bookX = unserialize(\Session::get('booking_data'));
        if ($bookX == null) {
            Notification::error('<div id="head">ERROR OCCURRED</div>Your session has expired. If you already paid for your booking, please visit your email inbox for the invoice. If you did not get any invoice email or if you are having any problem with booking, please contact us.');
            return Redirect::to('booking/payment');
        }
        $bookX->pay_method = Input::get('paymethod');
        $sess = serialize($bookX);
        \Session::put('booking_data', $sess);
        if ($bookX->pay_method == 'paypal') {
            return Redirect::to('booking/pay-with-paypal');
        } else {

            return Redirect::to('booking/pay-via-bank');
        }
    }

    public function cancel() {
        Notification::error('<div id="head">BOOKING CANCELLED</div>We saw that you have cancelled your booking process. You can always start a new booking by visiting our booking page. If you still want to process the payment and book the order, please <a href="javascript:void(0);" onclick="javascript:history.go(-1);">CLICK HERE</a>. Thank you.');
        return Redirect::to('booking/result');
    }

    public function accept() {
        $access_code = Input::query('accessCode');
        $id = Input::query('booking');
        $book = Booking::find($id);

        if ($book && $book->access_code == $access_code) {
            $book->confirmed = 1;
            $book->confirmed_on = \Helper::ToCurrentDateDB();
            $book->save();
            $this->sendInvoiceEmail($book, $book->client);
            Notification::success('<div id="head">BOOKING ACCEPTED</div>Booking#' . $book->id . ' has been accepted. An email has been sent to the client with the full booking details. Thank you.');
        } else {
            Notification::error('<div id="head">ERROR OCCURRED</div>Invalid attempt');
        }
        return Redirect::to('booking/result');
    }

    public function reject() {
        $access_code = Input::query('accessCode');
        $id = Input::query('booking');
        $book = Booking::find($id);
        if ($book && $book->access_code == $access_code) {
            $book->confirmed = 0;
            $book->is_cancelled = 1;
            $book->cancelled_on=\Helper::ToCurrentDateDB();
            $book->save();
            $msg = $this->sendRejectEmail($book, $book->client);
            Notification::error('<div id="head">BOOKING CANCELLED</div>Booking#' . $book->id . ' has been rejected. Cancellation email has been sent to the client. Thank you.');
        } else {
            Notification::error('<div id="head">ERROR OCCURRED</div>Invalid attempt');
        }
        return Redirect::to('booking/result');
    }

    /////////////////////////
    ///Private functions
    ////////////////////////

    private function redirectToResult($head, $msg, $info, $isSuccess) {
        return Redirect::to('booking/result');
        $data = '<div id="head">' . $head . '</div>' . $msg;
        if (!empty($info))
            $data+='<div id="info">' . $info . '</div>';
        if ($isSuccess) {
            Notification::success($msg);
        } else {
            Notification::error($msg);
        }
    }

    private function sendInvoiceEmail($book, $client) {
        $data = array('book' => $book, 'client' => $client);
        try {
            \Mail::send('site::email.invoice', $data, function($message) use ($client, $book) {
                        $message->from(\Settings::GetEmailFrom(), \Settings::GetEmailFromName());
                        $message->to($client->email, $client->first_name . ' ' . $client->last_name);
                        $message->cc(\Settings::GetEmailTo(), \Settings::GetEmailToName());
                        $message->subject('Booking Order Confirmed #' . $book->id . ' - '.\Settings::GetSiteName());
                    });
            return "";
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    private function sendInitialEmail($book, $client) {
        $data = array('book' => $book, 'client' => $client);
        try {
            \Mail::send('site::email.first', $data, function($message) use ($client, $book) {
                        $message->from(\Settings::GetEmailFrom(), \Settings::GetEmailFromName());
                        $message->to($client->email, $client->first_name . ' ' . $client->last_name);
                        $message->subject('Booking Order Information #' . $book->id . ' - '.\Settings::GetSiteName());
                    });
            return "";
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    private function sendInitialEmailAdmin($book, $client) {
        $accept_link =\URL::to('/').'/booking/accept?booking=' . $book->id . '&accessCode=' . $book->access_code;
        $reject_link =\URL::to('/').'/booking/reject?booking=' . $book->id . '&accessCode=' . $book->access_code;
        $data = array('book' => $book, 'client' => $client, 'accept_link' => $accept_link, 'reject_link' => $reject_link);
        try {
            \Mail::send('site::email.firstAdmin', $data, function($message) use ($client, $book) {
                        $message->from(\Settings::GetEmailFrom(), \Settings::GetEmailFromName());
                        $message->to(\Settings::GetEmailTo(), \Settings::GetEmailToName());
                        $message->subject('Booking Order Confirmation Required #' . $book->id . ' - '.\Settings::GetSiteName());
                    });
            return "";
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    private function sendRejectEmail($book, $client) {
        $data = array('book' => $book, 'client' => $client);
        try {
            \Mail::send('site::email.cancel', $data, function($message) use ($client, $book) {
                        $message->from(\Settings::GetEmailFrom(), \Settings::GetEmailFromName());
                        $message->to($client->email, $client->first_name . ' ' . $client->last_name);
                        $message->cc(\Settings::GetEmailTo(), \Settings::GetEmailToName());
                        $message->subject('Booking Order Cancelled #' . $book->id . ' - '.\Settings::GetSiteName());
                    });
            return "";
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    private function guid() {
        if (function_exists('com_create_guid')) {
            return com_create_guid();
        } else {
            mt_srand((double) microtime() * 10000); //optional for php 4.2.0 and up.
            $charid = strtoupper(md5(uniqid(rand(), true)));
            $hyphen = chr(45); // "-"
            $uuid = chr(123)// "{"
                    . substr($charid, 0, 8) . $hyphen
                    . substr($charid, 8, 4) . $hyphen
                    . substr($charid, 12, 4) . $hyphen
                    . substr($charid, 16, 4) . $hyphen
                    . substr($charid, 20, 12)
                    . chr(125); // "}"
            return trim($uuid, '{}');
        }
    }

    private function GetPrice($sID, $dID) {
        $bp = 0.00;

        $source = Destination::find($sID);
        $destination = Destination::find($dID);

        $isCBD = false;
        $isDOM = false;
        $isINT = false;
        if (strpos($source->name, 'CBD') !== false) {
            $isCBD = true;
        }
        if (strpos($source->name, 'Sydney Airport') !== false) {
            $isDOM = true;
        }
        if (strpos($source->name, 'Sydney Int. Airport') !== false) {
            $isINT = true;
        }

        if ($isCBD || $isDOM || $isINT) {
            if ($isCBD) {
                $bp = $destination->price_cbd;
            } else if ($isDOM) {
                $bp = $destination->price_dom;
            } else {
                $bp = $destination->price_int;
            }
        } else {
            $isCBDX = false;
            $isDOMX = false;
            $isINTX = false;
            if (strpos($destination->name, 'CBD') !== false) {
                $isCBDX = true;
            }
            if (strpos($destination->name, 'Sydney Airport') !== false) {
                $isDOMX = true;
            }
            if (strpos($destination->name, 'Sydney Int. Airport') !== false) {
                $isINTX = true;
            }

            if ($isCBDX || $isDOMX || $isINTX) {
                if ($isCBD) {
                    $bp = $source->price_cbd;
                } else if ($isDOM) {
                    $bp = $source->price_dom;
                } else {
                    $bp = $source->price_int;
                }
            }
        }

        return $bp;
    }

    private function SetPrices($return, $price_factor, $base_price, &$cost, &$tax, &$total) {
        $cost = round((float) (($base_price * $price_factor / 100) + $base_price), 2);
        $tax = round($cost * \Settings::GetTaxRate(), 2);
        $total = round($cost + $tax, 2);

        if ($return == 'true') {
            $total*=2;
            $tax*=2;
        }

        $cost = round($cost, 2);
        $tax = round($tax, 2);
        $total = round($total, 2);
    }

}

