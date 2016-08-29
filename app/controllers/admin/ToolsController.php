<?php

namespace App\Controllers\Admin;

class ToolsController extends \BaseController {

    public function filesmanager() {
        return \View::make('admin.tools.filemanager.index');
    }
    
    public function filesbrowser() {
        return \View::make('admin.tools.filemanager.browse');
    }

}

