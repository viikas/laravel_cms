@extends('admin._layouts.default')

@section('main')
@include('admin._partials.cart')
<h2>Edit product</h2>

@include('admin._partials.notifications')

{{ Form::model($item,array('method'=>'put','route' => array('admin.cart.inventory.products.update',$item->id))) }}
<div class="float-left">
    <div class="control-group">
        {{ Form::label('name', 'Product Name') }}
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
        {{ Form::label('old_price', 'Old Price') }}
        <div class="controls">
            {{Form::text('old_price',$item->old_price)}}
        </div>
    </div>
    <div class="control-group">
        {{ Form::label('new_price', 'New Price') }}
        <div class="controls">
            {{Form::text('new_price',$item->new_price)}}
        </div>
    </div>
    
    <div class="control-group">
        {{ Form::label('new_price', 'Product Unit') }}
        <div class="controls">
            {{Form::select('unit_id',$units,$item->unit_id)}}
        </div>
    </div>

    <div class="control-group">
        {{ Form::label('is_available', 'Published') }}
        <div class="controls">
            {{ Form::checkbox('is_available',$item->is_available,$item->is_available) }}
            
        </div>
    </div>

    <div class="control-group">
        {{ Form::label('cats-lbl', 'Categories') }}
        <div class="controls">
            @foreach($cats as $p)
            <div>{{ Form::checkbox('cats[]',$p->id,in_array($p->id,$cats_bag),array('class'=>'display-inline','id'=>'chk'.$p->id)) }}&nbsp;{{Form::label('chk'.$p->id,$p->name,array('class'=>'display-inline margin-right-20 margin-top-4'))}}</div>
            @endforeach
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
