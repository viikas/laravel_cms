@extends('admin._layouts.default')

@section('main')
@include('admin._partials.cms')
	<h1>
		Pages <a href="{{ URL::route('admin.cms.pages.create') }}" class="btn btn-success"><i class="icon-plus-sign"></i> Add new page</a>
	</h1>

	<hr>

	{{ Notification::showAll() }}

	<table class="table table-striped">
		<thead>
			<tr>
				<th>#</th>
				<th>Title</th>
				<th>When</th>
				<th><i class="icon-cog"></i></th>
			</tr>
		</thead>
		<tbody>
			@foreach ($pages as $page)
				<tr>
					<td>{{ $page->id }}</td>
					<td><a href="{{ URL::route('admin.cms.pages.show', $page->id) }}">{{ $page->title }}</a></td>
					<td>{{ $page->created_at }}</td>
					<td>
						<a href="{{ URL::route('admin.cms.pages.edit', $page->id) }}" class="btn btn-success btn-mini pull-left">Edit</a>

						{{ Form::open(array('route' => array('admin.cms.pages.destroy', $page->id), 'method' => 'delete', 'data-confirm' => 'Are you sure?')) }}
							<button type="submit" class="btn btn-danger btn-mini">Delete</butfon>
						{{ Form::close() }}
					</td>
				</tr>
			@endforeach
		</tbody>
	</table>

@stop
