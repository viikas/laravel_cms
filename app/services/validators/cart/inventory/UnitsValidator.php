<?php namespace App\Services\Validators\Cart;
use App\Services\Validators\Validator;
class UnitsValidator extends Validator {

	public static $rules = array(
		'display_name' => 'required',
		'unit_name'  => 'required',
	);

}
