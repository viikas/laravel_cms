<!DOCTYPE html>
<html lang="en-US">
    <head>
        <meta charset="utf-8">
    </head>
    <body>
        <p>Dear {{$client->first_name.' '.$client->last_name}},</p>
        <p>You booking order at limousinesydneyaustralia.com has been <SPAN style="color:green;font-weight: bold;">CONFIRMED</SPAN>. Your booking reference is sent in this email. </p>
        <div><b>PLEASE READ AND CHECK ALL DETAILS THEN PRINT THIS EMAIL AND TAKE WITH YOU WHEN YOU TRAVEL.</b></div>
        <hr/>
        <h3>CUSTOMER COPY - REFERENCE NO. {{$book->id}}</h3>
        <div>
            <div>
                <h3>Customer Info</h3>
                <div>
                    <div><span style="font-weight: bold;padding-right: 10px;">Name:</span> {{$client->first_name.' '.$client->last_name}}</div>
                    <div><span style="font-weight: bold;padding-right: 10px;">Email:</span>{{$client->email}}</div>
                    <div><span style="font-weight: bold;padding-right: 10px;">Phone/Mobile:</span>{{$client->phone_mobile}}</div>
                    <div><span style="font-weight: bold;padding-right: 10px;">Address:</span>{{$client->city.','.$client->country}}</div>        
                </div>
            </div>
            <div>
                <h3>Invoice Details</h3>
                <div>
                    <div><span style="font-weight: bold;padding-right: 10px;">Total Amount (inc. of tax):</span>${{$book->total_price}} AUD</div>
                    <div><span style="font-weight: bold;padding-right: 10px;">Paid via:</span>{{$book->payment_method}}</div>
                    <div><span style="font-weight: bold;padding-right: 10px;">Payment Ref. No.:</span>{{$book->payment_ref_number}}</div>
                </div>
            </div>
            <div>
                <h3>Transfer Details</h3>
                <div>
                    <div><span style="font-weight: bold;padding-right: 10px;">Vehicle:</span>{{$book->limousine->name.' [Seat capacity: '.$book->limousine->capacity.', Luggage capacity: '.$book->limousine->baggage.']'}}</div>
                    <div><span style="font-weight: bold;padding-right: 10px;">From:</span>{{$book->source->name}}</div>
                    <div><span style="font-weight: bold;padding-right: 10px;">Pickup address:</span>{{$book->source_address_line_2.', '.$book->source_address_line_1}}</div>
                    <div><span style="font-weight: bold;padding-right: 10px;">Transfer to:</span>{{$book->destination->name}}</div>
                    <div><span style="font-weight: bold;padding-right: 10px;">Transfer address:</span>{{$book->destination_address_line_2.', '.$book->destination_address_line_1}}</div>
                    <div><span style="font-weight: bold;padding-right: 10px;">Pickup date (local):</span>{{\Helper::ToTimeZoneDate($book->service_date,true,true)}}</div>
                    <div><span style="font-weight: bold;padding-right: 10px;">Pickup time (local):</span>{{\Helper::ToTimeZoneTime($book->service_date,true,true)}}</div>
                    @if($book->return==1)
                    <div>&nbsp;</div>
                    <div><span style="font-weight: bold;padding-right: 10px;">Return date (local):</span>{{\Helper::ToTimeZoneDate($book->return_date,true,true)}}</div>
                    <div><span style="font-weight: bold;padding-right: 10px;">Return time (local):</span>{{\Helper::ToTimeZoneTime($book->return_date,true,true)}}</div>
                    @endif
                    @if($book->airport)
                    <div><span style="font-weight: bold;padding-right: 10px;">Airport:</span>{{$book->airport}}</div>
                    <div><span style="font-weight: bold;padding-right: 10px;">Airline:</span>{{$book->airline}}</div>
                    <div><span style="font-weight: bold;padding-right: 10px;">Flight No.:</span>{{$book->flight_number}}</div>
                    @endif
                </div>                   
            </div>    
            <div style="clear:both;"></div>
        </div>

        <div <div style="margin-bottom: 20px;">
            <h3>Passenger Details</h3>
            <div>
                <div><span style="font-weight: bold;padding-right: 10px;">TOTAL:</span>{{$book->total_passengers}}</div>
                    <div><span style="font-weight: bold;padding-right: 10px;">Adult:</span>{{$book->total_adult}}</div>
                    @if($book->total_children>0)
                    <div><span style="font-weight: bold;padding-right: 10px;">Children:</span>{{$book->total_children}}</div>
                    @endif
                    @if($book->total_baby>0)
                    <div><span style="font-weight: bold;padding-right: 10px;">Baby:</span>{{$book->total_baby}}</div>
                    <div><span style="font-weight: bold;padding-right: 10px;">Baby age group:</span>{{$book->baby_age_group}}</div>
                    @endif
                    @if($book->total_baggage>0)
                    <div><span style="font-weight: bold;padding-right: 10px;">Luggage:</span>{{$book->total_baggage}}</div>
                    @endif
            </div>
        </div>
        <div>CUSTOMER : Please print this reference and keep with you while traveling. Please call +61 432 229 036 if you require assistance with this booking. LimousineSydneyAustralia.com</div>
        
        <div style="margin-top: 10px;">------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------</div>
        PLEASE CUT/TEAR THE SECTION BELOW AND GIVE TO DRIVER ON DEPARTURE (IF REQUESTED)        
        <div style="margin-bottom: 10px;">------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------</div>
        <h3>DRIVER COPY - REFERENCE NO. {{$book->id}}</h3>
        <div>
            <div>
                <h4>Customer Info</h4>
                <div>
                    <div><span style="font-weight: bold;padding-right: 10px;">Name:</span> {{$client->first_name.' '.$client->last_name}}</div>
                    <div><span style="font-weight: bold;padding-right: 10px;">Email:</span> {{$client->email}}</div>
                    <div><span style="font-weight: bold;padding-right: 10px;">Phone/Mobile:</span>{{$client->phone_mobile}}</div>
                </div>
            </div>
            <div>
                <h4>Transfer Details</h4>
                <div>
                    <div><span style="font-weight: bold;padding-right: 10px;">Vehicle:</span>{{$book->limousine->name.' [No. of seats: '.$book->limousine->capacity.', Luggage: '.$book->limousine->baggage.']'}}</div>
                    <div><span style="font-weight: bold;padding-right: 10px;">From:</span>{{$book->source->name}}</div>
                    <div><span style="font-weight: bold;padding-right: 10px;">Pickup address:</span>{{$book->source_address_line_2.', '.$book->source_address_line_1}}</div>
                    <div><span style="font-weight: bold;padding-right: 10px;">Transfer to:</span>{{$book->destination->name}}</div>
                    <div><span style="font-weight: bold;padding-right: 10px;">Transfer address:</span>{{$book->destination_address_line_2.', '.$book->destination_address_line_1}}</div>
                    <div><span style="font-weight: bold;padding-right: 10px;">Pickup date (local):</span>{{\Helper::ToTimeZoneDate($book->service_date,true,true)}}</div>
                    <div><span style="font-weight: bold;padding-right: 10px;">Pickup time (local):</span>{{\Helper::ToTimeZoneTime($book->service_date,true,true)}}</div>
                    @if($book->return==1)
                    <div>&nbsp;</div>
                    <div><span style="font-weight: bold;padding-right: 10px;">Return date (local):</span>{{\Helper::ToTimeZoneDate($book->return_date,true,true)}}</div>
                    <div><span style="font-weight: bold;padding-right: 10px;">Return time (local):</span>{{\Helper::ToTimeZoneTime($book->return_date,true,true)}}</div>
                    @endif
                    @if($book->airport)
                    <div><span style="font-weight: bold;padding-right: 10px;">Airport:</span>{{$book->airport}}</div>
                    <div><span style="font-weight: bold;padding-right: 10px;">Airline:</span>{{$book->airline}}</div>
                    <div><span style="font-weight: bold;padding-right: 10px;">Flight No.:</span>{{$book->flight_number}}</div>
                    @endif
                </div>
            </div>    
            <div style="clear:both;"></div>
        </div>

        <div style="margin-bottom: 20px;">
            <h4>Passenger Details</h4>
            <div>
                <div><span style="font-weight: bold;padding-right: 10px;">TOTAL:</span>{{$book->total_passengers}}</div>
                    <div><span style="font-weight: bold;padding-right: 10px;">Adult:</span>{{$book->total_adult}}</div>
                    @if($book->total_children>0)
                    <div><span style="font-weight: bold;padding-right: 10px;">Children:</span>{{$book->total_children}}</div>
                    @endif
                    @if($book->total_baby>0)
                    <div><span style="font-weight: bold;padding-right: 10px;">Baby:</span>{{$book->total_baby}}</div>
                    <div><span style="font-weight: bold;padding-right: 10px;">Baby age group:</span>{{$book->baby_age_group}}</div>
                    @endif
                    @if($book->total_baggage>0)
                    <div><span style="font-weight: bold;padding-right: 10px;">Luggage:</span>{{$book->total_baggage}}</div>
                    @endif
            </div>
        </div>
        <div>DRIVER : Please keep this ticket as receipt. Please call +61 432 229 036 if you require assistance with this booking. LimousineSydneyAustralia.com</div>
        <div style="margin:20px;padding-top:20px;border-top:1px solid #eee;">
            <div>Thank you for working with us! HAVE PLEASURABLE AND SAFE JOURNEY!</div>
            <div>&nbsp;</div>
            <div>If you have any queries in relation to the above, please do not hesitate to contact us directly.</div>

            <div>&nbsp;</div>
            <div>Kind Regards,</div>
            <div>Limousine Sydney Australia</div>
            <div>Mob. +61432229036</div>
            <div>www.limousinesydneyaustralia.com</div>
        </div>
    </body>
</html>