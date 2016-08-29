<?php namespace App\Services\Validators;

class PageValidator extends Validator {

	public static $rules = array(
		'title' => 'required',
            'code' => 'required',
		'body'  => 'required',
	);

}
