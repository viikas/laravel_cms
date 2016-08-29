@extends('admin._layouts.default')

@section('main')

<h1>
    Bookings 
</h1>
{{ Notification::showAll() }}

<div class="self-box-full">
    <div class="self-box-title">Filter Bookings</div>
    <div class="self-box-inner">
        {{ Form::open(array('method'=>'get'))
        }}
        <table style="width:90%;">
            <tr><td>Booking Number</td><td>{{ Form::text('book_id',Input::get('book_id')) }}</td>
                <td>Client Name</td><td>{{ Form::text('client',Input::get('client')) }}</td>
                <td>Email</td><td>{{ Form::text('email',Input::get('email')) }}</td></tr>
            <tr><td>Booked On</td><td>{{ Form::text('booked_on',Input::get('booked_on')) }}</td>
                <td>Service Date</td><td>{{ Form::text('service_date',Input::get('service_date')) }}</td>
                <td>Status</td><td>{{ Form::radio('status','all',(Input::get('status')=='all') ? true : false,array('style'=>'margin:0')) }}&nbsp;&nbsp;{{Form::label('all','All',array('style'=>'display:inline'))}}&nbsp;&nbsp;
                    {{ Form::radio('status','booked',(Input::get('status')=='booked' || Input::get('status')==null) ? true : false,array('style'=>'margin:0')) }}&nbsp;&nbsp;{{Form::label('booked','Booked only',array('style'=>'display:inline'))}}&nbsp;&nbsp;
                    {{ Form::radio('status','cancelled',(Input::get('status')=='cancelled') ? true : false,array('style'=>'margin:0')) }}&nbsp;&nbsp;{{Form::label('cancelled','Cancelled only',array('style'=>'display:inline'))}}</td></tr>
            <tr><td colspan="2">
                    {{ Form::submit('Search', array('class' => 'btn btn-success btn-save btn-medium')) }}
                    <a href="{{ URL::route('admin.bookings.index') }}" class="btn btn-medium">Reset</a>
                </td></tr>
        </table>
        {{ Form::close() }}
    </div></div>
<table class="table table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th>Client</th>
            <th>Source</th>
            <th>Destination</th>
            <th>Limousine</th>
            <th>Service Date</th>
            <th>Booked On</th>
            <th>Paid Amount</th>
            <th>Status</th>
            <th><i class="icon-cog"></i></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($bookings as $book)
        <tr>
            <td>{{ $book->id }}</td>
            <td><div>
                    <a href="javascript:void(0);" data-toggle="popover" title="Client Details" data-content="<p>Phone: {{$book->client->phone_mobile}}</p><p>City: {{$book->client->city}}</p><p>Country: {{$book->client->country}}</p>" data-html="true">
                        {{ $book->client->first_name.' '.$book->client->last_name}}
                    </a>

                </div>
                <div class="email">{{$book->client->email}}</div>
            </td>
            <td>{{ $book->source->name}}</a></td>
            <td>{{ $book->destination->name}}</a></td>
            <td>{{ $book->limousine->name }}</a></td>
            <td>{{ \Helper::ToDateString($book->service_date,true) }}</td>
            <td>{{ \Helper::ToTimeZone($book->booked_on,true) }}</td>
            <td>{{ $book->total_price }}</td>
            <td>
                @if($book->confirmed==1) <span class="confirmed">CONFIRMED</span> @elseif ($book->is_cancelled==1) <span class="cancelled">CANCELLED</span> @else <span class="booked">BOOKED</span> @endif
            </td>
            <td>
                <a href="{{ URL::route('admin.bookings.show', $book->id) }}" class="btn btn-success btn-mini pull-left">Show</a>
                {{ Form::open(array('route' => array('admin.bookings.destroy', $book->id), 'method' => 'delete', 'data-confirm' => 'Are you sure?')) }}

                <button type="submit" href="{{ URL::route('admin.bookings.destroy', $book->id) }}" class="btn btn-danger btn-mini">Delete</butfon>
                    {{ Form::close() }}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
{{$bookings->appends(array('book_id'=>Input::get('book_id'),'client'=>Input::get('client'),'booked_on'=>Input::get('booked_on'),'service_date'=>Input::get('service_date'),'email'=>Input::get('email'),'status'=>Input::get('status[]')))->links()}}
<link href="{{ URL::asset('assets/css/datepicker.css') }}" rel="stylesheet">
<script src="{{ URL::asset('assets/js/bootstrap-datepicker.js') }}"></script>
<script type="text/javascript">
    $(function (){
        $("[data-toggle='popover']").popover(); 
        $('[name=booked_on]').datepicker({format:'yyyy-mm-dd'});
        $('[name=service_date]').datepicker({format:'yyyy-mm-dd'});
    });
</script>

@stop
