<?php namespace App\Services\Validators;

class PricingValidator extends Validator {

	public static $rules = array(
		'name' => 'required',
		'price_cbd'  => 'required|numeric',
            'price_dom'  => 'required|numeric',
            'price_int'  => 'required|numeric'
	);

}
