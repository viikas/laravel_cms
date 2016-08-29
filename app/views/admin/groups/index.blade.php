@extends('admin._layouts.default')

@section('main')

	<h1>
		Manage User Groups <a href="{{ URL::route('admin.groups.create') }}" class="btn btn-success"><i class="icon-user-group"></i> Add New Group</a>
	</h1>

	<hr>

	{{ Notification::showAll() }}

	<table class="table table-striped">
		<thead>
			<tr>
				<th>ID</th>
                                <th>Group Name</th>
				<th>Permissions</th>
				<th>Created On</th>
                               <th><i class="icon-cog"></i></th>
			</tr>
		</thead>
		<tbody>
			@foreach ($groups as $group)
				<tr>
                                        <td>{{ $group->id }}</td>
					<td>{{ $group->name }}</td>
					<td>@foreach ($group->permissions as $permission){{ $permission }} @endforeach</td>
					<td>{{ $group->created_at }}</td>
                                         <td>
						<a href="{{ URL::route('admin.groups.edit', $group->id) }}" class="btn btn-success btn-mini pull-left">Edit</a>

						{{ Form::open(array('route' => array('admin.groups.destroy', $group->id), 'method' => 'delete', 'data-confirm' => 'Are you sure?')) }}
							<button type="submit" href="{{ URL::route('admin.users.destroy', $group->id) }}" class="btn btn-danger btn-mini">Delete</butfon>
						{{ Form::close() }}
					</td>
				</tr>
			@endforeach
		</tbody>
	</table>

@stop
