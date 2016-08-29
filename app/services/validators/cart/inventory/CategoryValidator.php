<?php namespace App\Services\Validators\Cart;
use App\Services\Validators\Validator;
class CategoryValidator extends Validator {

	public static $rules = array(
		'name' => 'required'
	);

}
