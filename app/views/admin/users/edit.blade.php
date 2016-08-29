@extends('admin._layouts.default')

@section('main')

	<h2>Edit user</h2>

	@include('admin._partials.notifications')

	{{ Form::model($user, array('method' => 'put', 'route' => array('admin.users.update', $user->id))) }}

		<div class="control-group">
			{{ Form::label('title', 'First Name') }}
			<div class="controls">
				{{ Form::text('first_name') }}
			</div>
		</div>

		<div class="control-group">
			{{ Form::label('body', 'Last Name') }}
			<div class="controls">
				{{ Form::text('last_name') }}
			</div>
		</div>
        
                <div class="control-group">
			{{ Form::label('body', 'Active') }}
			<div class="controls">
				{{ Form::checkbox('activated') }}
			</div>
		</div>
        
                <div class="control-group">
			{{ Form::label('active-lbl', 'User group') }}
			<div class="controls">
				{{ Form::select('groupid',$groups,$groupId) }}
			</div>
		</div>

		<div class="form-actions">
			{{ Form::submit('Save', array('class' => 'btn btn-success btn-save btn-large')) }}
			<a href="{{ URL::route('admin.users.index') }}" class="btn btn-large">Cancel</a>
		</div>

	{{ Form::close() }}

@stop
