<?php

namespace App\Controllers\Admin\Cart;

use App\Repo\Cart\InventoryRepo;
use App\Models\Cart\Category;
use App\Models\Cart\Products;
use App\Services\Validators\Cart\CategoryValidator;
use Image,
    Input,
    Notification,
    Redirect,
    Sentry,
    Str;

class CategoryController extends \BaseController {

    public function __construct(InventoryRepo $repo) {
        $this->repo = $repo;
    }

    public function index() {
        $items = $this->repo->getCategories();
        return \View::make('admin.cart.inventory.category.index')->with('collection', $items);
    }

    public function show($id) {
        return \View::make('admin.cart.inventory.category.show')->with('item', Category::find($id));
    }

    public function create() {
        return \View::make('admin.cart.inventory.category.create');
    }

    public function store() {
        $validation = new CategoryValidator;

        if ($validation->passes()) {
            $item = new Category;
            $item->name = Input::get('name');
            $item->summary = Input::get('summary');
            $item->details = Input::get('details');
            $item->parent_id = 0;
            $item->slug = $this->repo->getSlug($item->name, $item);
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
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Notification::error('No such item exists.');
            return Redirect::route('admin.cart.inventory.category.index');
        }
        return \View::make('admin.cart.inventory.category.edit')->with('item', $item);
    }

    public function update($id) {
        $validation = new CategoryValidator;

        if ($validation->passes()) {

            $item = Category::find($id);
            $item->name = Input::get('name');
            $item->summary = Input::get('summary');
            $item->details = Input::get('details');

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
                if (Products::where('category_id',$id)->count() > 0) {
                    Notification::error('There are one or more products in this category. You should first delete those products to delete this category.');
                } else {
                    $item->delete();
                    Notification::success('The category was deleted successfully.');
                }
            } else {
                Notification::error('The category does not exist or has been deleted already.');
            }

            return Redirect::route('admin.cart.inventory.category.index');
        } catch (\Exception $e) {
            Notification::error('The category could not be deleted.');
        }
    }

}

