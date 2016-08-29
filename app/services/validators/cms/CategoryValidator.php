<?php namespace App\Services\Validators;

class CMSCategoryValidator extends Validator {

	public static $rules = array(
		'name' => 'required|max:300',
		'code'  => 'required|max:100',
	);

}
