<?php namespace App\Services\Validators;

class CreateUserValidator extends Validator {

	public static $rules = array(
		'first_name' => 'required|min:0|max:255',
		'last_name'  => 'required|min:0|max:255',
                'email' => 'required|min:0|max:255|unique:users|email',
		'password'  => 'required|min:3|max:20|same:confirm_password',
	);

}