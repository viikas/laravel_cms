<?php namespace App\Services\Validators;

class LimousineValidator extends Validator {

	public static $rules = array(
		'name' => 'required',
		'price_factor'  => 'required|numeric|min:0|max:100',
                'capacity'=>'required|numeric|min:1|max:20',
                'baggage'=>'required|numeric|min:1|max:20',
                'photo'=>'required'
	);

}
