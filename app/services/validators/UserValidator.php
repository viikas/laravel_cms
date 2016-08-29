<?php namespace App\Services\Validators;

class UserValidator extends Validator {

	public static $rules = array(
		'email' => 'required',
		'password'  => 'required',
	);

}
