<?php

namespace App\Controllers\Admin;

use App\Models\Limousine;
use App\Services\Validators\LimousineValidator;
use Image,
    Input,
    Notification,
    Redirect,
    Sentry,
    Str;

class LimousinesController extends \BaseController {

    public function index() {
        return \View::make('admin.limo.limousines.index')->with('limousines', Limousine::all());
    }

    public function show($id) {
        return \View::make('admin.users.index')->with('users', Sentry::getUser()->$id);
    }

    public function create() {
        return \View::make('admin.limo.limousines.create');
    }

    public function store() {
        $validation = new LimousineValidator;

        if ($validation->passes()) {
            $limo = new Limousine;
            $limo->name = Input::get('name');
            $limo->details = Input::get('details');
            $limo->price_factor = Input::get('price_factor');
            $limo->capacity = Input::get('capacity');
            $limo->baggage = Input::get('baggage');
            $limo->save();

            if (Input::hasFile('photo')) {
                $limo->photo = Image::upload(Input::file('photo'), 'limousines/' . $limo->id);
                $limo->save();
            }

            Notification::success('The new limousine was saved.');

            return Redirect::route('admin.limousines.index');
        }

        return Redirect::back()->withInput()->withErrors($validation->errors);
    }

    public function edit($id) {
        $limo = Limousine::find($id);
        return \View::make('admin.limo.limousines.edit')->with('limo', $limo);
    }

    public function update($id) {
        $validation = new LimousineValidator;

        if ($validation->passes()) {

            $limo = Limousine::find($id);
            $limo->name = Input::get('name');
            $limo->details = Input::get('details');
            $limo->price_factor = Input::get('price_factor');
            $limo->capacity = Input::get('capacity');
            $limo->baggage = Input::get('baggage');
            if (Input::hasFile('photo'))
                $limo->photo = Image::upload(Input::file('photo'), 'limousines/' . $limo->id);

            $limo->save();

            return Redirect::route('admin.limousines.index');
        }
        return Redirect::back()->withInput()->withErrors($validation->errors);
    }

    public function destroy($id) {
        try {
            $limo = Limousine::find($id);

            $limo->delete();

            Notification::success('The limousine was deleted successfully.');
            return Redirect::route('admin.limousines.index');
        } catch (\Exception $e) {
            Notification::error('The limousine could not be deleted.');
        }
    }

}

