@extends('admin._layouts.default')

@section('main')

<h1>
    Quotes
</h1>
{{ Notification::showAll() }}

<div class="self-box-full">
    <div class="self-box-title">Filter Quotes</div>
    <div class="self-box-inner">
        {{ Form::open(array('method'=>'get'))
        }}
        <table style="width:90%;">
            <tr><td>Quote Number</td><td>{{ Form::text('quote_id',Input::get('quote_id')) }}</td>
                <td>Client Name</td><td>{{ Form::text('client',Input::get('client')) }}</td>
                <td>Email</td><td>{{ Form::text('email',Input::get('email')) }}</td></tr>
            <tr><td>Quote Ordered On</td><td>{{ Form::text('ordered_on',Input::get('ordered_on')) }}</td>
                <td>Pickup Date</td><td>{{ Form::text('pickup_date',Input::get('pickup_date')) }}</td>
            </tr>
            <tr><td colspan="2">
                    {{ Form::submit('Search', array('class' => 'btn btn-success btn-save btn-medium')) }}
                    <a href="{{ URL::route('admin.quotes.index') }}" class="btn btn-medium">Reset</a>
                </td></tr>
        </table>
        {{ Form::close() }}
    </div></div>
<table class="table table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th>Client</th>
            <th>Pickup address</th>
            <th>Transfer to</th>
            <th>Ordered On</th>
            <th>Pickup Date</th>
            <th><i class="icon-cog"></i></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($quotes as $quote)
        <tr>
            <td>{{ $quote->id }}</td>
            <td><div>
                    {{ $quote->full_name}}
                </div>
                <div class="email">{{$quote->email}}</div>
                <div class="email">{{$quote->phone}}</div>

            </td>
            <td>{{ $quote->source}}</a></td>
            <td>{{ $quote->destination}}</a></td>
            <td>{{ \Helper::ToTimeZone($quote->created_at,true) }}</td>
            <td>{{ \Helper::ToDateString($quote->pickup_date,true) }}</td>
            
            <td>
                <a href="{{ URL::route('admin.quotes.show', $quote->id) }}" class="btn btn-success btn-mini pull-left">Show</a>
                {{ Form::open(array('route' => array('admin.quotes.destroy', $quote->id), 'method' => 'delete', 'data-confirm' => 'Are you sure to delete?')) }}

                <button type="submit" href="{{ URL::route('admin.quotes.destroy', $quote->id) }}" class="btn btn-danger btn-mini">Delete</butfon>
                    {{ Form::close() }}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
{{$quotes->appends(array('quote_id'=>Input::get('quote_id'),'client'=>Input::get('client'),'ordered_on'=>Input::get('ordered_on'),'pickup_date'=>Input::get('pickup_date'),'email'=>Input::get('email')))->links()}}
<link href="{{ URL::asset('assets/css/datepicker.css') }}" rel="stylesheet">
<script src="{{ URL::asset('assets/js/bootstrap-datepicker.js') }}"></script>
<script type="text/javascript">
    $(function (){
        $("[data-toggle='popover']").popover(); 
        $('[name=ordered_on]').datepicker();
        $('[name=pickup_date]').datepicker();
    });
</script>

@stop
