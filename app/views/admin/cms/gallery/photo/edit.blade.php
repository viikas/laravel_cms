@extends('admin._layouts.default')

@section('main')
@include('admin._partials.cms')
<h2>Edit photo of gallery <i>{{$gal->name}}</i></h2>

@include('admin._partials.notifications')

{{ Form::model($photo, array('method' => 'post', 'route' => array('admin.cms.gallery.photos.update',$gal->id, $photo->id), 'files' => true)) }}

<div class="control-group">
    {{ Form::label('image', 'Image') }}

    <div class="fileupload fileupload-new" data-provides="fileupload">
        <div class="fileupload-preview thumbnail" style="width: 200px; height: 150px;">
            @if ($photo->image)
            <a href="<?php echo $gal->image; ?>"><img src="<?php echo Image::resize($photo->image, 200, 150); ?>" alt=""></a>
            @else
            <img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image">
            @endif
        </div>
        <div>
            <span class="btn btn-file"><span class="fileupload-new">Select image</span><span class="fileupload-exists">Change</span>{{ Form::file('image') }}</span>
            <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
        </div>
    </div>
    <div class="control-group">
    {{ Form::label('caption', 'Caption') }}
    <div class="controls">
        {{ Form::textarea('caption',$photo->caption) }}
    </div>
</div>
</div>
<div class="form-actions">
    {{ Form::submit('Save', array('class' => 'btn btn-success btn-save btn-large')) }}
    <a href="{{ URL::route('admin.cms.gallery.index') }}" class="btn btn-large">Cancel</a>
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
