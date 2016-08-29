<?php

namespace App\Services\Validators\Cart;

use App\Services\Validators\Validator;

class ProductsValidator extends Validator {

    public static $rules = array(
        'name' => 'required',
        'new_price' => 'required|numeric',
        'old_price' => 'required|numeric',
        'unit_id' => 'required',
        'category_id'=>'required'
    );
}
