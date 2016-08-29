<?php namespace App\Services\Validators;

class CMSPhotoValidator extends Validator {

	public static $rules = array(
		'image'  => 'required',
	);

}
