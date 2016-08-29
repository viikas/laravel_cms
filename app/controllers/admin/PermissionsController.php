<?php

namespace App\Controllers\Admin;

use App\Models\Permission;
use App\Services\Validators\PermissionValidator;
use Image,
    Input,
    Notification,
    Redirect,
    Sentry,
    Str;

class PermissionsController extends \BaseController {

    public function index() {
        return \View::make('admin.permissions.index')->with('permissions', Permission::all());
    }

    public function create() {
        return \View::make('admin.permissions.create');
    }

    public function show($id) {
        return Permissins::find($id)->name;
    }

    public function store() {
        $validation = new PermissionValidator;

        if ($validation->passes()) {
            try {
                $permission = new Permission;
                $permission->name=Input::get('name');
                $permission->save();
                Notification::success('New permission was saved.');

                return Redirect::route('admin.permissions.index');
            } 
            catch (\Exception $e)
            {
                Notification::error('OOps.. permission could not be added.');
            }
        }

        return Redirect::back()->withInput()->withErrors($validation->errors);
    }

    public function edit($id) {
        return \View::make('admin.permissions.edit')->with('permission', Permission::find($id));
    }

    public function update($id) {
        $validation = new PermissionValidator;

        if ($validation->passes()) {
            try {
                $permission = Permission::find($id);
                $permission->name=Input::get('name');
                $permission->save();
                Notification::success('Permission saved successfully!');                

                return Redirect::route('admin.permissions.index');
            } 
            catch (\Exception $e)
            {
                //Notification::error('OOps.. permission could not be saved.');
                //Notification::error($e->getMessage());
            }
        }

        return Redirect::back()->withInput()->withErrors($validation->errors);
    }

    public function destroy($id) {
        try {
            $permission = Permission::find($id);

            $permission->delete();

            Notification::success('The permission was deleted.');
            return Redirect::route('admin.permissions.index');
        } 
        catch (\Exception $e) {
            Notification::error('Oops.. permission could not be deleted.');
            return Redirect::route('admin.permissions.index');
        }
    }

}

