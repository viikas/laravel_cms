<?php

namespace App\Controllers\Admin;

use App\Models\User;
use App\Services\Validators\UserValidator;
use App\Services\Validators\EditUserValidator;
use App\Services\Validators\CreateUserValidator;
use App\Services\Validators\ChangePasswordValidator;
use Image,
    Input,
    Notification,
    Redirect,
    Sentry,
    Str;

class UsersController extends \BaseController {

    public function index() {
        return \View::make('admin.users.index')->with('users', Sentry::findAllUsers());
    }

    public function show($id) {
        return \View::make('admin.users.index')->with('users', Sentry::getUser()->$id);
    }

    public function create() {
        return \View::make('admin.users.create')->with('groups',Sentry::getGroups()->lists('name','id'));
    }

    public function store() {
        $validation = new CreateUserValidator;

        if ($validation->passes()) {
            try {
                // Create the user
                $user = Sentry::createUser(array(
                            'first_name' => Input::get('first_name'),
                            'last_name' => Input::get('last_name'),
                            'email' => Input::get('email'),
                            'password' => Input::get('password'),
                            'activated' => Input::get('activated', false)
                        ));

                // Find the group using the group id
                $groupId=Input::get('groupid');
                $adminGroup = Sentry::findGroupById($groupId);

                // Assign the group to the user
                $user->addGroup($adminGroup);
            } catch (\Cartalyst\Sentry\Users\UserExistsException $e) {
                Notification::error('User with this email already exists.');
            } catch (\Cartalyst\Sentry\Groups\GroupNotFoundException $e) {
                Notification::error('Group was not found.');
            }

            Notification::success('The user was saved.');

            return Redirect::route('admin.users.index', $user->id);
        }

        return Redirect::back()->withInput()->withErrors($validation->errors);
    }

    public function edit($id) {
        $user=Sentry::findUserById($id);
        return \View::make('admin.users.edit')->with('user', $user)->with('groups',Sentry::getGroups()->lists('name','id'))->with('groupId',$user->getGroups()->lists('id'));
    }

    public function update($id) {
        $validation = new EditUserValidator;

        if ($validation->passes()) {
            try {
                // Find the user using the user id
                $user = Sentry::findUserById($id);

                // Update the user details
                $user->first_name = Input::get('first_name');
                $user->last_name = Input::get('last_name');
                $user->activated = Input::get('activated', false);

                // Update the user
                if ($user->save()) {
                    // Find the group using the group id
                    $groupId=Input::get('groupid');
                    $adminGroup = Sentry::findGroupById($groupId);

                    // Assign the group to the user
                    $user->addGroup($adminGroup);
                
                    Notification::success('The user was saved.');
                } else {
                    Notification::error('The user could not be saved.');
                }
            } catch (\Cartalyst\Sentry\Users\UserExistsException $e) {
                Notification::error('User with this email already exists.');
            } catch (\Cartalyst\Sentry\Users\UserNotFoundException $e) {
                Notification::error('User was not found.');
            }
            return Redirect::route('admin.users.index');
        }
        return Redirect::back()->withInput()->withErrors($validation->errors);
    }

    public function destroy($id) {
        try {
            // Find the user using the user id
            $user = Sentry::findUserById($id);

            // Delete the user
            $user->delete();

            Notification::success('The user was deleted.');
            return Redirect::route('admin.users.index');
        } catch (\Cartalyst\Sentry\Users\UserNotFoundException $e) {
            Notification::error('User was not found.');
        }
    }

    public function reset($id) {

        return \View::make('admin.users.reset')->with('user', Sentry::findUserById($id));
    }

    public function resetpwd($id) {
        try {
            // Find the user using the user id
            $user = Sentry::findUserById($id);
            $newpwd = str_random(6);
            $user->password = $newpwd;
            $user->save();

            // the data that will be passed into the mail view blade template
            $data = array(
                'name' => $user->first_name,
                'email' => $user->email,
                'password' => $newpwd
            );
            
            // use Mail::send function to send email passing the data and using the $user variable in the closure
            \Mail::send('emails.resetpwd', $data, function($message) use ($user) {
                        $message->to($user->email, $user->first_name)->subject('You password at laravel site has been reset');
                    });

            Notification::success('Password of the user was reset and emailed successfully.');
            return Redirect::route('admin.users.index');
        } catch (\Cartalyst\Sentry\Users\UserNotFoundException $e) {
            Notification::error('User was not found.');
        }
    }

    public function password() {

        return \View::make('admin.users.password')->with('user', Sentry::check());
    }

    public function changepwd() {
        $validation = new ChangePasswordValidator;

        if ($validation->passes()) {
            try {
                // Find the user using the user id
                $user = Sentry::getUser();
                $curpwd =Input::get('current_password');
                if (!$user->checkPassword($curpwd)) {
                    Notification::error('Current password does not match.');    
                    return Redirect::back()->withInput()->withErrors($validation->errors);
                }
                $newpwd = Input::get('password');
                $user->password = $newpwd;
                $user->save();

                // the data that will be passed into the mail view blade template
                $data = array(
                    'name' => $user->first_name,
                    'email' => $user->email,
                    'password' => $newpwd
                );

                //\Hash::make($newpwd)
                // use Mail::send function to send email passing the data and using the $user variable in the closure
                \Mail::send('emails.changepwd', $data, function($message) use ($user) {
                            $message->to($user->email, $user->first_name)->subject('You password at laravel site has been reset');
                        });

                Notification::success('You have changed your password successfully. An email has been sent to your inbox describing the same.');
                return Redirect::route('admin.users.index');
            } catch (\Cartalyst\Sentry\Users\UserNotFoundException $e) {
                Notification::error('User was not found.');
            }
        }
        return Redirect::back()->withInput()->withErrors($validation->errors);
    }

}

