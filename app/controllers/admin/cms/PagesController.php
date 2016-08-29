<?php namespace App\Controllers\Admin\cms;

use App\Models\Page;
use App\Services\Validators\PageValidator;
use Input, Notification, Redirect, Sentry, Str;

class PagesController extends \BaseController {

	public function index()
	{
		return \View::make('admin.cms.pages.index')->with('pages', Page::all());
	}

	public function show($id)
	{
		return \View::make('admin.cms.pages.show')->with('page', Page::find($id));
	}

	public function create()
	{
		return \View::make('admin.cms.pages.create');
	}

	public function store()
	{
		$validation = new PageValidator;

		if ($validation->passes())
		{
			$page = new Page;
                        $page->code   = Input::get('code');
			$page->title   = Input::get('title');
			$page->summary    = Input::get('summary');
			$page->body    = Input::get('body');
			$page->user_id = Sentry::getUser()->id;
			$page->save();

			Notification::success('New page was created successfully!');

			return Redirect::route('admin.cms.pages.index');
		}

		return Redirect::back()->withInput()->withErrors($validation->errors);
	}

	public function edit($id)
	{
		return \View::make('admin.cms.pages.edit')->with('page', Page::find($id));
	}

	public function update($id)
	{
		$validation = new PageValidator;

		if ($validation->passes())
		{
			$page = Page::find($id);
                        $page->code   = Input::get('code');
			$page->title   = Input::get('title');
			$page->summary    = Input::get('summary');
			$page->body    = Input::get('body');
			$page->user_id = Sentry::getUser()->id;
			$page->save();

			Notification::success('The page was saved successfully!');

			return Redirect::route('admin.cms.pages.index', $page->id);
		}

		return Redirect::back()->withInput()->withErrors($validation->errors);
	}

	public function destroy($id)
	{
		$page = Page::find($id);
		$page->delete();

		Notification::success('The page was deleted successfully!');

		return Redirect::route('admin.cms.pages.index');
	}

}
