<?php

namespace App\Controllers\Site;
use App\Services\Validators\CMSContactValidator;
use App\Models\Article;
use App\Models\Category;
use App\Models\Contacts;
use App\Models\Gallery;
use App\Models\Page;
use App\Models\Photos;
use Image,
    Input,
    Notification,
    Redirect,
    Str,
    URL;

class PublicController extends \BaseController {

    public function index() {
        $page = Page::where('code', 'welcome')->first();
        $data = \CMSHelper::SideColumnData();
        return \View::make('site::index', $data)->with('page', $page);
    }

    public function page($code) {
        $data = \CMSHelper::SideColumnData();
        return \View::make('site::page', $data)->with('page', Page::where('code', $code)->first());
    }

    public function categories($code) {
        $data = \CMSHelper::SideColumnData();
        $cat = Category::where('code', $code)->first();
        if(!is_null($cat))
        return \View::make('site::categories', $data)->with('cat', $cat)->with('items', Article::where('category_id', $cat->id)->where('is_published', '1')->get());
        else
            return \View::make('site::categories', $data)->with('cat', $cat);
    }

    public function category($id) {
        $data = \CMSHelper::SideColumnData();
        return \View::make('site::category', $data)->with('item', Article::find($id));
    }

    public function contact() {
        $data = \CMSHelper::SideColumnData();
        $page = Page::where('code', 'contact-us')->first();
        return \View::make('site::contact', $data)->with('page', $page);
    }

    public function gallery() {
        $data = \CMSHelper::SideColumnData();
        return \View::make('site::gallery', $data)->with('items', Gallery::where('is_published', '1')->get());
    }

    public function album($id) {
        $data = \CMSHelper::SideColumnData();
        $gal = Gallery::where('id', $id)->where('is_published', '1')->first();
        if(!is_null($gal))
        return \View::make('site::album', $data)->with('gal',$gal)->with('items', Photos::where('gallery_id', $id)->get());
        else
            return \View::make('site::album', $data)->with('gal', null);
    }
    
    public function contact_save()
    {
        $validation = new CMSContactValidator;
        if ($validation->passes()) {
            try {
                $con=new Contacts;
                $con->name = Input::get('name');
                $con->email = Input::get('email');
                $con->message = Input::get('message');
                $con->website = Input::get('website',null);
                $con->save();
                Notification::success('We have successfully received your message.Thank you!');
                return Redirect::route('site.contact');
            } catch (\Exception $e) {
                Notification::error('OOps.. some error occurred. Your message could not be received. Please try again later. ERROR:'.$e->getMessage());
            }
            
        }
        return Redirect::back()->withInput()->withErrors($validation->errors);
    }

}

