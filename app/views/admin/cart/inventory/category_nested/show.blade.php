@extends('admin._layouts.default')

@section('main')
@include('admin._partials.cart')
<h2>Product category details</h2>

@include('admin._partials.notifications')

{{ Form::model($item, array('method' => 'get','files'=>true, 'route' => array('admin.cart.inventory.category.edit', $item->id))) }}

<div class="float-left">
    <div class="control-group border-bottom-5px">
        <div class="float-left margin-right-60 display-title width-60">
            Category:
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
            Parent Category:
        </div>
        <div class="float-left">
            @if($item->parent_id>0)
            {{$item->parent->name}}
            @else
            <i>None</i>
            @endif
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
            <div class="fileupload-preview thumbnail" style="width: 200px; height: 150px;">
                @if($item->photo)
                <a href="{{$item->photo;}}"><img src="{{Image::resize($item->photo, 200, 150); }}" alt=""></a>            
                @else
                <img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+photo">
                @endif
            </div>
        </div>
        <div class="clear"></div>
    </div
</div>

</div>
<div class="clear"></div>
<div class="form-actions">
    {{ Form::submit('Edit', array('class' => 'btn btn-success btn-save btn-large')) }}
    <a href="{{ URL::route('admin.cart.inventory.category.index') }}" class="btn btn-large">Go Back</a>
</div>

{{ Form::close() }}

@stop
