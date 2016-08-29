<?php

namespace App\Services\Validators\Cart;

use App\Services\Validators\Validator;

class ProductsValidator_nested extends Validator {

    public static $rules = array(
        'name' => 'required',
        'new_price' => 'required|numeric',
        'old_price' => 'required|numeric',
        'unit_id' => 'required',
        'cats' => 'required'
    );
    
    public static $messages=array(
        'cats.required'=>'Please choose at least one category for this product.'
    );

}
