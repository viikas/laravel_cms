@extends('admin._layouts.default')

@section('main')
@include('admin._partials.cms')
<h2>Add photo in gallery <i>{{$gal->name}}</i></h2>

@include('admin._partials.notifications')

{{ Form::open(array('route' => array('admin.cms.gallery.photos.store',$gal->id), 'files' => true)) }}
    

<div class="control-group">
    {{ Form::label('image', 'Image') }}

    <div class="fileupload fileupload-new" data-provides="fileupload">
        <div class="fileupload-preview thumbnail" style="width: 200px; height: 150px;">
            <img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image">
        </div>
        <div>
            <span class="btn btn-file"><span class="fileupload-new">Select image</span><span class="fileupload-exists">Change</span>{{ Form::file('image') }}</span>
            <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
        </div>
    </div>
</div>
<div class="control-group">
        {{ Form::label('caption', 'Caption') }}
        <div class="controls">
            {{ Form::textarea('caption') }}
        </div>
    </div>
<div class="form-actions">
    {{ Form::submit('Save', array('class' => 'btn btn-success btn-save btn-large')) }}
    <a href="{{ URL::route('admin.cms.gallery.photos',$gal->id) }}" class="btn btn-large">Cancel</a>
</div>

{{ Form::close() }}
@stop
