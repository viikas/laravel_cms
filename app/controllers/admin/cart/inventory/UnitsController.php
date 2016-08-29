<?php

namespace App\Controllers\Admin\Cart;

use App\Models\Cart\Units;
use App\Models\Cart\Products;
use App\Services\Validators\Cart\UnitsValidator;
use Image,
    Input,
    Notification,
    Redirect,
    Sentry,
    Str;

class UnitsController extends \BaseController {

    public function index() {
        return \View::make('admin.cart.inventory.units.index')->with('collection', Units::all());
    }

    public function show($id) {
        //return \View::make('admin.users.index')->with('users', Sentry::getUser()->$id);
    }

    public function create() {
        return \View::make('admin.cart.inventory.units.create');
    }

    public function store() {
        $validation = new UnitsValidator;

        if ($validation->passes()) {
            $item = new Units;
            $item->display_name = Input::get('display_name');
            $item->unit_name = Input::get('unit_name');
            $item->save();


            Notification::success('The new unit was saved.');

            return Redirect::route('admin.cart.inventory.units.index');
        }

        return Redirect::back()->withInput()->withErrors($validation->errors);
    }

    public function edit($id) {
        try {
            $item = Units::findOrFail($id);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Notification::error('No such item exists.');
            return Redirect::route('admin.cart.inventory.units.index');
        }
        return \View::make('admin.cart.inventory.units.edit')->with('item', $item);
    }

    public function update($id) {
        $validation = new UnitsValidator;

        if ($validation->passes()) {

            $item = Units::findorfail($id);
            $item->display_name = Input::get('display_name');
            $item->unit_name = Input::get('unit_name');
            $item->save();

            return Redirect::route('admin.cart.inventory.units.index');
        }
        return Redirect::back()->withInput()->withErrors($validation->errors);
    }

    public function destroy($id) {
        try {
            $item = Units::find($id);
            if ($item != null) {
                if(Products::where('unit_id',$id)->count()>0)
                {
                    Notification::error('There are one or more products with this unit. You should first delete those products to delete this unit.');
                }
                else
                {
                $item->delete();
                Notification::success('The unit was deleted successfully.');
                }
            } else {
                Notification::error('The unit does not exist or has been deleted already.');
            }

            return Redirect::route('admin.cart.inventory.units.index');
        } catch (\Exception $e) {
            Notification::error('The unit could not be deleted.');
        }
    }

}

