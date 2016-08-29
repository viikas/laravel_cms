@extends('admin._layouts.default')

@section('main')

	<h2>Create new group</h2>

	@include('admin._partials.notifications')

	{{ Form::model($permissions,array('route' => 'admin.groups.store')) }}

		<div class="control-group">
			{{ Form::label('name-lbl', 'Group Name') }}
			<div class="controls">
				{{ Form::text('name') }}
			</div>
		</div>
        
                <div class="control-group">
			{{ Form::label('permission-lbl', 'Permissions') }}
			<div class="controls">
                            @foreach($permissions as $p)
				{{ Form::checkbox('permissions[]',$p->id,false,array('class'=>'permission')) }}&nbsp;{{Form::label('permissions[]',$p->name)}}
                            @endforeach
			</div>
		</div>

		<div class="form-actions">
			{{ Form::submit('Save', array('class' => 'btn btn-success btn-save btn-large')) }}
			<a href="{{ URL::route('admin.users.index') }}" class="btn btn-large">Cancel</a>
		</div>

	{{ Form::close() }}

@stop
