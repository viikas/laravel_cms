<?php namespace App\Services\Validators;

class CMSContactValidator extends Validator {

	public static $rules = array(
		'name' => 'required',
            'email' => 'required|email',
		'message'  => 'required|max:1000',
            'website'=>'url'
	);

}
