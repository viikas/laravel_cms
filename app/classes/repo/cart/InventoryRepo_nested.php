<?php

namespace App\Repo\Cart;

use App\Models\Cart\Products;
use App\Models\Cart\Category;
use App\Models\Cart\Units;
use App\Models\Cart\Photos;
use App\Repo\BaseRepo;

class InventoryRepo_nested extends BaseRepo {

    public function getCategories() {
        return Category::all();
    }

    public function getNestedCategories() {
        $data = Category::all();
        $items = $this->getFullQCategories($data);
        return $items->sortBy('name');
    }

    public function getNestedCategoriesList() {
        $data = Category::all();
        $items = $this->getFullQCategories($data);
        $all = $items->sortBy('name');
        $cat_bags = array();
        foreach ($all as $each) {
            $cat_bags[$each->id] = $each->name;
        }
        return $cat_bags;
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

    public function getProducts() {
        return Products::all();
    }

    public function getProduct($id) {
        return Products::find($id);
    }
    
    public function getProductBySlug($slug) {
        return $this->getByField('slug', $slug, new Products);
    }
    
    public function getProductByCategory($cat) {
        return $this->getByField('slug', $slug, new Products);
    }

    public function saveProduct($all, $id) {
        if ($id == 0)
        {
            $row = new Products;
            $all['slug']=$this->getSlug($all['name'], $row);
            
        }
        else
            $row = Products::find($id);
        
        $msg = $this->save($row, $all);
        
        if (empty($msg)) {
            $cats = $all['cats'];
            try {
                /* foreach ($cats as $c) {
                  $new_cat = Category::find($c);
                  $row->category()->save($new_cat);
                  } */
                $row->category()->sync($cats, true);
            } catch (\Exception $e) {
                $msg = $e->getMessage();
            }
        }
        return $msg;
    }

    public function deleteProduct($id) {
        $row=Products::find($id);
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
    
    public function getProductPhotos($product_id)
    {
        $row=Photos::where('product_id',$product_id)->orderBy('sequence')->get();
        
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
        $max=Photos::where('product_id', $all['product_id'])->max('sequence');
        $all['sequence']=$max+1;
        $row = new Photos;
        $msg=$this->save($row, $all);
        return $msg;
    }
    
    public function updatePhoto($all,$id,$phid) {
        $row = Photos::where('product_id', $id)->where('id', $phid)->first();
        return $this->save($row, $all);
    }

    public function deletePhoto($product_id, $photo_id) {
        $row = Photos::where('product_id', $product_id)->where('id', $photo_id)->first();
        return $this->delete($row);
    }
    
    public function sortPhotoUp($product_id, $photo_id) {
        $row = Photos::where('product_id', $product_id)->where('id', $photo_id)->first();
        $prev=Photos::where('product_id',$product_id)->where('sequence','<',$row->sequence)->orderBy('sequence','desc')->first();
        $seq=$row->sequence;
        $row->sequence=$prev->sequence;
        $prev->sequence=$seq;
        try
        {
        $row->save();
        $prev->save();
        return "";
        }
        catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }
    
    public function sortPhotoDown($product_id, $photo_id) {
        $row = Photos::where('product_id', $product_id)->where('id', $photo_id)->first();
        $next=Photos::where('product_id',$product_id)->where('sequence','>',$row->sequence)->orderBy('sequence','asc')->first();
        $seq=$row->sequence;
        $row->sequence=$next->sequence;
        $next->sequence=$seq;
        try
        {
        $row->save();
        $next->save();
        return "";
        }
        catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }

}
