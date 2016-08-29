<!DOCTYPE html>
<html lang="en-US">
    <head>
        <meta charset="utf-8">
    </head>
    <body>
        <p>Dear {{$billing->first_name}},</p>
        <p>Your purchase order at www.nepalvintage.com has been received successfully.</p>
        <div><b>Please find the order invoice below.</b></div>

        <hr/>
        <h3>ORDER REFERENCE NO. {{$order->id}}</h3>
        <div>
            <div>
                <h3>Invoice Summary</h3>
                <div>
                    <div><span style="font-weight: bold;padding-right: 10px;">Order date:</span> {{\Helper::ToTimeZoneDate($order->order_date,true,true)}}</div>
                    <div><span style="font-weight: bold;padding-right: 10px;">Amount:</span> ${{$order->amount}}</div>
                    <div><span style="font-weight: bold;padding-right: 10px;">Tax:</span> ${{$order->tax}}</div>
                    <div><span style="font-weight: bold;padding-right: 10px;">Shipping:</span> ${{$order->shipping_cost}}</div>
                    <div><span style="font-weight: bold;padding-right: 10px;">Total:</span> ${{number_format($order->amount+$order->tax+$order->shipping_cost,2)}}</div>
                </div>
            </div>
            <div>
                <h3>Billing Address</h3>
                <div>
                    <div><strong>{{$billing->title.' '.$billing->first_name.' '.$billing->last_name}}</strong></div>
                    @if($billing->company)
                    <div><strong style="padding-right: 5px;">Company:</strong>{{$billing->company}}</div>
                    @endif                    
                    <div>
                        @if($billing->address2)
                        {{$billing->address2.', '}}
                        @endif
                        {{$billing->address1}}
                    </div>
                    <div>
                        {{$billing->city.', '}}
                        @if($billing->state)
                        {{$billing->state.' '}}
                        @endif
                        {{$billing->zip.' '}}
                        {{$billing->country}}
                    </div>

                    <div><strong style="padding-right: 5px;">Email:</strong>{{$billing->email}}</div>
                    <div><strong style="padding-right: 5px;">Phone:</strong>{{$billing->home_phone}}</div>

                </div>
            </div>
            <div>
                <h3>Shipping Address</h3>
                <div>
                    <div><strong>{{$shipping->title.' '.$shipping->first_name.' '.$shipping->last_name}}</strong></div>
                    @if($shipping->company)
                    <div><strong style="padding-right: 5px;">Company:</strong>{{$shipping->company}}</div>
                    @endif                    
                    <div>
                        @if($shipping->address2)
                        {{$shipping->address2.', '}}
                        @endif
                        {{$shipping->address1}}
                    </div>
                    <div>
                        {{$shipping->city.', '}}
                        @if($shipping->state)
                        {{$shipping->state.' '}}
                        @endif
                        {{$shipping->zip.' '}}
                        {{$shipping->country}}
                    </div>

                    <div><strong style="padding-right: 5px;">Email:</strong>{{$shipping->email}}</div>
                    <div><strong style="padding-right: 5px;">Phone:</strong>{{$shipping->home_phone}}</div>

                </div>
            </div>

            <div>
                <h3>Order Items</h3>
                <div>
                    <table style="width:70%;border:1px solid #ddd;text-align: center;" rules="all" cellpadding="5px">
                        <tr><th>S.N.</th><th>Product</th><th>Quantity</th></tr>
                        @foreach($products as $index=>$item)
                        <tr><td>{{$index+1}}</td><td>{{App\Models\Cart\Products::find($item->products_id)->name}}</td><td>{{$item->qty}}</td></tr>
                        @endforeach
                    </table>
                </div>
            </div>
            <div style="clear:both;"></div>
        </div>
        <div style="margin:20px;padding-top:20px;border-top:1px solid #eee;">
            <div>Thank you for working with us!</div>
            <div>&nbsp;</div>
            <div>If you have any queries in relation to the above, please do not hesitate to contact us directly.</div>

            <div>&nbsp;</div>
            <div>Kind Regards,</div>
            <div>Nepal Vintage</div>
            <div>Mob. +977 015666666</div>
            <div>www.nepalvintage.com</div>
        </div>
    </body>
</html>