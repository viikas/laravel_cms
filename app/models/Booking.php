<?php namespace App\Models;
class Booking extends \Eloquent {

	protected $table = 'limo_booking';
        protected $softDelete = true;
        // public $timestamps = false;

	public function limousine()
	{
		return $this->belongsTo('App\Models\Limousine');
	}
        public function source()
	{
		return $this->belongsTo('App\Models\Destination', 'limo_source_id','id');
	}
        public function destination()
	{
		return $this->belongsTo('App\Models\Destination', 'limo_destination_id','id');
	}
        public function client()
	{
		return $this->belongsTo('App\Models\Client','client_id', 'id');
	}
        

}

