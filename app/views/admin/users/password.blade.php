@extends('admin._layouts.default')

@section('main')

	<h2>Change your password</h2>

	@include('admin._partials.notifications')

	{{ Form::open(array('method' => 'put', 'route' => array('admin.users.password'))) }}

		<div class="control-group">
			{{ Form::label('cur-lbl', 'Current Password') }}
			<div class="controls">
				{{ Form::password('current_password') }}
			</div>
		</div>

		<div class="control-group">
			{{ Form::label('new-lbl', 'New Password') }}
			<div class="controls">
				{{ Form::password('password') }}
			</div>
		</div>
        
                <div class="control-group">
			{{ Form::label('confirm-lbl', 'Confirm Password') }}
			<div class="controls">
				{{ Form::password('confirm_password') }}
			</div>
		</div>
        
               <div class="form-actions">
			{{ Form::submit('Change Password', array('class' => 'btn btn-success btn-save btn-large')) }}
			<a href="{{ URL::route('admin.users.index') }}" class="btn btn-large">Cancel</a>
		</div>

	{{ Form::close() }}

@stop
