@extends('admin._layouts.default')

@section('main')

<h1>
    Destinations & Pricing <a href="{{ URL::route('admin.destinations.create') }}" class="btn btn-success"><i class="icon-plus-sign"></i> Add New Destination</a>
</h1>

<hr>

{{ Notification::showAll() }}
<!--<div>
    {{ Form::open(array('method'=>'get'))}}
    Search Suburb &nbsp; <input type="text" name="search" id="search" />&nbsp;&nbsp;&nbsp;<span id="count" style="display:none;"></span>  
    &nbsp;&nbsp;
    {{ Form::submit('Search', array('class' => 'btn btn-success btn-save btn-medium')) }}
    {{ Form::close() }}
</div>-->

<table id="tbl-destinations" class="table table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th>Suburb Name</th>
            <th>To CBD</th>
            <th>To Sydney Airport</th>
            <th>To Sydney Int. Airport</th>
            <th><i class="icon-cog"></i></th>
        </tr>
    </thead>
    <tbody id="container">
        @foreach ($destinations as $dest)
        <tr class="item">
            <td>{{ $dest->id }}</td>
            <td>{{ $dest->name }}</a></td>
            <td>{{ $dest->price_cbd }}</td>
            <td>{{ $dest->price_dom }}</td>
            <td>{{ $dest->price_int }}</td>
            <td>
                <a href="{{ URL::route('admin.destinations.edit', $dest->id) }}" class="btn btn-success btn-mini pull-left">Edit</a>

                {{ Form::open(array('route' => array('admin.destinations.destroy', $dest->id), 'method' => 'delete', 'data-confirm' => 'Are you sure?')) }}
                <button type="submit" href="{{ URL::route('admin.destinations.destroy', $dest->id) }}" class="btn btn-danger btn-mini">Delete</butfon>
                    {{ Form::close() }}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
		
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.0/css/jquery.dataTables.css">
<script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.0/js/jquery.dataTables.js"></script>

<script type="text/javascript">
    $(function() {
        //$('#search').pageSearch({ element: 'container', child: 'item', result: 'count' });
        $('#tbl-destinations').DataTable();
    });    
</script>
@stop


