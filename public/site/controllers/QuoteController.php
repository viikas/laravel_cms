<?php

namespace App\Controllers\Site;

use App\Models\Quote;
use Image,
    Input,
    Notification,
    Redirect,
    Str,
    \Illuminate\Http\Request;

class QuoteController extends \Controller {

    public function index() {

        return \View::make('site::quote');
    }

    public function result() {

        return \View::make('site::quoteresult');
    }

    public function store() {
        $quote = new Quote();
        $quote->full_name = Input::get('name');
        $quote->email = Input::get('email');
        $quote->phone = Input::get('phone');
        $quote->source = Input::get('source');
        $quote->destination = Input::get('destination');

        $raw_date = Input::get('datetime') . ' ' . Input::get('datehour') . ':' . Input::get('datemin') . ':00 ' . Input::get('dateampm');
        $date = \DateTime::createFromFormat('m/d/Y H:i:s A', $raw_date);
        $quote->pickup_date = $date;

        if (Input::get('return') == 'true') {
            $raw_date_return = Input::get('returndate') . ' ' . Input::get('returnhour') . ':' . Input::get('returnmin') . ':00 ' . Input::get('returnampm');
            $date_return = \DateTime::createFromFormat('m/d/Y H:i:s A', $raw_date);
            $quote->return_date = $date_return;
            $quote->is_return = 1;
        }

        $quote->adult = (int) Input::get('adult');
        $quote->children = (int) Input::get('children');
        $quote->baby = (int) Input::get('baby');
        $quote->baby_age = Input::get('babyage');
        $quote->luggage = (int) Input::get('luggage');
        
        $quote->remarks = Input::get('remarks');

        try {
            $quote->save();
            $msg=$this->sendEmail($quote);
            if(empty($msg))
            {
                $quote->is_emailed=1;
                $quote->emailed_at=\Helper::ToCurrentDateDB();
                $quote->save();
            }
            //dd($msg);
            Notification::success('<div id="head">QUOTE ORDER SUCCESS</div>Your quote order has been received successfully! Your QUOTE NUMBER is <strong>' . $quote->id . '</strong>. An email has been sent to you. Please check your inbox. <div id="info"> If you did not the receive the email, please check you spam folder. If you have any problem you can contact us. We are pleased to support you. Thank you!</div>');
        } catch (\Exception $e) {
            Notification::error('<div id="head">ERROR OCCURRED</div>' . $e->getMessage());
        }

        return Redirect::to('quote/result');
    }
    
    private function sendEmail($quoteX) {
        $quote=Quote::find($quoteX->id);
        $data = array('quote' => $quote);
        try {
            \Mail::send('site::email.quote', $data, function($message) use($quote) {
                        $message->from(\Settings::GetEmailFrom(), \Settings::GetEmailFromName());
                        $message->to($quote->email, $quote->full_name);
                        $message->cc(\Settings::GetEmailTo(), \Settings::GetEmailToName());
                        $message->subject('New Quote Order #' . $quote->id . ' - '.\Settings::GetSiteName());
                    });
            return "";
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

}

