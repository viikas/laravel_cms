<?php

namespace App\Controllers\Site\Cart;

use App\Repo\Cart\InventoryRepo;
use Image,
    Input,
    Notification,
    Redirect,
    Str,
    Cart,URL;

class ProductsController extends \BaseController {

    public function __construct(InventoryRepo $repo) {
        $this->repo = $repo;
    }

    public function index() {
        return \View::make('site::index')->with('collection', $this->repo->getActiveProducts());
    }
    
    public function products() {
        $bread = array(array('url' => URL::route('site.products'), 'name' => 'products'));
        return \View::make('site::cart.allproducts')->with('collection', $this->repo->getActiveProducts())->with('bread',$bread);
    }

    public function category_products($cat) {
        $item=$this->repo->getActiveCategoryBySlug($cat);
        //dd($item);
        if(is_null($item))
        {
            return Redirect::route('site.home');
        }
        $all_products=URL::route('site.products');
        $cat_products=URL::route('site.categoryproducts',$cat);   
        
        $bread = array(array('url' => $all_products, 'name' => 'products'),array('url' => $cat_products, 'name' => $item->name));
        return \View::make('site::cart.catproducts')->with('item',$item)->with('collection', $this->repo->getActiveProductsByCategory($cat))->with('bread',$bread);
    }

    public function show($slug) {
        $item = $this->repo->getActiveProductBySlug($slug);
        if (is_null($item)) {
            Notification::error('No such product exists.');
            return Redirect::route('site.home');
        }
        $all_products=URL::route('site.products');
        $cat_products=URL::route('site.categoryproducts',$item->category->slug);    
        
        $this_product=URL::route('site.product',$slug);
        $bread = array(array('url' => $all_products, 'name' => 'products'),array('url' => $cat_products, 'name' => $item->category->name), array('url' => $this_product, 'name' => $item->name));
        //return \View::make('site::cart.product')->with('item', $item)->with('photos',$this->repo->getProductPhotos($item->id))->with('bread',$bread);
        return \View::make('site::cart.product')->with('item', $item)->with('photos', $this->repo->getProductPhotos($item->id))->with('bread', $bread);
    }

}

