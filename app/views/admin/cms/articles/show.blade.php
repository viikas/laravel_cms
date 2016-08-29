@extends('admin._layouts.default')

@section('main')
@include('admin._partials.cms')
	<h2>Article Details <a href="{{ URL::route('admin.cms.articles.index') }}" class="btn btn-success"><i class="icon-plus-sign"></i> Back to all articles</a></h2>

	<hr>

	<h3>{{ $article->title }}</h3>
	<h5>{{ $article->created_at }}</h5>
        <div>{{$article->slug}}</div>
        {{ $article->body }}

	@if ($article->image)
		<hr>
		<figure><img src="{{ Image::resize($article->image, 800, 600) }}" alt=""></figure>
	@endif
@stop
