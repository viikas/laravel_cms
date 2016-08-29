@extends('admin._layouts.default')

@section('main')

	<h2>Add new destination</h2>

	@include('admin._partials.notifications')

	{{ Form::open(array('route' => 'admin.destinations.store')) }}

		<div class="control-group">
			{{ Form::label('name', 'Suburb Name') }}
			<div class="controls">
				{{ Form::text('name') }}
			</div>
		</div>

		<div class="control-group">
			{{ Form::label('price_cbd', 'Price to CBD') }}
			<div class="controls">
				{{ Form::text('price_cbd') }}
			</div>
		</div>
                <div class="control-group">
			{{ Form::label('pice_dom', 'Price to Sydney Airport') }}
			<div class="controls">
				{{ Form::text('price_dom') }}
			</div>
		</div>
                <div class="control-group">
			{{ Form::label('pice_int', 'Price to Sydney Int. Airport') }}
			<div class="controls">
				{{ Form::text('price_int') }}
			</div>
		</div>
		<div class="form-actions">
			{{ Form::submit('Save', array('class' => 'btn btn-success btn-save btn-large')) }}
			<a href="{{ URL::route('admin.destinations.index') }}" class="btn btn-large">Cancel</a>
		</div>

	{{ Form::close() }}

@stop
