@extends('admin._layouts.default')

@section('main')

	<h1>
		Manage Permissions <a href="{{ URL::route('admin.permissions.create') }}" class="btn btn-success"><i class="icon-user-group"></i> Add New Permission</a>
	</h1>

	<hr>

	{{ Notification::showAll() }}

	<table class="table table-striped">
		<thead>
			<tr>
				<th>ID</th>
                                <th>Name</th>
				<th>Created On</th>
                               <th><i class="icon-cog"></i></th>
			</tr>
		</thead>
		<tbody>
			@foreach ($permissions as $p)
				<tr>
                                        <td>{{ $p->id }}</td>
					<td>{{ $p->name }}</td>
					<td>{{ $p->created_at }}</td>
                                         <td>
						<a href="{{ URL::route('admin.permissions.edit', $p->id) }}" class="btn btn-success btn-mini pull-left">Edit</a>

						{{ Form::open(array('route' => array('admin.permissions.destroy', $p->id), 'method' => 'delete', 'data-confirm' => 'Are you sure?')) }}
							<button type="submit" href="{{ URL::route('admin.users.destroy', $p->id) }}" class="btn btn-danger btn-mini">Delete</butfon>
						{{ Form::close() }}
					</td>
				</tr>
			@endforeach
		</tbody>
	</table>

@stop
