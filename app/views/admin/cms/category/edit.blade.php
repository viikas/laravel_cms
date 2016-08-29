@extends('admin._layouts.default')

@section('main')
@include('admin._partials.cms')
	<h2>Edit category</h2>

	@include('admin._partials.notifications')

	{{ Form::model($category, array('method' => 'put', 'route' => array('admin.cms.category.update', $category->id))) }}

		<div class="control-group">
    {{ Form::label('code', 'Category Code') }}
    <div class="controls">
        {{ Form::text('code',$category->code) }}
    </div>
</div>

<div class="control-group">
    {{ Form::label('name', 'Category Name') }}
    <div class="controls">
        {{ Form::text('name',$category->name) }}
    </div>
</div>

		<div class="form-actions">
			{{ Form::submit('Save', array('class' => 'btn btn-success btn-save btn-large')) }}
			<a href="{{ URL::route('admin.cms.category.index') }}" class="btn btn-large">Cancel</a>
		</div>

	{{ Form::close() }}
<script src="{{ URL::asset('assets/ckeditor/ckeditor.js') }}"></script>
<script>CKEDITOR.replace('body');</script>
@stop
