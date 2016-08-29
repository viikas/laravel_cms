@extends('admin._layouts.default')

@section('main')
<h2>Booking# {{$book->id}} <a style="float:right;" href="{{ URL::route('admin.bookings.index') }}" class="btn btn-success"><i class="icon-plus-sign"></i> Back to All Bookings</a>
</h2>
<hr>
{{Form::open()}}
<div class="float-left border-right-10">
    <h4>Client Details</h4>
    <div>
        {{$book->client->first_name.' '.$book->client->last_name}}<br/>
        <div class="email">{{$book->client->email}}</div>
        <div class="email">{{$book->client->phone_mobile}}</div>
        <div class="email">{{$book->client->city.','.$book->client->country}}</div>        
    </div>
</div>
<div class="float-left margin-left-40">
    <h4>Invoice</h4>
    <div class="email">
        <table>
            <tr><td class="bold italic">Total Amount:</td><td>${{$book->total_price}} AUD</td></tr>
            <tr><td class="bold italic">Paid Via:</td><td>{{$book->payment_method}}</td></tr>
            <tr><td class="bold italic">Payment Ref. No.:</td><td>{{$book->payment_ref_number}}</td></tr>
            <!--<tr><td class="bold italic">Payment Details:</td><td>{{$book->payment_details}}</td></tr>-->
        </table>
    </div>
</div>
<div class="float-left margin-left-40">
    <h4>Other Details</h4>
    <div class="email">
        <table>
            <tr>
                <td class="bold italic">Status:</td>
                <td id="td-status">@if($book->confirmed==1) <span class="confirmed">CONFIRMED</span> @elseif ($book->is_cancelled==1) <span class="cancelled">CANCELLED</span> @else <span class="booked">BOOKED</span> @endif</td>
                <td><span id="working" style="display:none;">{{HTML::image('assets/icons/working.gif','working..')}}</span></td>
            </tr>
            <tr><td class="bold italic">Booked On:</td><td>{{\Helper::ToTimeZone($book->booked_on,true)}}</td></tr>
            <tr>
                <td class="bold italic">Invoice Emailed On:</td>
                <td id="td-email-now">
                    @if ($book->is_invoice_emailed==1)
                        {{\Helper::ToTimeZone($book->invoice_emailed_on,true)}}
                    @else
                        NOT EMAILED YET
                    @endif
                </td>
                <td> - <a id="a-email-now" data="{{$book->id}}" href="javascript:void(0)">
                        @if ($book->is_invoice_emailed==1)
                        Email Again
                        @else
                            Email Now
                        @endif
                  </a>
                </td>
            </tr>
            
            @if($book->is_cancelled)
            <tr id="tr-cancelled-on"><td class="bold italic">Cancelled On:</td><td id="td-cancelled-on">{{\Helper::ToTimeZone($book->cancelled_on,true)}}</td></tr>
            <tr id="tr-cancel-now"><td class="bold" colspan="2"><a type="undo" data="{{$book->id}}" id="a-cancel-now" href="javascript:void(0)">Confirm Booking</a></td></tr>
            @else
            <tr id="tr-cancel-now"><td class="bold" colspan="2"><a type="cancel" data="{{$book->id}}" id="a-cancel-now" href="javascript:void(0)">Cancel Booking</a></td></tr>
            @endif
        </table>
    </div>
</div>
<div class="clear"></div>

<div class="self-box">
    <h5>Limousine</h5>
    <div>
        <table class="flat-table" style="width:450px;">
            <tr><td class="label">Name</td><td>{{$book->limousine->name}}</td></tr>
        </table>
    </div>
</div>

<div class="self-box">
    <h5>Passenger Details</h5>
    <div>
        <table class="flat-table" style="width:450px;">
            <tr><td class="label">No. of Adult</td><td>{{$book->total_adult}}</td>
                <td class="label">No. of Children</td><td>{{$book->total_children}}</td></tr>
            <tr><td class="label">No. of Baby</td><td>{{$book->total_baby}}</td>
                <td class="label">Baby Age Group</td><td>{{$book->baby_age_group}}</td></tr>
            <tr><td class="label">Total Passengers</td><td>{{$book->total_passengers}}</td>
                <td class="label">Total Baggages</td><td>{{$book->total_baggage}}</td></tr>
        </table>
    </div>
</div>

<div class="self-box">
    <h5>Destination Details</h5>
    <div>
        <table class="flat-table" style="width:550px;">
            <tr><td class="label">From</td><td>{{$book->source->name}}</td>
                <td class="label">To</td><td>{{$book->destination->name}}</td></tr>
            <tr><td class="label">Pickup Date/Time</td><td>{{\Helper::ToDateString($book->service_date,true)}}</td>
                <td class="label">Return Date/Time</td><td>{{($book->return_date==null) ? '-' : \Helper::ToDateString($book->return_date,true)}}</td></tr>
        </table>
    </div>
</div>

<div class="self-box">
    <h5>Airline Details</h5>
    <div>
        <table class="flat-table" style="width:650px;">
            <tr><td class="label">Airport</td><td>{{($book->airport==null) ? '-' : $book->airport}}</td>
                <td class="label">Airline</td><td>{{($book->airline==null) ? '-' : $book->airline}}</td>
            <td class="label">Flight No.</td><td>{{($book->flight_number==null) ? '-' : $book->flight_number}}</td></tr>
            <tr>
        </table>
    </div>
</div>
{{Form::open()}}
<script type="text/javascript">
    $(function(){
        $('#a-cancel-now').click(function(){
           var type=$(this).attr('type');
           var msg=(type=='cancel') ? 'CANCEL' : 'CONFIRM ';
           msg='Are you sure you want to '+msg+' this booking order?';
           if(confirm(msg))
            {
                do_action();
                if(type=='cancel')
                    cancel($(this).attr('data')); 
                else
                    undo($(this).attr('data'));                
            }
            return false;
        });
    
    $('#a-email-now').click(function(){
           var msg='Are you sure to email status of the booking along with the booking details to the client?';
           if(confirm(msg))
            {
                do_action();
                email($(this).attr('data')); 
            }
            return false;
        });
    });
    
    function cancel(id)
    {
        $.post(
            $(this).prop('action'),
            {
                "_token": $('form').find( 'input[name=_token]' ).val(),
                "type":'cancel',
                "id": id
            },
            function( data ) {
                
                if(data.status=='success')
                {
                    cancelUI(data.msg);
                }
                else
                {
                    cancelError(data.msg)
                }
                do_cut();
            },
            'json'
        );
    }
    
    function cancelUI(date)
    {
        $('#a-cancel-now').text('Confirm Booking');
        $('#a-cancel-now').attr('type','undo');
        var x='<tr id="tr-cancelled-on"><td class="bold italic">Cancelled On:</td><td id="td-cancelled-on">'+date+'</td></tr>';
        $('tr#tr-cancel-now').before(x);
        $('#td-status').html('<span class="cancelled">CANCELLED</span>');
        
    }
    
    function cancelError(msg)
    {
        alert(msg);
    }
    
    function undo(id)
    {
        $.post(
            $(this).prop('action'),
            {
                "_token": $('form').find( 'input[name=_token]' ).val(),
                "type":'undo',
                "id": id
            },
            function( data ) {
                
                if(data.status=='success')
                {
                    undoUI(data.msg);
                }
                else
                {
                    undoError(data.msg)
                }
                do_cut();
            },
            'json'
        );
    }
    
    function undoUI(date)
    {
        $('#a-cancel-now').text('Cancel Booking');
        $('#a-cancel-now').attr('type','cancel');
        
        $('#tr-cancelled-on').remove(); 
        $('#td-status').html('<span class="confirmed">CONFIRMED</span>');
    }
    
    function undoError(msg)
    {
        alert(msg);        
    }
    
    function email(id)
    {
        $.post(
            $(this).prop('action'),
            {
                "_token": $('form').find( 'input[name=_token]' ).val(),
                "type":'email',
                "id": id
            },
            function( data ) {
                
                if(data.status=='success')
                {
                    emailUI(data.data);
                }
                else
                {
                    emailError(data.msg)
                }
                do_cut();
            },
            'json'
        );
    }
    
    function emailUI(date)
    {
        $('#a-email-now').html('Resend Email');
        $('#td-email-now').text(date);
    }
    
    function emailError(msg)
    {
        alert(msg);        
    }
    
    function do_action()
    {
        $('#working').show();
    }
    
    function do_cut()
    {
        $('#working').hide();
    }
</script>

@stop