@extends('admin._layouts.default')

@section('main')

<h1>
    Limousines <a href="{{ URL::route('admin.limousines.create') }}" class="btn btn-success"><i class="icon-plus-sign"></i> Add New Limousine</a>
</h1>

<hr>

{{ Notification::showAll() }}

<table id="tbl-limos" class="table table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th>Limousine</th>
            <th>Men Capacity</th>
            <th>Baggage Capacity</th>
            <th>Price Factor</th>
            <th>Description</th>                                
            <th><i class="icon-cog"></i></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($limousines as $limo)
        <tr>
            <td>{{ $limo->id }}</td>
            <td>                
                <div style="padding-bottom: 4px;margin-bottom:10px;border-bottom: 1px solid #eee;">{{ $limo->name }}</div>
                @if ($limo->photo)
                    <img src="{{ Image::resize($limo->photo, 200, 150) }}" alt="">
                @else
                    <img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+photo">
                @endif
            </td>
             <td>{{ $limo->capacity }}</td>
              <td>{{ $limo->baggage }}</td>
            <td>{{ $limo->price_factor }}</td>
             <td>{{ $limo->details }}</td>
            <td>
                <a href="{{ URL::route('admin.limousines.edit', $limo->id) }}" class="btn btn-success btn-mini pull-left">Edit</a>

                {{ Form::open(array('route' => array('admin.limousines.destroy', $limo->id), 'method' => 'delete', 'data-confirm' => 'Are you sure?')) }}
                <button type="submit" href="{{ URL::route('admin.limousines.destroy', $limo->id) }}" class="btn btn-danger btn-mini">Delete</butfon>
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
        $('#tbl-limos').DataTable();
    });    
</script>

@stop
