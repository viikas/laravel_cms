<?php

namespace App\Controllers\Admin\cms;

use App\Models\Article;
use App\Models\Category;
use App\Services\Validators\ArticleValidator;
use Image,
    Input,
    Notification,
    Redirect,
    Sentry,
    Str;

class ArticlesController extends \BaseControllerNew {

    public function index() {
        $catsList = Category::lists('name', 'id');
        $cats = \Helper::SetDefaultSelect($catsList, '', 'All');
        $category=Input::query('category');
        if ($category!=null) {
            $articles = Article::where('category_id', $category)->get();
        }
        else {
            $articles = Article::all();
        }
        return \View::make('admin.cms.articles.index')->with('articles', $articles)->with('cats',$cats);
    }

    public function show($id) {
        return \View::make('admin.cms.articles.show')->with('article', Article::find($id));
    }

    public function create() {
        return \View::make('admin.cms.articles.create')->with('cats', Category::lists('name', 'id'));
    }

    public function store() {
        $validation = new ArticleValidator;

        if ($validation->passes()) {
            $article = new Article;
            $article->title = Input::get('title');
            $article->slug =Input::get('summary');
            $article->body = Input::get('body');
            $article->user_id = Sentry::getUser()->id;
            $article->category_id = Input::get('category');
            if (!Input::has('is_published'))
                $article->is_published = 0;
            else
                $article->is_published = 1;
            if (!Input::has('is_featured'))
                $article->is_featured = 0;
            else
                $article->is_featured = 1;
            $article->save();

            // Now that we have the article ID we need to move the image
            if (Input::hasFile('image')) {
                $article->image = Image::upload(Input::file('image'), 'articles/' . $article->id);
                $article->save();
            }

            Notification::success('The new article was created successfully!');

            return Redirect::route('admin.cms.articles.index');
        }

        return Redirect::back()->withInput()->withErrors($validation->errors);
    }

    public function edit($id) {
        return \View::make('admin.cms.articles.edit')->with('art', Article::find($id))->with('cats', Category::lists('name', 'id'));
    }

    public function update($id) {
        $validation = new ArticleValidator;

        if ($validation->passes()) {
            $article = Article::find($id);
            $article->title = Input::get('title');
            $article->slug = Input::get('summary');
            $article->body = Input::get('body');
            $article->category_id = Input::get('category');
            //dd(Input::has('is_published'));
            if (!Input::has('is_published'))
                $article->is_published = 0;
            else
                $article->is_published = 1;
            if (!Input::has('is_featured'))
                $article->is_featured = 0;
            else
                $article->is_featured = 1;
            if (Input::hasFile('image'))
                $article->image = Image::upload(Input::file('image'), 'articles/' . $article->id);
            $article->save();

            Notification::success('The article was saved successfully!');

            return Redirect::route('admin.cms.articles.index', $article->id);
        }

        return Redirect::back()->withInput()->withErrors($validation->errors);
    }

    public function destroy($id) {
        $article = Article::find($id);
        $article->delete();

        Notification::success('The article was deleted successfully!');

        return Redirect::route('admin.cms.articles.index');
    }

}

