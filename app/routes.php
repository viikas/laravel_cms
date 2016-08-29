<?php

/*
  |--------------------------------------------------------------------------
  | Application Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register all of the routes for an application.
  | It's a breeze. Simply tell Laravel the URIs it should respond to
  | and give it the Closure to execute when that URI is requested.
  |
 */

Route::get('admin/logout', array('as' => 'admin.logout', 'uses' => 'App\Controllers\Admin\AuthController@getLogout'));
Route::get('admin/login', array('as' => 'admin.login', 'uses' => 'App\Controllers\Admin\AuthController@getLogin'));
Route::post('admin/login', array('as' => 'admin.login.post', 'uses' => 'App\Controllers\Admin\AuthController@postLogin'));

Route::group(array('prefix' => 'admin', 'before' => 'auth.admin'), function() {
            Route::any('/', 'App\Controllers\Admin\cms\PagesController@index');
            Route::resource('cms/articles', 'App\Controllers\Admin\cms\ArticlesController');
            Route::resource('cms/pages', 'App\Controllers\Admin\cms\PagesController');
            Route::resource('cms/category', 'App\Controllers\Admin\cms\CategoryController');
            Route::resource('cms/contacts', 'App\Controllers\Admin\cms\ContactsController');
            Route::get('gallery/{id}/photos', array('as' => 'admin.cms.gallery.photos', 'uses' => 'App\Controllers\Admin\cms\GalleryController@photos'));
            Route::get('gallery/{id}/photos/create', array('as' => 'admin.cms.gallery.photos.create', 'uses' => 'App\Controllers\Admin\cms\GalleryController@create_photo'));
            Route::post('gallery/{id}/photos/store', array('as' => 'admin.cms.gallery.photos.store', 'uses' => 'App\Controllers\Admin\cms\GalleryController@store_photo'));
            Route::get('gallery/{id}/photos/{pid}/edit', array('as' => 'admin.cms.gallery.photos.edit', 'uses' => 'App\Controllers\Admin\cms\GalleryController@edit_photo'));
            Route::post('gallery/{id}/photos/{pid}/update', array('as' => 'admin.cms.gallery.photos.update', 'uses' => 'App\Controllers\Admin\cms\GalleryController@update_photo'));
            Route::delete('gallery/{id}/photos/{pid}/destroy', array('as' => 'admin.cms.gallery.photos.destroy', 'uses' => 'App\Controllers\Admin\cms\GalleryController@destroy_photo'));
            Route::resource('cms/gallery', 'App\Controllers\Admin\cms\GalleryController');
            
              Route::get('tools/files-manager', array('as' => 'admin.tools.filesmanager', 'uses' => 'App\Controllers\Admin\ToolsController@filesmanager'));
            Route::get('tools/files-browser', array('as' => 'admin.tools.filesbrowser', 'uses' => 'App\Controllers\Admin\ToolsController@filesbrowser'));
            
            Route::get('users/{id}/reset', array('as' => 'admin.users.reset', 'uses' => 'App\Controllers\Admin\UsersController@reset'));
            Route::put('users/{id}/reset', array('as' => 'admin.users.reset', 'uses' => 'App\Controllers\Admin\UsersController@resetpwd'));
            Route::get('users/password', array('as' => 'admin.users.password', 'uses' => 'App\Controllers\Admin\UsersController@password'));
            Route::put('users/password', array('as' => 'admin.users.password', 'uses' => 'App\Controllers\Admin\UsersController@changepwd'));
            Route::resource('users', 'App\Controllers\Admin\UsersController');
            Route::resource('groups', 'App\Controllers\Admin\GroupsController');
            Route::resource('permissions', 'App\Controllers\Admin\PermissionsController');
            Route::resource('limousines', 'App\Controllers\Admin\LimousinesController');
            //Route::get('destinations/getAllDestinations',  array('as' => 'admin.destinations.getAllDestinations',  'uses' => 'App\Controllers\Admin\PricingController@getAllDestinations')); 
            Route::resource('destinations', 'App\Controllers\Admin\PricingController');

            Route::post('bookings/{id}', array('as' => 'admin.bookings.cancel', 'uses' => 'App\Controllers\Admin\BookingController@cancel'));
            Route::get('bookings/undo', array('as' => 'admin.bookings.undo', 'uses' => 'App\Controllers\Admin\BookingController@undo'));
            Route::resource('bookings', 'App\Controllers\Admin\BookingController');
            Route::resource('quotes', 'App\Controllers\Admin\QuoteController');

            Route::get('cart/settings', array('as' => 'admin.cart.settings.index', function() {
                    return View::make('admin.cart.settings.index');
                }));
                
            Route::get('cart/inventory/products/{id}/photos', array('as' => 'admin.cart.inventory.products.photos', 'uses' => 'App\Controllers\Admin\Cart\ProductsController@photos'));   
            Route::get('cart/inventory/products/{id}/photos/create', array('as' => 'admin.cart.inventory.products.photos.create', 'uses' => 'App\Controllers\Admin\Cart\ProductsController@createphoto'));
            Route::put('cart/inventory/products/{id}/photos/add', array('as' => 'admin.cart.inventory.products.photos.add', 'uses' => 'App\Controllers\Admin\Cart\ProductsController@addphoto'));
            Route::get('cart/inventory/products/{id}/photos/{phid}/edit', array('as' => 'admin.cart.inventory.products.photos.edit', 'uses' => 'App\Controllers\Admin\Cart\ProductsController@editphoto'));
            Route::put('cart/inventory/products/{id}/photos/{phid}/update', array('as' => 'admin.cart.inventory.products.photos.update', 'uses' => 'App\Controllers\Admin\Cart\ProductsController@updatephoto'));
            Route::post('cart/inventory/products/{id}/photos/{phid}/remove', array('as' => 'admin.cart.inventory.products.photos.remove', 'uses' => 'App\Controllers\Admin\Cart\ProductsController@deletephoto'));
            Route::post('cart/inventory/products/{id}/photos/{phid}/sortUp', array('as' => 'admin.cart.inventory.products.photos.sortUp', 'uses' => 'App\Controllers\Admin\Cart\ProductsController@sortUp'));
            Route::post('cart/inventory/products/{id}/photos/{phid}/sortDown', array('as' => 'admin.cart.inventory.products.photos.sortDown', 'uses' => 'App\Controllers\Admin\Cart\ProductsController@sortDown'));
            Route::resource('cart/inventory/products', 'App\Controllers\Admin\Cart\ProductsController');
                Route::resource('cart/inventory/units', 'App\Controllers\Admin\Cart\UnitsController');
            Route::resource('cart/inventory/category', 'App\Controllers\Admin\Cart\CategoryController');
            
            Route::post('cart/orders/{id}', array('as' => 'admin.cart.orders.ajax_action', 'uses' => 'App\Controllers\Admin\Cart\OrdersController@ajax_action'));
            Route::resource('cart/orders', 'App\Controllers\Admin\Cart\OrdersController');
            
        });




