<?php namespace App\Models;

class Limousine extends \Eloquent {

	protected $table = 'limo_limousines';
        
        public function booking()
        {
            $this->hasMany('App\Models\Booking');
            
        }
}

