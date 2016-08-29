<?php namespace App\Services\Validators;

class ChangePasswordValidator extends Validator {

	public static $rules = array(
		'current_password' => 'required|min:3|max:20',
		'password'  => 'required|min:3|max:20|same:confirm_password',
	);

}