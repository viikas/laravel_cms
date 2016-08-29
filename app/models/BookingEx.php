<?php

namespace App\Models;

class BookingEx {
    var $source_id ='';
    var $dest_id = '';
    var $date_time = '';
    var $time_hour = '';
    var $time_min = '';
    var $time_ampm = '';
    
    var $return = '';
    var $return_date = '';
    var $return_hour = '';
    var $return_min = '';
    var $return_ampm = '';

    var $adult = '';
    var $children = '';
    var $baby = '';
    var $baby_age = '';
    var $baggage = '';

    var $first_name = ''; 
    var $last_name = ''; 
    var $email = ''; 
    var $phone = ''; 
    var $city = '';
    var $country = ''; 

    var $airport = ''; 
    var $airline = ''; 
    var $flight = ''; 

    var $limousine = '';
    var $cost = ''; 
    var $tax = ''; 
    var $total = ''; 
    var $pay_method = ''; 
    
    var $payment_token='';
    
    var $source_address1='';
    var $source_address2='';
    var $destination_address1='';
    var $destination_address2='';
    
    var $access_code='';
}