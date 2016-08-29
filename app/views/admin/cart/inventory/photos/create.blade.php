@extends('admin._layouts.default')

@section('main')
@include('admin._partials.cart')
<h2>Add Photo : {{$item->name}}</h2>

@include('admin._partials.notifications')
{{ Form::open(array('method'=>'put','files'=>'true','route' => array('admin.cart.inventory.products.photos.add',$item->id))) }}
<div class="control-group">
    {{Form::label('photo_image','Photo')}}
    <div class="fileupload fileupload-new" data-provides="fileupload">
        <div class="fileupload-preview thumbnail" style="width: 200px; height: 150px;">
            <img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+photo">
        </div>
        <div>
            <span class="btn btn-file"><span class="fileupload-new">Select photo</span><span class="fileupload-exists">Change</span>{{ Form::file('photo_image') }}</span>
            <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
        </div>
    </div>
</div>
<div class="control-group">
    {{Form::label('caption','Photo caption')}}
    {{Form::textarea('caption','',array('style'=>'height:150px'))}}
</div>


<div class="form-actions">
    {{ Form::submit('Save Photo', array('class' => 'btn btn-success btn-save btn-large')) }}
    <a href="{{ URL::route('admin.cart.inventory.products.photos',$item->id) }}" class="btn btn-large">Cancel</a>
</div>

{{ Form::close() }}

@stop

