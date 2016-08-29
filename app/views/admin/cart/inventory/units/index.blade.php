@extends('admin._layouts.default')

@section('main')

<h1>
    Settings - Units <a href="{{ URL::route('admin.cart.inventory.units.create') }}" class="btn btn-success"><i class="icon-plus-sign"></i> Add New</a>
</h1>
{{ Notification::showAll() }}

<table class="table table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th>Display Name</th>
            <th>Unit Name</th>
            <th><i class="icon-cog"></i></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($collection as $item)
        <tr>
            <td>{{ $item->id }}</td>
            <td>{{ $item->display_name}}</a></td>
            <td>{{ $item->unit_name}}</a></td>
            <td>
                <a href="{{ URL::route('admin.cart.inventory.units.edit', $item->id) }}" class="btn btn-success btn-mini pull-left">edit</a>
                {{ Form::open(array('route' => array('admin.cart.inventory.units.destroy', $item->id), 'method' => 'delete', 'data-confirm' => 'Are you sure?')) }}

                <button type="submit" class="btn btn-danger btn-mini">Delete</butfon>
                    {{ Form::close() }}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@stop
