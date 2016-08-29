<?php namespace App\Models;

class DestinationEx extends \Eloquent
{
    public $id;
    public $name;
    public $cbd_id;
    public $dom_id;
    public $int_id;
    public $cbd;
    public $dom;
    public $intl;
    public static function getAllDestinations() {
        $results = \DB::select(\DB::raw("select d.type,d.name as text,d.id as value,p1.price_id as cbd_id,p1.base_price as cbd,p2.price_id as dom_id,p2.base_price as dom,p3.price_id as int_id,p3.base_price as intl from limo_destinations d inner join limo_prices p1 on d.id=p1.source_id and p1.destination_id=(select id from limo_destinations where type='cbd') inner join limo_prices p2 on d.id=p2.source_id and p2.destination_id=(select id from limo_destinations where type='dom') inner join limo_prices p3 on d.id=p3.source_id and p3.destination_id=(select id from limo_destinations where type='int') order by d.name asc"));
        //return Response::json($results);

        /*$mDestinations = array();
        foreach ($results as $mRow) {
            $mR = (array) $mRow;
            $mDestinations[] = new DestinationEx($mR, true);
        }
        return $mDestinations;
        */
        return $results;
    }
}

