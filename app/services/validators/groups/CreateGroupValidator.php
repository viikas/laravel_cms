<?php namespace App\Services\Validators;

class CreateGroupValidator extends Validator {

	public static $rules = array(
		'name' => 'required|min:0|max:255'
	);

}