@extends('admin._layouts.default')

@section('main')

	<h2>Reset a user's password</h2>

	@include('admin._partials.notifications')

	{{ Form::model($user, array('method' => 'put', 'route' => array('admin.users.reset', $user->id))) }}

		<div class="control-group">
			{{ Form::label('full-name-lbl', 'User Name') }}
			<div class="controls">
				{{ Form::label('user_full_name',$user->first_name) }}
			</div>
		</div>

		<div class="control-group">
			{{ Form::label('email-lbl', 'Email') }}
			<div class="controls">
				{{ Form::label('user_email',$user->email) }}
			</div>
		</div>
        
               <div class="form-actions">
			{{ Form::submit('Reset and Email Password', array('class' => 'btn btn-success btn-save btn-large')) }}
			<a href="{{ URL::route('admin.users.index') }}" class="btn btn-large">Cancel</a>
		</div>

	{{ Form::close() }}

@stop
