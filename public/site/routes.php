<?php

// Home page
Route::get('/', array('as' => 'site.index','uses'=>'App\Controllers\Site\PublicController@index'));
// contact
Route::get('contact', array('as' => 'site.contact','uses'=>'App\Controllers\Site\PublicController@contact'));
Route::post('contact', array('as' => 'site.contact.save','uses'=>'App\Controllers\Site\PublicController@contact_save'));

// Pages
Route::get('page/{code}',  array('as'=>'site.page','uses' => 'App\Controllers\Site\PublicController@page'));

// Gallery
Route::get('gallery',  array('as'=>'site.gallery','uses' => 'App\Controllers\Site\PublicController@gallery'));

// Album
Route::get('gallery/{id}',  array('as'=>'site.gallery.album','uses' => 'App\Controllers\Site\PublicController@album'));

// Category
Route::get('category/{code}',  array('as'=>'site.category','uses' => 'App\Controllers\Site\PublicController@categories'));
// Category page details
Route::get('category/content/{id}',  array('as'=>'site.category.details','uses' => 'App\Controllers\Site\PublicController@category'));


Route::get('/cart',  array('as'=>'site.cart.index','uses' => 'App\Controllers\Site\Cart\CartController@index'));
Route::post('/cart/{slug}/add',  array('as'=>'site.cart.add','uses' => 'App\Controllers\Site\Cart\CartController@add'));
Route::post('/cart/{id}/remove',  array('as'=>'site.cart.remove','uses' => 'App\Controllers\Site\Cart\CartController@remove'));
Route::post('/cart/update',  array('as'=>'site.cart.update','uses' => 'App\Controllers\Site\Cart\CartController@update'));
Route::get('/cart/checkout',  array('as'=>'site.cart.checkout','uses' => 'App\Controllers\Site\Cart\CartController@checkout'));
Route::post('/cart/checkout',  array('as'=>'site.cart.cancelcheckout','uses' => 'App\Controllers\Site\Cart\CartController@cancelcheckout'));
Route::post('/cart/checkout/payment',  array('as'=>'site.cart.payment','uses' => 'App\Controllers\Site\Cart\CartController@payment'));
Route::get('/cart/checkout/paynow',  array('as'=>'site.cart.paynow','uses' => 'App\Controllers\Site\Cart\CartController@paynow'));
Route::post('/cart/checkout/paypal-redirect',  array('as'=>'site.cart.paypal_redirect','uses' => 'App\Controllers\Site\Cart\CartController@paypal_redirect'));
Route::get('/cart/checkout/paypal-return',  array('as'=>'site.cart.paypal_return','uses' => 'App\Controllers\Site\Cart\CartController@paypal_return'));
Route::get('/cart/checkout/paypal-cancel',  array('as'=>'site.cart.paypal_cancel','uses' => 'App\Controllers\Site\Cart\CartController@paypal_cancel'));
Route::post('/cart/checkout/paypal-process',  array('as'=>'site.cart.checkout.paypal_process','uses' => 'App\Controllers\Site\Cart\CartController@paypal_process'));

Route::get('/cart/checkout/result',  array('as'=>'site.cart.checkout.result','uses' => 'App\Controllers\Site\Cart\CartController@result'));



Route::get('/products',  array('as'=>'site.products','uses' => 'App\Controllers\Site\Cart\ProductsController@products'));
Route::get('/products/{cat}',  array('as'=>'site.categoryproducts','uses' => 'App\Controllers\Site\Cart\ProductsController@category_products'));
//Route::get('/{slug}',  array('as'=>'site.product','uses' => 'App\Controllers\Site\Cart\ProductsController@show'));

// 404 Page
App::missing(function($exception)
{
    return Response::view('site::404', array(), 404);
    //return "oops";
});





