<?php

namespace App\Controllers\Admin;

use App\Models\Group;
use App\Models\Permission;
use App\Services\Validators\CreateGroupValidator;
use Image,
    Input,
    Notification,
    Redirect,
    Sentry,
    Str;

class GroupsController extends \BaseController {

    public function index() {
        return \View::make('admin.groups.index')->with('groups', Sentry::findAllGroups());
    }

    public function create() {
        return \View::make('admin.groups.create')->with('permissions',Permission::all());
    }

    public function show() {
        return "hello from show only!";
    }

    public function store() {
        $validation = new CreateGroupValidator;

        if ($validation->passes()) {
            try {
                // Create the group
                $permissions = Input::get('permissions[]');
                $pers=array();
                foreach($permissions as $p)
                {
                    $pname=Permission::find($p)->name;
                    array_add($pers,$pname,'1');
                }
                                
                $group = Sentry::createGroup(array(
                    'name'        => Input::get('name'),
                    'permissions' => $pers
                )); 

                return Redirect::route('admin.groups.index');
            } 
            catch (\Cartalyst\Sentry\Groups\GroupExistsException $e)
            {
                Notification::error('A group with same name already exists.');
            }
        }

        return Redirect::back()->withInput()->withErrors($validation->errors);
    }

    public function edit($id) {
        return \View::make('admin.groups.edit')->with('group', Sentry::findGroupById($id));
    }

    public function update($id) {
        $validation = new CreateGroupValidator;

        if ($validation->passes()) {
            try {
                // Create the group
                $group = Sentry::findGroupById($id);
                $group->name=Input::get('name');
                $group->save();

                Notification::success('The group was updated.');

                return Redirect::route('admin.groups.index');
            } 
            catch (\Cartalyst\Sentry\Groups\GroupExistsException $e)
            {
                Notification::error('A group with same name already exists.');
            }
            catch (\Cartalyst\Sentry\Groups\GroupNotFoundException $e)
            {
                Notification::error('No such group was found.');
            }
        }
        return Redirect::back()->withInput()->withErrors($validation->errors);
    }

    public function destroy($id) {
        try {
            // Find the group using the group id
            $group = Sentry::findGroupById($id);

            // Delete the group
            $group->delete();

            Notification::success('The group was deleted.');
            return Redirect::route('admin.groups.index');
        } 
        catch (\Cartalyst\Sentry\Groupss\GroupNotFoundException $e) {
            Notification::error('No such group was found.');
            return Redirect::route('admin.groups.index');
        }
    }

}

