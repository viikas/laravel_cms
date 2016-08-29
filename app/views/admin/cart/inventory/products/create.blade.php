@extends('admin._layouts.default')

@section('main')
@include('admin._partials.cart')
<h2>Add new product</h2>

@include('admin._partials.notifications')

{{ Form::open(array('route' => 'admin.cart.inventory.products.store')) }}
<div class="float-left">
    <div class="control-group">
        {{ Form::label('name', 'Product Name') }}
        <div class="controls">
            {{ Form::text('name') }}
        </div>
    </div>
    <div class="control-group">
        {{ Form::label('summary', 'Summary') }}
        <div class="controls">
            {{ Form::textarea('summary') }}
        </div>
    </div>
    <div class="control-group">
        {{ Form::label('details', 'Details') }}
        <div class="controls">
            {{ Form::textarea('details') }}
        </div>
    </div>
</div>
<div class="float-left margin-left-60">
    <div class="control-group">
        {{ Form::label('old_price', 'Old Price') }}
        <div class="controls">
            {{Form::text('old_price',0)}}
        </div>
    </div>
    <div class="control-group">
        {{ Form::label('new_price', 'New Price') }}
        <div class="controls">
            {{Form::text('new_price')}}
        </div>
    </div>
    
    <div class="control-group">
        {{ Form::label('new_price', 'Product Unit') }}
        <div class="controls">
            {{Form::select('unit_id',$units,'-1')}}
        </div>
    </div>

    <div class="control-group">
        {{ Form::label('is_available', 'Published') }}
        <div class="controls">
            {{ Form::checkbox('is_available') }}
        </div>
    </div>
    <div class="control-group">
        {{ Form::label('is_featured', 'Featured') }}
        <div class="controls">
            {{ Form::checkbox('is_featured') }}
        </div>
    </div>

    <div class="control-group">
        {{ Form::label('category_id', 'Category') }}
        <div class="controls">
            {{Form::select('category_id',$cats,'-1')}}
        </div>
    </div>
</div>
<div class="clear"></div>

<div class="form-actions">
    {{ Form::submit('Save', array('class' => 'btn btn-success btn-save btn-large')) }}
    <a href="{{ URL::route('admin.cart.inventory.products.index') }}" class="btn btn-large">Cancel</a>
</div>

{{ Form::close() }}

@stop
