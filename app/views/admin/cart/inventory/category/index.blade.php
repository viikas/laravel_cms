@extends('admin._layouts.default')

@section('main')
@include('admin._partials.cart')
<h1>
    Product Categories <a href="{{ URL::route('admin.cart.inventory.category.create') }}" class="btn btn-success"><i class="icon-plus-sign"></i> Add New</a>
</h1>
{{ Notification::showAll() }}

<table class="table table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th>Photo</th>
            <th>Name</th>
            <th>Total Products</th>
            <th>Published</th>
            <th><i class="icon-cog"></i></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($collection as $item)
        <tr>
            <td>{{ $item->id }}</td>
            <td>
                @if ($item->photo)
                    <img src="{{ Image::resize($item->photo, 100, 75) }}" alt="">
                @else
                    <img src="http://www.placehold.it/100x75/EFEFEF/AAAAAA&amp;text=no+photo">
                @endif
            </td>
            <td>
                <a href="{{ URL::route('admin.cart.inventory.category.show', $item->id) }}">{{ $item->name }}</a><br/>
                [<a target="_blank" href="{{ URL::route('site.categoryproducts', $item->slug) }}">{{ URL::route('site.categoryproducts', $item->slug) }}</a>]
            </td>
            <td>{{$item->products()->count()}}</td>
            <td><span class="product-available product-available-{{$item->is_available}}" title="{{$item->is_available==0 ? 'not published' : 'published'}}">&nbsp;</span></td>
            <td>
                <a href="{{ URL::route('admin.cart.inventory.category.edit', $item->id) }}" class="btn btn-success btn-mini pull-left">edit</a>
                {{ Form::open(array('route' => array('admin.cart.inventory.category.destroy', $item->id), 'method' => 'delete', 'data-confirm' => 'Are you sure?')) }}

                <button type="submit" class="btn btn-danger btn-mini">Delete</butfon>
                    {{ Form::close() }}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@stop
