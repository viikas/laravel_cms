<p>Hi {{name}},</p>
<p>You have successfully placed a booking order at limousine sydney australia. Your invoice is as below.</p>
<h2>Booking# {{$book->id}}</h2>
<hr>
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
            <tr><td class="bold italic">Payment Details:</td><td>{{$book->payment_details}}</td></tr>
        </table>
    </div>
</div>
<div class="float-left margin-left-40">
    <h4>Other Details</h4>
    <div class="email">
        <table>
            <tr><td class="bold italic">Status:</td><td>@if ($book->is_cancelled==0) {{'BOOKED'}} @else {{'CANCELLED'}} @endif</td></tr>
            <tr><td class="bold italic">Booked On:</td><td>{{$book->booked_on}}</td></tr>
            @if ($book->is_invoice_emailed==1)
            <tr><td class="bold italic">Invoice Emailed On:</td><td>{{$book->invoice_emailed_on}}</td></tr>
            @else
            <tr><td class="bold" colspan="2">Invoice NOT EMAILED to client - <a href="javascript:void(0)">Email Now</a></td></tr>
            @endif
            @if($book->is_cancelled)
            <tr><td class="bold italic">Cancelled On:</td><td>{{$book->cancelled_on}}</td></tr>
            <tr><td class="bold italic">Cancellation Reason:</td><td>{{$book->cancellation_reason}}</td></tr>
            @else
                <tr><td class="bold" colspan="2"><a href="javascript:void(0)">Cancel Booking</a></td></tr>
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
                <td class="label">Total Baggages</td><td>{{$book->total_baggages}}</td></tr>
        </table>
    </div>
</div>

<div class="self-box">
    <h5>Destination Details</h5>
    <div>
        <table class="flat-table" style="width:550px;">
            <tr><td class="label">From</td><td>{{$book->source->name}}</td>
                <td class="label">To</td><td>{{$book->destination->name}}</td></tr>
            <tr><td class="label">Pickup Date/Time</td><td>{{$book->service_date}}</td>
                <td class="label">Return Date/Time</td><td>{{($book->return_date==null) ? '-' : $book->return_date}}</td></tr>
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
<div>Thank you for working with us!</div>
<div>Limousine Sydney Australia</div>
@stop