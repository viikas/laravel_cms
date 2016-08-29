@extends('admin._layouts.default')

@section('main')
@include('admin._partials.cms')
<h2>Edit page</h2>

@include('admin._partials.notifications')

{{ Form::model($page, array('method' => 'put', 'route' => array('admin.cms.pages.update', $page->id))) }}
<div class="control-group">
    {{ Form::label('code', 'Code [for admin\'s purpose]') }}
    <div class="controls">
        {{ Form::text('code',$page->code) }}
    </div>
</div>
<div class="control-group">
    {{ Form::label('title', 'Title') }}
    <div class="controls">
        {{ Form::text('title',$page->title) }}
    </div>
</div>

<div class="control-group">
    {{ Form::label('summary', 'Summary') }}
    <div class="controls">
        {{ Form::textarea('summary') }}
    </div>
</div>

<div class="control-group">
    {{ Form::label('body', 'Content') }}
    <div class="controls">
        {{ Form::textarea('body',$page->body) }}
    </div>
</div>

<div class="form-actions">
    {{ Form::submit('Save', array('class' => 'btn btn-success btn-save btn-large')) }}
    <a href="{{ URL::route('admin.cms.pages.index') }}" class="btn btn-large">Cancel</a>
</div>

{{ Form::close() }}
<script src="{{ URL::asset('assets/ckeditor/ckeditor.js') }}"></script>
<script>
CKEDITOR.replace( 'body',
    {
        filebrowserBrowseUrl :'{{URL::route("admin.tools.filesbrowser","type=files")}}',
        filebrowserImageBrowseUrl : '{{URL::route("admin.tools.filesbrowser","type=images")}}',
        filebrowserFlashBrowseUrl : '{{URL::route("admin.tools.filesbrowser","type=flash")}}'
    });
    
     CKEDITOR.replace( 'summary',
    {
        filebrowserBrowseUrl :'{{URL::route("admin.tools.filesbrowser","type=files")}}',
        filebrowserImageBrowseUrl : '{{URL::route("admin.tools.filesbrowser","type=images")}}',
        filebrowserFlashBrowseUrl : '{{URL::route("admin.tools.filesbrowser","type=flash")}}'
    });
    </script>
@stop
