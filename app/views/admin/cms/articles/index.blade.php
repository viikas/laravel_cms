@extends('admin._layouts.default')

@section('main')
@include('admin._partials.cms')
<h1>
    Articles <a href="{{ URL::route('admin.cms.articles.create') }}" class="btn btn-success"><i class="icon-plus-sign"></i> Add new article</a>
</h1>

<hr>

{{ Notification::showAll() }}
<div>
    {{ Form::open(array('route' => array('admin.cms.articles.index'), 'method' => 'get')) }}
    {{Form::select('category',$cats,Input::get('category'),array('onchange'=>'this.form.submit();'))}}
        {{ Form::close() }}            
</div>
<table class="table table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th>Photo</th>
            <th>Title</th>
            <th>Category</th>
            <th>When</th>
            <th>Published</th>
            <th>Featured</th>
            <th><i class="icon-cog"></i></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($articles as $article)
        <tr>
            <td>{{ $article->id }}</td>
            <td>
                <div class="fileupload fileupload-new" data-provides="fileupload">
                    <div class="fileupload-preview thumbnail" style="width: 100px; height: 75px;">
                        @if ($article->image)
                        <a href="<?php echo $article->image; ?>"><img src="<?php echo Image::resize($article->image, 100, 75); ?>" alt=""></a>
                        @else
                        <img src="http://www.placehold.it/100x75/EFEFEF/AAAAAA&amp;text=no+image">
                        @endif
                    </div>
                </div>
            </td>
            <td><a href="{{ URL::route('admin.cms.articles.show', $article->id) }}">{{ $article->title }}</a></td>
            <td>{{$article->category->name}}</td>
            <td>{{ $article->created_at }}</td>
            <td>
                <span class="product-available product-available-{{$article->is_published}}" title="{{$article->is_published==0 ? 'not published' : 'published'}}">&nbsp;</span>
            </td>
            <td>
                <span class="product-available product-available-{{$article->is_featured}}" title="{{$article->is_featured==0 ? 'not featured' : 'featured'}}">&nbsp;</span>
            </td>
            <td>
                <a href="{{ URL::route('admin.cms.articles.edit', $article->id) }}" class="btn btn-success btn-mini pull-left">Edit</a>

                {{ Form::open(array('route' => array('admin.cms.articles.destroy', $article->id), 'method' => 'delete', 'data-confirm' => 'Are you sure?')) }}
                <button type="submit" class="btn btn-danger btn-mini">Delete</butfon>
                    {{ Form::close() }}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@stop
