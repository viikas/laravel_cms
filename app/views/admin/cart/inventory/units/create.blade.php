@extends('admin._layouts.default')

@section('main')

<h2>Add new unit</h2>

@include('admin._partials.notifications')

{{ Form::open(array('route' => 'admin.cart.inventory.units.store')) }}

<div class="control-group">
    {{ Form::label('display_name', 'Display Name') }}
    <div class="controls">
        {{ Form::text('display_name') }}
    </div>
</div>

<div class="control-group">
    {{ Form::label('unit_name', 'Unit Name') }}
    <div class="controls">
        {{ Form::text('unit_name') }}
    </div>
</div>               
<div class="form-actions">
			{{ Form::submit('Save', array('class' => 'btn btn-success btn-save btn-large')) }}
			<a href="{{ URL::route('admin.cart.inventory.units.index') }}" class="btn btn-large">Cancel</a>
		</div>
{{ Form::close() }}

@stop
