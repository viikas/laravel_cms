<?php

namespace App\Controllers\Admin\cms;

use App\Models\Gallery;
use App\Models\Photos;
use App\Services\Validators\GalleryValidator;
use App\Services\Validators\CMSPhotoValidator;
use Input,
    Notification,
    Redirect,
    Sentry,
    Str,
    Image;

class GalleryController extends \BaseController {

    public function index() {
        return \View::make('admin.cms.gallery.index')->with('gallery', Gallery::all());
    }

    public function create() {
        return \View::make('admin.cms.gallery.create');
    }

    public function store() {
        $validation = new GalleryValidator;

        if ($validation->passes()) {
            $g = new Gallery;
            $g->name = Input::get('name');
            if (!Input::has('is_published'))
                $g->is_published = 0;
            else
                $g->is_published = 1;

            $g->save();

            if (Input::hasFile('image')) {
                $g->image = Image::upload(Input::file('image'), 'gallery/' . $g->id);
                $g->save();
            }

            Notification::success('New photo gallery was created successfully!');

            return Redirect::route('admin.cms.gallery.index');
        }

        return Redirect::back()->withInput()->withErrors($validation->errors);
    }

    public function edit($id) {
        return \View::make('admin.cms.gallery.edit')->with('gal', Gallery::find($id));
    }

    public function destroy($id) {
        $g = Gallery::find($id);
        if($g->photos()->count()>0)
        {
            Notification::error('This gallery contains photos. Please delete them first.');
        }
        else
        {
        $g->delete();
        Notification::success('Selected photo gallery was deleted successfully!');
        }
        return Redirect::route('admin.cms.gallery.index');
    }

    public function update($id) {
        $validation = new GalleryValidator;

        if ($validation->passes()) {
            $g = Gallery::find($id);
            $g->name = Input::get('name');
            if (!Input::has('is_published'))
                $g->is_published = 0;
            else
                $g->is_published = 1;
            if (Input::hasFile('image'))
                $g->image = Image::upload(Input::file('image'), 'gallery/' . $g->id);
            $g->save();

            Notification::success('The photo gallery was saved successfully!');

            return Redirect::route('admin.cms.gallery.index');
        }

        return Redirect::back()->withInput()->withErrors($validation->errors);
    }

    public function photos($id) {
        $gal = Gallery::find($id);
        return \View::make('admin.cms.gallery.photos')->with('gal', $gal);
    }

    public function create_photo($id) {
        return \View::make('admin.cms.gallery.photo.create')->with('gal', Gallery::find($id));
    }

    public function store_photo($id) {
        $validation = new CMSPhotoValidator;

        if ($validation->passes()) {
            $g = new Photos;
            $g->gallery_id = $id;
            $g->caption = Input::get('caption');
             $g->image = Image::upload(Input::file('image'), 'gallery/photos/' . $g->id);
            $g->save();

            Notification::success('New photo was added successfully!');

            return Redirect::route('admin.cms.gallery.photos',$id);
        }

        return Redirect::back()->withInput()->withErrors($validation->errors);
    }

    public function edit_photo($id,$pid) {
        return \View::make('admin.cms.gallery.photo.edit')->with('gal', Gallery::find($id))->with('photo',Photos::find($pid));
    }

    public function update_photo($id,$pid) {

        $p = Photos::where('gallery_id',$id)->where('id',$pid)->first();
            $p->caption= Input::get('caption');
            $p->save();

            Notification::success('The photo was saved successfully!');

            return Redirect::route('admin.cms.gallery.photos',$id);
    }

    public function destroy_photo($id,$pid) {
        $p = Photos::where('gallery_id',$id)->where('id',$pid)->first();
        if(!is_null($p))
        {
            $p->delete();
            Notification::success('The photo was deleted successfully!');
        }
        else
            Notification::error('The photo does not exist or has already been deleted.');
        return Redirect::route('admin.cms.gallery.photos',$id);
    }

}
