<?php

namespace App\Controllers\Admin\cms;

use App\Models\Contacts;
use Input,
    Notification,
    Redirect,
    Sentry,
    Str,
    Image;

class ContactsController extends \BaseController {

    public function index() {
        return \View::make('admin.cms.contacts.index')->with('contacts', Contacts::all());
    }

    public function destroy($id) {
        $g = Contacts::find($id);
        $g->delete();
        Notification::success('The contact was deleted successfully!');
        return Redirect::route('admin.cms.contacts.index');
    }

}
