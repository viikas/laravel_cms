<?php

namespace App\Controllers\Admin\cms;
use App\Services\Validators\CMSCategoryValidator;
use App\Models\Category;
use Input,
    Notification,
    Redirect,
    Sentry,
    Str;

class CategoryController extends \BaseController {

    public function index() {
        return \View::make('admin.cms.category.index')->with('cats', Category::all());
    }

    public function show($id) {
        return \View::make('admin.cms.category.show')->with('category', Category::find($id));
    }

    public function create() {
        return \View::make('admin.cms.category.create');
    }

    public function store() {
        $validation = new CMSCategoryValidator;
        if ($validation->passes()) {
            $category = new Category;
            $category->code = Input::get('code');
            $category->name = Input::get('name');
            $category->save();

            Notification::success('New category was created successfully!');

            return Redirect::route('admin.cms.category.index');
        }

        return Redirect::back()->withInput()->withErrors($validation->errors);
    }

    public function edit($id) {
        return \View::make('admin.cms.category.edit')->with('category', Category::find($id));
    }

    public function update($id) {
        $validation = new CMSCategoryValidator;

        if ($validation->passes()) {
            $category = Category::find($id);
             $category->code = Input::get('code');
            $category->name = Input::get('name');
            $category->save();

            Notification::success('The category was saved successfully!');

            return Redirect::route('admin.cms.category.index');
        }

        return Redirect::back()->withInput()->withErrors($validation->errors);
    }

    public function destroy($id) {
        $cat = Category::find($id);
        $cat->delete();

        Notification::success('The category was deleted successfully!');

        return Redirect::route('admin.cms.category.index');
    }

}
