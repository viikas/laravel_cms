@extends('admin._layouts.default')

@section('main')
@include('admin._partials.cart')
<h2>Edit product category</h2>

@include('admin._partials.notifications')

{{ Form::model($item, array('method' => 'put','files'=>true, 'route' => array('admin.cart.inventory.category.update', $item->id))) }}

<div class="float-left">
<div class="control-group">
    {{ Form::label('name', 'Category Name') }}
    <div class="controls">
        {{ Form::text('name',$item->name) }}
    </div>
</div>
<div class="control-group">
    {{ Form::label('summary', 'Summary') }}
    <div class="controls">
        {{ Form::textarea('summary',$item->summary) }}
    </div>
</div>
<div class="control-group">
    {{ Form::label('details', 'Details') }}
    <div class="controls">
        {{ Form::textarea('details',$item->details) }}
    </div>
</div>
    </div>
<div class="float-left margin-left-60">
<div class="control-group">
    {{ Form::label('parent_id', 'Parent Category') }}
    <div class="controls">
        {{Form::select('parent_id',$cats,$item->parent_id)}}
    </div>
</div>

<div class="control-group">
    {{ Form::label('is_available', 'Published') }}
    <div class="controls">
        {{ Form::checkbox('is_available',$item->is_available,$item->is_available) }}
    </div>
</div>


<div class="control-group">
    {{ Form::label('photo', 'Photo') }}

    <div class="fileupload fileupload-new" data-provides="fileupload">
        <div class="fileupload-preview thumbnail" style="width: 200px; height: 150px;">
            @if($item->photo))
            <a href="{{$item->photo;}}"><img src="{{Image::resize($item->photo, 200, 150); }}" alt=""></a>            
            @else
            <img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+photo">
            @endif
        </div>
        <div>
            <span class="btn btn-file"><span class="fileupload-new">Select photo</span><span class="fileupload-exists">Change</span>{{ Form::file('photo') }}</span>
            <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
        </div>
    </div>
</div>
</div>
<div class="clear"></div>

<div class="form-actions">
    {{ Form::submit('Save', array('class' => 'btn btn-success btn-save btn-large')) }}
    <a href="{{ URL::route('admin.cart.inventory.category.index') }}" class="btn btn-large">Cancel</a>
</div>

{{ Form::close() }}

@stop
