<?php namespace App\Models;

class Client extends \Eloquent {

	protected $table = 'limo_clients';
        public function booking()
	{
		return $this->hasOne('App\Models\Booking', 'id','client_id');
	}
}

