@extends('admin._layouts.default')

@section('main')

<h2>Edit destination & pricing</h2>

@include('admin._partials.notifications')

{{ Form::model($dest, array('method' => 'put', 'route' => array('admin.destinations.update', $dest->id))) }}

<div class="control-group">
			{{ Form::label('name', 'Suburb Name') }}
			<div class="controls">
				{{ Form::text('name',$dest->name) }}
			</div>
		</div>

		<div class="control-group">
			{{ Form::label('price_cbd', 'Price to CBD') }}
			<div class="controls">
				{{ Form::text('price_cbd',$dest->price_cbd) }}
			</div>
		</div>
                <div class="control-group">
			{{ Form::label('price_dom', 'Price to Sydney Airport') }}
			<div class="controls">
				{{ Form::text('price_dom',$dest->price_dom) }}
			</div>
		</div>
                <div class="control-group">
			{{ Form::label('price_int', 'Price to Sydney Int. Airport') }}
			<div class="controls">
				{{ Form::text('price_int',$dest->price_int) }}
			</div>
		</div>

<div class="form-actions">
    {{ Form::submit('Save', array('class' => 'btn btn-success btn-save btn-large')) }}
    <a href="{{ URL::route('admin.destinations.index') }}" class="btn btn-large">Cancel</a>
</div>

{{ Form::close() }}

@stop
