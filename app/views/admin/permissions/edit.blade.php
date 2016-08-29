@extends('admin._layouts.default')

@section('main')

	<h2>Update permisson</h2>

	@include('admin._partials.notifications')

	{{ Form::model($permission, array('method' => 'put', 'route' => array('admin.permissions.update', $permission->id))) }}

		<div class="control-group">
			{{ Form::label('name-lbl', 'Permission name') }}
			<div class="controls">
				{{ Form::text('name') }}
			</div>
		</div>

		<div class="form-actions">
			{{ Form::submit('Save', array('class' => 'btn btn-success btn-save btn-large')) }}
			<a href="{{ URL::route('admin.permissions.index') }}" class="btn btn-large">Cancel</a>
		</div>

	{{ Form::close() }}

@stop
