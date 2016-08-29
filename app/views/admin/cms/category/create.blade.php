@extends('admin._layouts.default')

@section('main')
@include('admin._partials.cms')
<h2>Create new category</h2>

@include('admin._partials.notifications')

{{ Form::open(array('route' => 'admin.cms.category.store','method'=>'post')) }}

<div class="control-group">
    {{ Form::label('code', 'Category Code') }}
    <div class="controls">
        {{ Form::text('code') }}
    </div>
</div>

<div class="control-group">
    {{ Form::label('name', 'Category Name') }}
    <div class="controls">
        {{ Form::text('name') }}
    </div>
</div>

<div class="form-actions">
    {{ Form::submit('Save', array('class' => 'btn btn-success btn-save btn-large')) }}
    <a href="{{ URL::route('admin.cms.category.index') }}" class="btn btn-large">Cancel</a>
</div>

{{ Form::close() }}
<script src="{{ URL::asset('assets/ckeditor/ckeditor.js') }}"></script>
<script>
    CKEDITOR.replace( 'body',
    {
        filebrowserBrowseUrl :'{{URL::route("admin.tools.filesbrowser","type=files")}}',
        filebrowserImageBrowseUrl : '/karma_cms/public/admin/files-browse?type=images',
        filebrowserFlashBrowseUrl : '/karma_cms/public/admin/files-browse?type=flash'
    });
</script>
@stop
