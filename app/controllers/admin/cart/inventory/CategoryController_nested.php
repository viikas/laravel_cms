<?php

namespace App\Controllers\Admin\Cart;

use App\Repo\Cart\InventoryRepo;
use App\Models\Cart\Category;
use App\Services\Validators\Cart\CategoryValidator;
use Image,
    Input,
    Notification,
    Redirect,
    Sentry,
    Str;

class CategoryController_nested extends \BaseController {

    public function __construct(InventoryRepo $repo) {
        $this->repo=$repo;
    }
    public function index() {
        $items = $this->repo->getNestedCategories();
        return \View::make('admin.cart.inventory.category.index')->with('collection', $items);
    }

    private function getFullQCategories(&$collections) {
        foreach ($collections as $item) {
            if ($item->parent_id > 0) {
                $item->name = $this->getFullQName($item);
            }
        }
        return $collections;
    }

    private function getFullQName(&$item) {
        if ($item->parent_id == 0)
            return $item->name;
        else
            return $this->getFullQName($item->parent) . ' -> ' . $item->name;
    }

    public function show($id) {
        return \View::make('admin.cart.inventory.category.show')->with('item', Category::find($id));
    }

    public function create() {
        $items = Category::all();
        $items = $this->getFullQCategories($items);
        $items = $items->sortBy('name')->lists('name', 'id');
        $items = array('-1' => '--choose parent--') + $items;
        return \View::make('admin.cart.inventory.category.create')->with('cats', $items);
    }

    public function store() {
        $validation = new CategoryValidator;

        if ($validation->passes()) {
            $item = new Category;
            $item->name = Input::get('name');
            $item->summary = Input::get('summary');
            $item->details = Input::get('details');
            $item->parent_id = Input::get('parent_id');
            if (Input::has('is_available')) {
                $item->is_available = 1;
            }
            else
                $item->is_available = 0;
            $item->save();

            if (Input::hasFile('photo')) {
                $item->photo = Image::upload(Input::file('photo'), 'cart/category/' . $item->id);
                $item->save();
            }


            Notification::success('The new category was saved.');

            return Redirect::route('admin.cart.inventory.category.index');
        }

        return Redirect::back()->withInput()->withErrors($validation->errors);
    }

    public function edit($id) {
        try {
            $item = Category::findOrFail($id);
            $items = Category::all();
            $items = $this->getFullQCategories($items);
            $items = $items->sortBy('name')->lists('name', 'id');
            $items = array('-1' => '--choose parent--') + $items;
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Notification::error('No such item exists.');
            return Redirect::route('admin.cart.inventory.category.index');
        }
        return \View::make('admin.cart.inventory.category.edit')->with('item', $item)->with('cats', $items);
    }

    public function update($id) {
        $validation = new CategoryValidator;

        if ($validation->passes()) {

            $item = Category::find($id);
            $item->name = Input::get('name');
            $item->summary = Input::get('summary');
            $item->details = Input::get('details');
            $item->parent_id = Input::get('parent_id');
            if (Input::has('is_available')) {
                $item->is_available = 1;
            }
            else
                $item->is_available = 0;
            $item->save();

            if (Input::hasFile('photo')) {
                $item->photo = Image::upload(Input::file('photo'), 'cart/category/' . $item->id);
            }
            $item->save();

            return Redirect::route('admin.cart.inventory.category.index');
        }
        return Redirect::back()->withInput()->withErrors($validation->errors);
    }

    public function destroy($id) {
        try {
            $item = Category::find($id);
            if ($item != null) {
                $item->delete();
                Notification::success('The category was deleted successfully.');
            } else {
                Notification::error('The category does not exist or has been deleted already.');
            }

            return Redirect::route('admin.cart.inventory.category.index');
        } catch (\Exception $e) {
            Notification::error('The category could not be deleted.');
        }
    }

}

