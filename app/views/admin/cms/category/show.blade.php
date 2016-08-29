@extends('admin._layouts.default')

@section('main')
@include('admin._partials.cms')
	<h2>Page Details <a href="{{ URL::route('admin.cms.pages.index') }}" class="btn btn-success"><i class="icon-plus-sign"></i> Back to all pages</a></h2>

	<hr>

	<h3>{{ $page->title }}</h3>
	<h5>{{ $page->created_at }}</h5>
	{{ $page->body }}
        
        
@stop