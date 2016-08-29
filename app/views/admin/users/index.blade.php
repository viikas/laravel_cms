@extends('admin._layouts.default')

@section('main')

	<h1>
		Users <a href="{{ URL::route('admin.users.create') }}" class="btn btn-success"><i class="icon-plus-sign"></i> Add new user</a>
                <a href="{{ URL::route('admin.groups.index') }}" class="btn btn-success"><i class="icon-group"></i> Manage Groups</a>
	</h1>

	<hr>

	{{ Notification::showAll() }}

	<table id="tbl-users" class="table table-striped">
		<thead>
			<tr>
				<th>ID</th>
                                <th>Email</th>
				<th>Full Name</th>
				<th>Created On</th>
                                <th>Active</th>
				<th><i class="icon-cog"></i></th>
			</tr>
		</thead>
		<tbody>
			@foreach ($users as $user)
				<tr>
                                        <td>{{ $user->id }}</td>
					<td><a href="{{ URL::route('admin.users.show', $user->email) }}">{{ $user->email }}</a></td>
					<td>{{ $user->first_name }}&nbsp;{{$user->last_name}}</td>
					<td>{{ \Helper::ToDateString($user->created_at,true) }}</td>
                                         <td>{{Form::checkbox('chk-activated','',$user->activated,array('disabled','disabled'))}}</td>
					<td>
						<a href="{{ URL::route('admin.users.edit', $user->id) }}" class="btn btn-success btn-mini pull-left">Edit</a>
                                                <a href="{{ URL::route('admin.users.reset', $user->id) }}" class="btn btn-success btn-mini pull-left">Reset Password</a>
						{{ Form::open(array('route' => array('admin.users.destroy', $user->id), 'method' => 'delete', 'data-confirm' => 'Are you sure?')) }}
							<button type="submit" href="{{ URL::route('admin.users.destroy', $user->id) }}" class="btn btn-danger btn-mini">Delete</butfon>
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
        $('#tbl-users').DataTable();
    });    
</script>

@stop
