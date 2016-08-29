<?php namespace App\Services\Validators;

class GalleryValidator extends Validator {

	public static $rules = array(
		'name' => 'required'
	);

}
