@extends('admin._layouts.default')

@section('main')
@include('admin._partials.cms')
<h2>Edit article</h2>

@include('admin._partials.notifications')

{{ Form::model($art, array('method' => 'put', 'route' => array('admin.cms.articles.update', $art->id), 'files' => true)) }}

<div class="float-left">
    <div class="control-group">
        {{ Form::label('title', 'Title') }}
        <div class="controls">
            {{ Form::text('title',$art->title) }}
        </div>
    </div>

    <div class="control-group">
        {{ Form::label('summary', 'Summary') }}
        <div class="controls">
            {{ Form::textarea('summary',$art->slug) }}
        </div>
    </div>

    
</div>
<div class="float-left margin-left-60">    
    <div class="control-group">
        {{ Form::label('is_available', 'Published') }}
        <div class="controls">
            {{ Form::checkbox('is_published',$art->is_published,$art->is_published) }}
        </div>
    </div>
    <div class="control-group">
        {{ Form::label('is_featured', 'Featured') }}
        <div class="controls">
            {{ Form::checkbox('is_featured',$art->is_featured,$art->is_featured) }}
        </div>
    </div>

    <div class="control-group">
        {{ Form::label('category', 'Category') }}
        <div class="controls">
            {{Form::select('category',$cats,$art->category_id)}}
        </div>
    </div>
    <div class="control-group">
        {{ Form::label('image', 'Image') }}

        <div class="fileupload fileupload-new" data-provides="fileupload">
            <div class="fileupload-preview thumbnail" style="width: 200px; height: 150px;">
                @if ($art->image)
                <a href="<?php echo $art->image; ?>"><img src="<?php echo Image::resize($art->image, 200, 150); ?>" alt=""></a>
                @else
                <img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image">
                @endif
            </div>
            <div>
                <span class="btn btn-file"><span class="fileupload-new">Select image</span><span class="fileupload-exists">Change</span>{{ Form::file('image') }}</span>
                <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
            </div>
        </div>
    </div>
</div>
<div class="clear"></div>
<div class="control-group">
        {{ Form::label('body', 'Content') }}
        <div class="controls">
            {{ Form::textarea('body',$art->body) }}
        </div>
    </div>


<div class="form-actions">
    {{ Form::submit('Save', array('class' => 'btn btn-success btn-save btn-large')) }}
    <a href="{{ URL::route('admin.cms.articles.index') }}" class="btn btn-large">Cancel</a>
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
</script>
@stop
