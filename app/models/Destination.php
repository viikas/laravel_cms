<?php namespace App\Models;

class Destination extends \Eloquent {

	protected $table = 'limo_destinations';
        public function booking()
	{
		return $this->hasOne('App\Models\Booking', 'id','limo_source_id');
	}
        public function bookingDest()
	{
		return $this->hasOne('App\Models\Booking', 'id','limo_destination_id');
	}
        
}


