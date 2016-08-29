<!DOCTYPE html>
<html lang="en-US">
    <head>
        <meta charset="utf-8">
    </head>
    <body>
        <p>Dear {{$quote->full_name}},</p>
        <p>We have successfully received your quote order at limousinesydneyaustralia.com.</p>
        <div><b>One of our sales representatives will contact you soon with the invoice.</b></div>
        
        <hr/>
        <h3>QUOTE REFERENCE NO. {{$quote->id}}</h3>
        <div>
            <div>
                <h3>Customer Info</h3>
                <div>
                    <div><span style="font-weight: bold;padding-right: 10px;">Name:</span> {{$quote->full_name}}</div>
                    <div><span style="font-weight: bold;padding-right: 10px;">Email:</span>{{$quote->email}}</div>
                    <div><span style="font-weight: bold;padding-right: 10px;">Phone/Mobile:</span>{{$quote->phone}}</div>
                </div>
            </div>
            <div>
                <h3>Transfer Details</h3>
                <div>
                    <div><span style="font-weight: bold;padding-right: 10px;">Pickup address:</span>{{$quote->source}}</div>
                    <div><span style="font-weight: bold;padding-right: 10px;">Transfer to:</span>{{$quote->destination}}</div>
                    <div><span style="font-weight: bold;padding-right: 10px;">Pickup date (local):</span>{{\Helper::ToTimeZoneDate($quote->pickup_date,true,true)}}</div>
                    <div><span style="font-weight: bold;padding-right: 10px;">Pickup time (local):</span>{{\Helper::ToTimeZoneTime($quote->pickup_date,true,true)}}</div>
                    @if($quote->is_return==1)
                    <div>&nbsp;</div>
                    <div><span style="font-weight: bold;padding-right: 10px;">Return date (local):</span>{{\Helper::ToTimeZoneDate($book->return_date,true,true)}}</div>
                    <div><span style="font-weight: bold;padding-right: 10px;">Return time (local):</span>{{\Helper::ToTimeZoneTime($book->return_date,true,true)}}</div>
                    @endif
                </div>                   
            </div>    
            <div style="clear:both;"></div>
        </div>

        <div <div style="margin-bottom: 20px;">
            <h3>Passenger Details</h3>
            <div>
                    <div><span style="font-weight: bold;padding-right: 10px;">Adult:</span>{{$quote->adult}}</div>
                    @if($quote->children>0)
                    <div><span style="font-weight: bold;padding-right: 10px;">Children:</span>{{$quote->children}}</div>
                    @endif
                    @if($quote->baby>0)
                    <div><span style="font-weight: bold;padding-right: 10px;">Baby:</span>{{$quote->baby}}</div>
                    <div><span style="font-weight: bold;padding-right: 10px;">Baby age group:</span>{{$quote->baby_age}}</div>
                    @endif
                    @if($quote->luggage>0)
                    <div><span style="font-weight: bold;padding-right: 10px;">Luggage:</span>{{$quote->luggage}}</div>
                    @endif
            </div>
        </div>
            <div <div style="margin-bottom: 20px;">
            <h3>Remarks</h3>
            <div>
                    @if(!empty($quote->remarks))
                    <div>{{$quote->remarks}}</div>
                    @else
                    <div>N/A</div>
                    @endif
            </div>
        </div>
        <div style="margin:20px;padding-top:20px;border-top:1px solid #eee;">
            <div>Thank you for working with us!</div>
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