<?php

namespace App\Controllers\Admin;

use App\Models\Destination;
use App\Services\Validators\PricingValidator;
use Image,
    Input,
    Notification,
    Redirect,
    Sentry,
    Str;

class PricingController extends \BaseController {

    public function index() {
        //$results = \DB::select(\DB::raw("select d.id,d.name,p1.price_id as cbd_id,p1.base_price as cbd,p2.price_id as dom_id,p2.base_price as dom,p3.price_id as int_id,p3.base_price as intl from limo_destinations d inner join limo_prices p1 on d.id=p1.source_id and p1.destination_id=(select id from limo_destinations where type='cbd') inner join limo_prices p2 on d.id=p2.source_id and p2.destination_id=(select id from limo_destinations where type='dom') inner join limo_prices p3 on d.id=p3.source_id and p3.destination_id=(select id from limo_destinations where type='int') order by d.name asc"));
        //return \View::make('admin.limo.destinations.index')->with('destinations', $results);
        
        $results=Destination::all()->sortBy('type')->sortBy('name');
        //print_r($results);
        return \View::make('admin.limo.destinations.index')->with('destinations', $results);
    }

    public function getAllDestinations() {
        //return \Response::json(DestinationEx::getAll());
        //return null;
        return DestinationEx::getAllDestinations();
    }

    public function show($id) {
        return \View::make('admin.users.index')->with('users', Sentry::getUser()->$id);
    }

    public function create() {
        return \View::make('admin.limo.destinations.create');
    }

    public function oldstore001() {
        $validation = new PricingValidator;

        if ($validation->passes()) {
            try {
                $dest = new Destination;
                $dest->name = Input::get('name');
                $dest->type = 'suburb';

                $pricing1 = new Pricing;

                $pricing1->destination_id = Destination::where('type', 'cbd')->first()->id;
                $pricing1->base_price = Input::get('cbd');

                $pricing2 = new Pricing;
                $pricing2->destination_id = Destination::where('type', 'dom')->first()->id;
                $pricing2->base_price = Input::get('dom');

                $pricing3 = new Pricing;
                $pricing3->destination_id = Destination::where('type', 'int')->first()->id;
                $pricing3->base_price = Input::get('int');

                \DB::transaction(function() use($dest, $pricing1, $pricing2, $pricing3) {
                            $dest->save();
                            $last_id = $dest->id;

                            $pricing1->source_id = $last_id;
                            $pricing1->save();

                            $pricing2->source_id = $last_id;
                            $pricing2->save();

                            $pricing3->source_id = $last_id;
                            $pricing3->save();
                        });

                Notification::success('The new destination with pricing saved successfully!');

                return Redirect::route('admin.destinations.index');
            } catch (\Exception $e) {
                Notification::error($e->getMessage());
            }
        }

        return Redirect::back()->withInput()->withErrors($validation->errors);
    }
    
    public function store() {
        $validation = new PricingValidator;

        if ($validation->passes()) {
            $old=Destination::where('name',Input::get('name'))->first();
            if($old)
            {
                Notification::error('Name already exists. Please choose different one.');
                return Redirect::back()->withInput();
            }
           try {
                $dest = new Destination();
                $dest->name = Input::get('name');
                $dest->type = 'suburb';
                $dest->price_cbd = Input::get('price_cbd');
                $dest->price_dom = Input::get('price_dom');
                $dest->price_int = Input::get('price_int');

                $dest->save();

                Notification::success('The new destination with pricing saved successfully!');

                return Redirect::route('admin.destinations.index');
            } catch (\Exception $e) {
                Notification::error($e->getMessage());
            }
        }

        return Redirect::back()->withInput()->withErrors($validation->errors);
    }

    public function edit($id) {
        //$result = \DB::select(\DB::raw("select d.id,d.name,p1.price_id as cbd_id,p1.base_price as cbd,p2.price_id as dom_id,p2.base_price as dom,p3.price_id as int_id,p3.base_price as intl from limo_destinations d inner join limo_prices p1 on d.id=p1.source_id and p1.destination_id=(select id from limo_destinations where type='cbd') inner join limo_prices p2 on d.id=p2.source_id and p2.destination_id=(select id from limo_destinations where type='dom') inner join limo_prices p3 on d.id=p3.source_id and p3.destination_id=(select id from limo_destinations where type='int') where d.id=:id"), array('id' => $id));
        
        $result=Destination::find($id);
        return \View::make('admin.limo.destinations.edit')->with('dest', $result);
    }

    public function update($id) {
        $validation = new PricingValidator;

        if ($validation->passes()) {
            $old=Destination::where('name',Input::get('name'))->where('id','<>',$id)->first();
            if($old)
            {
                Notification::error('Name already exists. Please choose different one.');
                return Redirect::back()->withInput();
            }
            try {
                $dest = Destination::find($id);
                $dest->name = Input::get('name');
                $dest->price_cbd = Input::get('price_cbd');
                $dest->price_dom = Input::get('price_dom');
                $dest->price_int = Input::get('price_int');
                $dest->save();

                Notification::success('The destination with pricing updated successfully!');

                return Redirect::route('admin.destinations.index');
            } catch (\Exception $e) {
                Notification::error($e->getMessage());
            }
        }
        return Redirect::back()->withInput()->withErrors($validation->errors);
    }

    public function destroy($id) {
        try {
            $dest = Destination::find($id);
            $dest->delete();
            Notification::success('The destination was deleted successfully.');
            return Redirect::route('admin.destinations.index');
        } catch (\Exception $e) {
            Notification::error($e->getMessage());
        }
    }

}

