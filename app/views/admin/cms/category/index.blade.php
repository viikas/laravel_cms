@extends('admin._layouts.default')

@section('main')
@include('admin._partials.cms')
	<h1>
		Categories <a href="{{ URL::route('admin.cms.category.create') }}" class="btn btn-success"><i class="icon-plus-sign"></i> Add new category</a>
	</h1>

	<hr>

	{{ Notification::showAll() }}

	<table class="table table-striped">
		<thead>
			<tr>
				<th>#</th>
				<th>Category Code</th>
				<th>Category Name</th>
                                <th>Created Date</th>
				<th><i class="icon-cog"></i></th>
			</tr>
		</thead>
		<tbody>
			@foreach ($cats as $c)
				<tr>
					<td>{{ $c->id }}</td>
					<td>{{ $c->code }}</td>
                                        <td>{{ $c->name }}</td>
					<td>{{ $c->created_at }}</td>
					<td>
						<a href="{{ URL::route('admin.cms.category.edit', $c->id) }}" class="btn btn-success btn-mini pull-left">Edit</a>

						{{ Form::open(array('route' => array('admin.cms.category.destroy', $c->id), 'method' => 'delete', 'data-confirm' => 'Are you sure?')) }}
							<button type="submit" class="btn btn-danger btn-mini">Delete</butfon>
						{{ Form::close() }}
					</td>
				</tr>
			@endforeach
		</tbody>
	</table>

@stop
