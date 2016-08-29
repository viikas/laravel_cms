@extends('admin._layouts.default')

@section('main')
@include('admin._partials.cart')
<h1>
    Products <a href="{{ URL::route('admin.cart.inventory.products.create') }}" class="btn btn-success"><i class="icon-plus-sign"></i> Add New</a>
</h1>
{{ Notification::showAll() }}

<table class="table table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Price</th>
            <th>Unit</th>
            <th>Categories</th>
            <th>Published</th>
            <th><i class="icon-cog"></i></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($collection as $item)
        <tr>
            <td>{{ $item->id }}</td>
            <td>
                <a href="{{ URL::route('admin.cart.inventory.products.show', $item->id) }}">{{$item->name}}</a></a>
                <div>
                    (<a href="{{ URL::route('admin.cart.inventory.products.photos', $item->id) }}">{{$item->photos()->count()}} photos</a>)
                </div>
            </td>
            <td><span class="product-new-price">{{ $item->new_price}}</span><span class="product-old-price">{{ $item->old_price}}</span></td>
            <td>{{$item->unit->display_name}}</td>
            <td>
                @foreach ($item->category as $cat)
                <span class="product-category-name">
                    <span class="product-category-name-teaser">&nbsp;</span> {{$cats[$cat->id]}}
                </span>
                @endforeach
            </td>
            <td>
                <span class="product-available product-available-{{$item->is_available}}" title="{{$item->is_available==0 ? 'not published' : 'published'}}">&nbsp;</span>
            </td>
            <td>
                <a href="{{ URL::route('admin.cart.inventory.products.edit', $item->id) }}" class="btn btn-success btn-mini pull-left">edit</a>
                {{ Form::open(array('route' => array('admin.cart.inventory.products.destroy', $item->id), 'method' => 'delete', 'data-confirm' => 'Are you sure?')) }}

                <button type="submit" class="btn btn-danger btn-mini">Delete</butfon>
                    {{ Form::close() }}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@stop
