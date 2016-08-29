@extends('admin._layouts.default')

@section('main')
@include('admin._partials.cart')
<h2>Product category details</h2>

@include('admin._partials.notifications')

{{ Form::model($item, array('method' => 'get','files'=>true, 'route' => array('admin.cart.inventory.products.edit', $item->id))) }}

<div class="float-left">
    <div class="control-group border-bottom-5px">
        <div class="float-left margin-right-60 display-title width-60">
            Product name:
        </div>
        <div class="float-left">
            {{$item->name}}
        </div>
        <div class="clear"></div>
    </div>
    <div class="control-group border-bottom-5px">
        <div class="float-left margin-right-60 display-title width-60">
            Summary:
        </div>
        <div class="float-left">
            {{$item->summary}}
        </div>
        <div class="clear"></div>
    </div>
    <div class="control-group">
        <div class="float-left margin-right-60 display-title width-60">
            Details:
        </div>
        <div class="float-left">
            {{$item->details}}
        </div>
        <div class="clear"></div>
    </div>
</div>
<div class="float-left margin-left-60">
    <div class="control-group border-bottom-5px">
        <div class="float-left margin-right-60 display-title width-120">
            Public URL:
        </div>
        <div class="float-left">
            <a target="_blank" href="{{ URL::route('site.product', $item->slug) }}">{{ URL::route('site.product', $item->slug) }}</a>

        </div>
        <div class="clear"></div>
    </div>
    <div class="control-group border-bottom-5px">
        <div class="float-left margin-right-60 display-title width-120">
            New Price:
        </div>
        <div class="float-left" style="color:green;">
            ${{$item->new_price}}
        </div>
        <div class="clear"></div>
    </div>
    <div class="control-group border-bottom-5px">
        <div class="float-left margin-right-60 display-title width-120">
            Old Price:
        </div>
        <div class="float-left" style="color:Red;">
            ${{$item->old_price}}
        </div>
        <div class="clear"></div>
    </div>
    <div class="control-group border-bottom-5px">
        <div class="float-left margin-right-60 display-title width-120">
            Category:
        </div>
        <div class="float-left">
            {{$item->category->name}}
        </div>
        <div class="clear"></div>
    </div>
    <div class="control-group border-bottom-5px">
        <div class="float-left margin-right-60 display-title width-120">
            Unit:
        </div>
        <div class="float-left">
            {{$item->unit->display_name}}
        </div>
        <div class="clear"></div>
    </div>
    <div class="control-group border-bottom-5px">
        <div class="float-left margin-right-60 display-title width-120">
            Published:
        </div>
        <div class="float-left">
            <span class="product-available product-available-{{$item->is_available}}" title="{{$item->is_available==0 ? 'not published' : 'published'}}">&nbsp;</span>
        </div>
        <div class="clear"></div>
    </div>
    <div class="control-group">
        <div class="float-left margin-right-60 display-title width-120">
            Photo:
        </div>
        <div class="float-left">
            <a href="{{URL::route('admin.cart.inventory.products.photos',$item->id)}}">{{$item->photos()->count().' photos'}}</a>
        </div>
        <div class="clear"></div>
    </div
</div>

</div>
<div class="clear"></div>
<div class="form-actions">
    {{ Form::submit('Edit', array('class' => 'btn btn-success btn-save btn-large')) }}
    <a href="{{ URL::route('admin.cart.inventory.products.index') }}" class="btn btn-large">Go Back</a>
</div>

{{ Form::close() }}

@stop
