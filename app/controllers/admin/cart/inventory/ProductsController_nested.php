<?php

namespace App\Controllers\Admin\Cart;

use App\Services\Validators\Cart\ProductsValidator;
use App\Services\Validators\Cart\PhotosValidator;
use App\Repo\Cart\InventoryRepo;
use Image,
    Input,
    Notification,
    Redirect,
    Sentry,
    Str;

class ProductsController_nested extends \BaseController {

    public function __construct(InventoryRepo $repo) {
        $this->repo = $repo;
    }

    public function index() {
        return \View::make('admin.cart.inventory.products.index')->with('collection', $this->repo->getProducts())->with('cats', $this->repo->getNestedCategoriesList());
    }

    public function show($id) {
        $item = Products::find($id);
        if (is_null($item)) {
            Notification::error('No such item exists.');
            return Redirect::route('admin.cart.inventory.products.index');
        }
        return \View::make('admin.cart.inventory.products.index')->with('item', item);
    }

    public function create() {
        $unitsList = $this->repo->getUnitsList();
        $units = \Helper::SetDefaultSelect($unitsList, '', '--choose unit--');
        return \View::make('admin.cart.inventory.products.create')->with('cats', $this->repo->getNestedCategories())->with('units', $units);
    }

    public function store() {
        $validation = new ProductsValidator;
        if ($validation->passes()) {
            $all = Input::all();
            if (!Input::has('is_available'))
                $all['is_available'] = 0;
            $msg = $this->repo->saveProduct($all, 0);
            if (empty($msg)) {
                Notification::success('The new product was saved.');
                return Redirect::route('admin.cart.inventory.products.index');
            }
            else
                Notification::error('ERROR: ' . $msg);
        }

        return Redirect::back()->withInput()->withErrors($validation->errors);
    }

    public function edit($id) {
        try {
            $item = $this->repo->getProduct($id);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Notification::error('No such item exists.');
            return Redirect::route('admin.cart.inventory.products.index');
        }
        return \View::make('admin.cart.inventory.products.edit')->with('item', $item)->with('cats', $this->repo->getNestedCategories())->with('units', $this->repo->getUnitsList())->with('cats_bag', $this->repo->getProductCategoriesArray($id));
    }

    public function update($id) {
        $validation = new ProductsValidator;
        if ($validation->passes()) {
            $all = Input::all();
            if (!Input::has('is_available'))
                $all['is_available'] = 0;
            else
                $all['is_available'] = 1;
            $msg = $this->repo->saveProduct($all, $id);
            if (empty($msg)) {
                Notification::success('The product was saved.');
                return Redirect::route('admin.cart.inventory.products.index');
            }
            else
                Notification::error('ERROR: ' . $msg);
        }

        return Redirect::back()->withInput()->withErrors($validation->errors);
    }

    public function destroy($id) {
        $msg = $this->repo->deleteProduct($id);
        if (empty($msg))
            Notification::success('The product was deleted successfully.');
        else {
            Notification::error('The product does not exist or has been deleted already.');
        }
        return Redirect::route('admin.cart.inventory.products.index');
    }

    /*     * ***************************** */
    /*     * ********* photos ********** */
    /*     * ***************************** */

    public function photos($id) {
        return \View::make('admin.cart.inventory.photos.index')->with('item', $this->repo->getProduct($id))->with('photos',$this->repo->getProductPhotos($id));
    }

    public function createphoto($id) {
        $item = $this->repo->getProduct($id);
        return \View::make('admin.cart.inventory.photos.create')->with('item', $item);
    }

    public function addphoto($id) {

        $validation = new PhotosValidator;
        if ($validation->passes()) {
            $all = Input::all();
            //dd($all);
            if (Input::hasFile('photo_image')) {
                $identifier = \Helper::GetRandomString(6);
                $all['photo'] = Image::upload(Input::file('photo_image'), 'cart/photos/' . $identifier);
            }
            $all['product_id'] = $id;
            $msg = $this->repo->savePhoto($all);
            if (empty($msg)) {
                Notification::success('The photo was saved.');
                return Redirect::route('admin.cart.inventory.products.photos', $id);
            }
            else
                Notification::error('ERROR: ' . $msg);
        }

        return Redirect::back()->withInput()->withErrors($validation->errors);
    }

    public function editphoto($id, $phid) {
        $photo = $this->repo->getProductPhoto($id, $phid);
        //dd($photo->photo);
        if (is_null($photo)) {
            Notification::error('No such item exists.');
            return Redirect::route('admin.cart.inventory.products.index');
        }
        return \View::make('admin.cart.inventory.photos.edit')->with('item', $this->repo->getProduct($id))->with('photo', $photo);
    }

    public function updatephoto($id, $phid) {
        $all = Input::all();
        if (Input::hasFile('photo_image')) {
            $identifier = \Helper::GetRandomString(6);
            $all['photo'] = Image::upload(Input::file('photo_image'), 'cart/photos/' . $identifier);
        }
        $all['product_id'] = $id;
        $msg = $this->repo->updatePhoto($all, $id, $phid);
        if (empty($msg)) {
            Notification::success('The photo was saved.');
            return Redirect::route('admin.cart.inventory.products.photos', $id);
        }
        else
            Notification::error('ERROR: ' . $msg);


        return Redirect::back()->withInput()->withErrors($validation->errors);
    }

    public function deletephoto($id, $phid) {
        $msg = $this->repo->deletePhoto($id, $phid);
        if (empty($msg)) {
            Notification::success('The photo was deleted.');
        }
        else
            Notification::error('ERROR: ' . $msg);
        return Redirect::to('admin/cart/inventory/products/' . $id . '/photos');
    }
    
    public function sortUp($id, $phid) {
        $msg = $this->repo->sortPhotoUp($id, $phid);
        if (empty($msg)) {
            Notification::success('The photo was moved up.');
        }
        else
            Notification::error('ERROR: ' . $msg);
        return Redirect::to('admin/cart/inventory/products/' . $id . '/photos');
    }
    
    public function sortDown($id, $phid) {
        $msg = $this->repo->sortPhotoDown($id, $phid);
        if (empty($msg)) {
            Notification::success('The photo was moved down.');
        }
        else
            Notification::error('ERROR: ' . $msg);
        return Redirect::to('admin/cart/inventory/products/' . $id . '/photos');
    }

}

