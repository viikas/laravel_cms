<?php namespace App\Services\Validators;

class EditUserValidator extends Validator {

	public static $rules = array(
		'first_name' => 'required|min:0|max:255',
		'last_name'  => 'required|min:0|max:255',
	);

}