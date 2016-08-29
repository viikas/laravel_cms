<?php

namespace App\Services\Validators\Cart;

use App\Services\Validators\Validator;

class PhotosValidator extends Validator {

    public static $rules = array(
        'photo_image' => 'required'
    );
    
    public static $messages=array(
        'photo_image.required'=>'Please select the photo to upload'
    );

}
