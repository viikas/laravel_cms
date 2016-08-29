@extends('admin._layouts.default')

@section('main')

<h2>Add new limousine</h2>

@include('admin._partials.notifications')

{{ Form::open(array('route' => 'admin.limousines.store')) }}

<div class="control-group">
    {{ Form::label('name', 'Limousine Name') }}
    <div class="controls">
        {{ Form::text('name') }}
    </div>
</div>
<div class="control-group">
    {{ Form::label('price_factor', 'Price Factor') }}
    <div class="controls">
        {{ Form::text('price_factor') }}
    </div>
</div>
<div class="control-group">
    {{ Form::label('capacity', 'Men Capacity') }}
    <div class="controls">
        {{ Form::text('capacity') }}
    </div>
</div>
<div class="control-group">
    {{ Form::label('baggage', 'Baggage Capacity') }}
    <div class="controls">
        {{ Form::text('baggage') }}
    </div>
</div>

<div class="control-group">
    {{ Form::label('description', 'Description') }}
    <div class="controls">
        {{ Form::text('details') }}
    </div>
</div>


<div class="control-group">
    {{ Form::label('photo', 'Photo') }}

    <div class="fileupload fileupload-new" data-provides="fileupload">
        <div class="fileupload-preview thumbnail" style="width: 200px; height: 150px;">
            <img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+photo">
        </div>
        <div>
            <span class="btn btn-file"><span class="fileupload-new">Select photo</span><span class="fileupload-exists">Change</span>{{ Form::file('photo') }}</span>
            <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
        </div>
    </div>
</div>

<div class="form-actions">
    {{ Form::submit('Save', array('class' => 'btn btn-success btn-save btn-large')) }}
    <a href="{{ URL::route('admin.limousines.index') }}" class="btn btn-large">Cancel</a>
</div>

{{ Form::close() }}

@stop
