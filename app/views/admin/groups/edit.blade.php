@extends('admin._layouts.default')

@section('main')

	<h2>Edit group</h2>

	@include('admin._partials.notifications')

	{{ Form::model($group, array('method' => 'put', 'route' => array('admin.groups.update', $group->id))) }}

		<div class="control-group">
			{{ Form::label('name-lbl', 'Group Name') }}
			<div class="controls">
				{{ Form::text('name') }}
			</div>
		</div>

		<div class="form-actions">
			{{ Form::submit('Save', array('class' => 'btn btn-success btn-save btn-large')) }}
			<a href="{{ URL::route('admin.groups.index') }}" class="btn btn-large">Cancel</a>
		</div>

	{{ Form::close() }}

@stop
