<?php

namespace App\Controllers\Admin;

use App\Models\Booking;
use App\Models\Client;
use Image,
    Input,
    Notification,
    Redirect,
    Sentry,
    Str,
    \Illuminate\Http\Request;

class BookingController extends \BaseController {

    public function index() {
        $bookings = Booking::orderBy('id', 'desc');
        $book_id = Input::query('book_id');
        $client_name = Input::query('client');
        $booked_on = \DateTime::createFromFormat('m/d/Y', Input::query('booked_on'));
        $service_date = \DateTime::createFromFormat('m/d/Y', Input::query('service_date'));

        $email = Input::query('email');
        $status = Input::query('status');

        $book_id_int = ctype_digit($book_id) ? intval($book_id) : null;
        if ($book_id_int != null) {
            $bookings = $bookings->where('id', $book_id_int);
        }

        if ($booked_on != null) {
            $bookings = $bookings->where('booked_on', '>=', $booked_on->format('Y-m-d'));
            $booked_on->add(new \DateInterval('P1D'));
            $bookings = $bookings->where('booked_on', '<', $booked_on->format('Y-m-d'));
        }

        if ($service_date != null) {
            $bookings = $bookings->where('service_date', '>=', $service_date->format('Y-m-d'));
            $service_date->add(new \DateInterval('P1D'));
            $bookings = $bookings->where('service_date', '<', $service_date->format('Y-m-d'));
        }

        if ($status != null) {
            if ($status == 'booked') {
                $bookings = $bookings->where('is_cancelled', false);
            } else if ($status == 'cancelled') {
                $bookings = $bookings->where('is_cancelled', true);
            }
        }

        if ($email != null) {
            $bookings = $bookings->whereHas('client', function($q) use ($email) {
                        $q->where('email', 'like', "%$email%");
                    });
        }

        if ($client_name != null) {
            $client_name = '%' . $client_name . '%';
            $bookings = $bookings->whereHas('client', function($q) use ($client_name) {
                        $q->where(function ($q) use ($client_name) {
                                    $q->where('first_name', 'LIKE', $client_name)
                                            ->orWhere('last_name', 'LIKE', $client_name);
                                });
                    });

            //dd(\DB::getQueryLog());
            //$queries = \DB::getQueryLog();
        }

        $booking = $bookings->get();
        //$queries = \DB::getQueryLog();
        //Notification::success($queries);
        //return \View::make('admin.limo.bookings.index')->with('bookings', Booking::orderBy('id','desc')->paginate(3));
        //print_r($booking);

        return \View::make('admin.limo.bookings.index')->with('bookings', $bookings->paginate(20));

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
                    'msg' => \Helper::ToDateString($book->cancelled_on, false)
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

