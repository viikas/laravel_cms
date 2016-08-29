<?php

namespace App\Controllers\Admin;

use App\Models\Quote;
use Image,
    Input,
    Notification,
    Redirect,
    Sentry,
    Str,
    \Illuminate\Http\Request;

class QuoteController extends \BaseController {

    public function index() {
        $quotes = Quote::orderBy('id', 'desc');
        $quote_id = Input::query('quote_id');
        $client_name = Input::query('client');
        $ordered_on = \DateTime::createFromFormat('m/d/Y', Input::query('ordered_on'));
        $pickup_date = \DateTime::createFromFormat('m/d/Y', Input::query('pickup_date'));
//dd($pickup_date);
        $email = Input::query('email');

        $quote_id_int = ctype_digit($quote_id) ? intval($quote_id) : null;
        if ($quote_id_int != null) {
            $quotes = $quotes->where('id', $quote_id_int);
        }

        if ($ordered_on != null) {
            $quotes = $quotes->where('created_at', '>=', $ordered_on->format('Y-m-d'));
            $ordered_on->add(new \DateInterval('P1D'));
            $quotes = $quotes->where('created_at', '<', $ordered_on->format('Y-m-d'));
        }

        if ($pickup_date != null) {
            $quotes = $quotes->where('pickup_date', '>=', $pickup_date->format('Y-m-d'));
            $pickup_date->add(new \DateInterval('P1D'));
            $quotes = $quotes->where('pickup_date', '<', $pickup_date->format('Y-m-d'));
        }

        if ($email != null) {
            $quotes = $quotes->where('email', 'like', "%$email%");
                    
        }

        if ($client_name != null) {
            $quotes = $quotes->where('full_name', 'like', "%$client_name%");
        }

        //$quotesX = $quotes->get();
        //$queries = \DB::getQueryLog();
        //Notification::success($queries);
        //return \View::make('admin.limo.bookings.index')->with('bookings', Booking::orderBy('id','desc')->paginate(3));
        //print_r($booking);

        return \View::make('admin.limo.quotes.index')->with('quotes', $quotes->paginate(20));

        //print_r(\Settings::ToTimeZone(new \DateTime()));
    }

    public function show($id) {
        return \View::make('admin.limo.bookings.show')->with('book', Booking::find($id));
    }

    public function create() {
        
    }

    public function store() {
        
    }

    public function edit($id) {
        
    }

    public function update($id) {
        
    }

    public function destroy($id) {
        try {
            $book = Booking::find($id);

            $book->delete();

            Notification::success('The booking was marked as deleted successfully.');
            return Redirect::route('admin.bookings.index');
        } catch (\Exception $e) {
            Notification::error('The booking could not be deleted. ' . $e->getMessage());
        }
    }

    //ajax post method :: cancel
    public function cancel() {
        //check if its our form
        if (\Session::token() !== Input::get('_token')) {
            return \Response::json(array(
                        'msg' => \Session::token() . ' && ' . Input::get('_token')
                    ));
        }
        $type = Input::get('type');
        $id = Input::get('id');
        if ($type == 'cancel') {
            try {
                $book = Booking::find($id);
                $book->is_cancelled = 1;
                $book->cancelled_on = date('Y-m-d h:i:s a');
                $book->confirmed=0;
                $book->save();
                $this->sendEmail($book, $book->client);    
                $response = array(
                    'status' => 'success',
                    'msg' => \Settings::ToDateString($book->cancelled_on, false)
                );
                return \Response::json($response);
            } catch (\Exception $e) {
                return \Response::json(array(
                            'msg' => $e->getmessage()
                        ));
            }
        } else if($type=="undo"){
            try {
                $book = Booking::find($id);
                $book->confirmed=1;
                $book->is_cancelled = 0;
                $book->cancelled_on = null;
                $book->save();
                $this->sendEmail($book, $book->client);

                $response = array(
                    'status' => 'success',
                    'msg' => ''
                );
                return \Response::json($response);
            } catch (\Exception $e) {
                return \Response::json(array(
                            'msg' => $e->getmessage()
                        ));
            }
        } else if($type=="email"){
            try {
                $book=  Booking::find($id);
                $client=$book->client;
                $msg=$this->sendEmail($book, $client);
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
    
    private function sendEmail($book, $client) {
        $data = array('book' => $book, 'client' => $client);
        $template='site::email.invoice';
        if($book->is_cancelled==1) 
        {
            $template='site::email.cancel';
        }
        try {
            \Mail::send($template, $data, function($message) use ($client, $book) {
                        $message->from(\Settings::GetEmailFrom(), \Settings::GetEmailFromName());
                        $message->to($client->email, $client->first_name . ' ' . $client->last_name);
                        $message->cc(\Settings::GetEmailTo(), \Settings::GetEmailToName());
                        $message->subject('Booking Invoice: ' . $book->id);
                    });
            return "";
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

}

