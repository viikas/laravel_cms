<?php

namespace App\Repo\Cart;

use App\Models\Cart\Products;
use App\Models\Cart\Category;
use App\Models\Cart\Units;
use App\Models\Cart\Photos;
use App\Repo\BaseRepo;
use Illuminate\Support\Collection;

class InventoryRepo extends BaseRepo {

    public function getCategories() {
        return Category::all();
    }

    public function getActiveCategories() {
        return Category::where('is_available', '1')->get();
    }

    public function getCategoriesList() {
        return Category::all()->lists('name', 'id');
    }

    public function getCategoryBySlug($slug) {
        return Category::where('slug', $slug)->first();
    }
    
    public function getActiveCategoryBySlug($slug) {
        return Category::where('slug', $slug)->where('is_available','1')->first();
    }

    public function getCategoryProducts($slug) {
        $cat = Category::where('slug', $slug)->first()->id;
        return Products::where('category_id', $cat)->get();
    }

    public function getProducts() {
        return Products::all();
    }

    public function getActiveProducts() {
        return Products::where('is_available', '=', '1')->get();
    }
    
    public function getActiveFeaturedProducts() {
        return Products::where('is_available', '=', '1')->where('is_featured','1')->get();
    }

    public function getProduct($id) {
        return Products::find($id);
    }

    public function getActiveProduct($id) {
        return Products::find($id)->where('is_available', '1')->first();
    }

    public function getProductBySlug($slug) {
        return $this->getByField('slug', $slug, new Products);
    }

    public function getActiveProductBySlug($slug) {
        return Products::where('slug', $slug)->where('is_available', '1')->first();
    }

    public function getProductsByCategory($cat) {
        return $this->getByField('slug', $slug, new Products);
    }

    public function getActiveProductsByCategory($cat) {
        $cat = Category::where('slug', $cat)->where('is_available', '1')->first();
        if (is_null($cat))
            return new Collection;
        return Products::where('category_id', $cat->id)->where('is_available', '1')->get();
    }

    public function saveProduct($all, $id) {
        if ($id == 0) {
            $row = new Products;
            $all['slug'] = $this->getSlug($all['name'], $row);
        }
        else
            $row = Products::find($id);

        $msg = $this->save($row, $all);
        return $msg;
    }

    public function deleteProduct($id) {
        $row = Products::find($id);
        //dd($row);
        if ($row->photos()->count() > 0) {
            return 'This product has ' . $row->photos()->count() . ' photos. Please delete them first to delete this product.';
        }
        else
            return $this->delete($row);
    }

    public function getProductCategoriesArray($id) {
        //return (array)Products::find($id)->category()->count();
        $all = Products::find($id)->category()->select('category_id')->get();
        $cat_bags = array();
        foreach ($all as $cat) {
            array_push($cat_bags, $cat->category_id);
        }
        return $cat_bags;
    }

    public function getUnits() {
        return Units::all();
    }

    public function getUnitsList() {
        return Units::all()->lists('display_name', 'id');
    }

    public function getProductPhotos($product_id) {
        $row = Photos::where('product_id', $product_id)->orderBy('sequence')->get();

        //dd($row);
        return $row;
    }

    public function getProductPhoto($product_id, $photo_id) {
        try {
            $row = Photos::where('product_id', $product_id)->where('id', $photo_id)->first();
            return $row;
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return null;
        }
    }

    public function savePhoto($all) {
        $max = Photos::where('product_id', $all['product_id'])->max('sequence');
        $all['sequence'] = $max + 1;
        $row = new Photos;
        $msg = $this->save($row, $all);
        return $msg;
    }

    public function updatePhoto($all, $id, $phid) {
        $row = Photos::where('product_id', $id)->where('id', $phid)->first();
        return $this->save($row, $all);
    }

    public function deletePhoto($product_id, $photo_id) {
        $row = Photos::where('product_id', $product_id)->where('id', $photo_id)->first();
        return $this->delete($row);
    }

    public function sortPhotoUp($product_id, $photo_id) {
        $row = Photos::where('product_id', $product_id)->where('id', $photo_id)->first();
        $prev = Photos::where('product_id', $product_id)->where('sequence', '<', $row->sequence)->orderBy('sequence', 'desc')->first();
        $seq = $row->sequence;
        $row->sequence = $prev->sequence;
        $prev->sequence = $seq;
        try {
            $row->save();
            $prev->save();
            return "";
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function sortPhotoDown($product_id, $photo_id) {
        $row = Photos::where('product_id', $product_id)->where('id', $photo_id)->first();
        $next = Photos::where('product_id', $product_id)->where('sequence', '>', $row->sequence)->orderBy('sequence', 'asc')->first();
        $seq = $row->sequence;
        $row->sequence = $next->sequence;
        $next->sequence = $seq;
        try {
            $row->save();
            $next->save();
            return "";
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

}
