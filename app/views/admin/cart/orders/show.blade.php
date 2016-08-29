@extends('admin._layouts.default')

@section('main')
@include('admin._partials.cart')
<h1>
    Order Details <a style="float:right;" href="{{ URL::route('admin.cart.orders.index') }}" class="btn btn-success"><i class="icon-plus-sign"></i> Back to All Orders</a>
</h1>
{{ Notification::showAll() }}

<h3>ORDER REFERENCE NO. {{$order->id}}</h3>
<div>Emailed On:: 
    <span id="emailed-date">
        @if ($order->is_invoice_emailed==1)
        {{\Helper::ToTimeZone($order->invoice_emailed_on,true)}}
        @else
        NOT EMAILED YET
        @endif
    </span>
    - <a id="a-email-now" data="{{$order->id}}" href="javascript:void(0)">
        @if ($order->is_invoice_emailed==1)
        Email Again
        @else
        Email Now
        @endif
    </a>
    <span id="working" style="display:none;padding-left: 5px;">{{HTML::image('assets/icons/working.gif','working..')}}</span>
</div>
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


<script type="text/javascript">
    $(function(){
        $('#a-email-now').click(function(){
            var msg='Are you sure to email the invoice details to the client?';
            if(confirm(msg))
            {
                do_action();
                email($(this).attr('data')); 
            }
            return false;
        });
    });
    
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
        $('#emailed-date').text(date);
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