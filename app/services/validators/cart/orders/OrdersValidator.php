<?php

namespace App\Services\Validators\Cart;

use App\Services\Validators\Validator;

class OrdersValidator extends Validator {

    public static $rules = array(
        'title' => 'required',
        'title_s' => 'required',
        'first_name' => 'required',
        'first_name_s' => 'required',
        'last_name' => 'required',
        'last_name_s' => 'required',
        'email' => 'required|email',
        'email_s' => 'required|email',
        'country' => 'required',
        'country_s' => 'required',
        'address1' => 'required',
        'address1_s' => 'required',
        'zip' => 'required',
        'zip_s' => 'required',
        'home_phone' => 'required',
        'home_phone_s' => 'required'
    );
    public static $messages = array(
        'title.required' => 'billing: Title required',
        'first_name.required' => 'billing: First name required',
        'last_name.required' => 'billing: Last name required',
        'email.required' => 'billing: Email required',
        'country.required' => 'billing: Country required',
        'address1.required' => 'billing: Address 1 required',
        'zip.required' => 'billing: ZIP/Postal Code required',
        'home_phone.required' => 'billing: Phone Number required',
        'title_s.required' => 'shipping: Title required',
        'first_name_s.required' => 'shipping: First name required',
        'last_name_s.required' => 'shipping: Last name required',
        'email_s.required' => 'shipping: Email required',
        'country_s.required' => 'shipping: Country required',
        'address1_s.required' => 'shipping: Address 1 required',
        'zip_s.required' => 'shipping: ZIP/Postal Code required',
        'home_phone_s.required' => 'shipping: Phone Number required'
    );

}
