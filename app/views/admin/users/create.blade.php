@extends('admin._layouts.default')

@section('main')

	<h2>Create new user</h2>

	@include('admin._partials.notifications')

	{{ Form::open(array('route' => 'admin.users.store')) }}

		<div class="control-group">
			{{ Form::label('firstname-lbl', 'First Name') }}
			<div class="controls">
				{{ Form::text('first_name') }}
			</div>
		</div>
                <div class="control-group">
			{{ Form::label('lastname-lbl', 'Last Name') }}
			<div class="controls">
				{{ Form::text('last_name') }}
			</div>
		</div>
        
                 <div class="control-group">
			{{ Form::label('email-lbl', 'Email') }}
			<div class="controls">
				{{ Form::text('email') }}
			</div>
		</div>
        
                <div class="control-group">
			{{ Form::label('pwd-lbl', 'Password') }}
			<div class="controls">
				{{ Form::password('password') }}
			</div>
		</div>
        
                <div class="control-group">
			{{ Form::label('confrm-pwd-lbl', 'Confirm Password') }}
			<div class="controls">
				{{ Form::password('confirm_password') }}
			</div>
		</div>

		<div class="control-group">
			{{ Form::label('active-lbl', 'Active') }}
			<div class="controls">
				{{ Form::checkbox('activated') }}
			</div>
		</div>
        
                <div class="control-group">
			{{ Form::label('active-lbl', 'User group') }}
			<div class="controls">
				{{ Form::select('groupid',$groups) }}
			</div>
		</div>

		<div class="form-actions">
			{{ Form::submit('Save', array('class' => 'btn btn-success btn-save btn-large')) }}
			<a href="{{ URL::route('admin.users.index') }}" class="btn btn-large">Cancel</a>
		</div>

	{{ Form::close() }}

@stop
