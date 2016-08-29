<?php namespace App\Services\Validators;

class PermissionValidator extends Validator {

	public static $rules = array(
		'name' => 'required|min:0|max:100'
	);

}