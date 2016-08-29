@include('site::_partials/header')
<div class="row">
    <div class="large-12 columns">
        @include('site::_partials/breadcrumb')
    </div>
</div>
<div class="row">
    <div class="large-12 columns">
        {{ Notification::showAll() }}
    </div>
</div>
<div class="row">
    <div class="large-12 columns">
        <h2>My Cart</h2>
    </div>
</div>

<div class="row">
    <div class="large-12 columns">
        {{Form::open(array('route'=>'site.cart.update','method'=>'post'))}}
        <table style="width: 100%">
            <thead>
                <tr>
                    <th></th>
                    <th>product</th>
                    <th>quantity</th>
                    <th>unit price</th>
                    <th>total</th>
                </tr>
            </thead>
            <tbody>

                @foreach (Cart::content() as $item)
                <tr>
                    <td>{{Form::checkbox('rows[]','chk-'.$item->rowid)}}</td>
                    <td>{{$item->name}}</td>
                    <td>{{Form::text('qty-'.$item->rowid, $item->qty,array('style'=>'padding:5px;width:60px;','maxlength'=>2))}}</td>
                    <td>${{$item->price}}</td>
                    <td>${{number_format($item->qty * $item->price,2)}}</td>
                   
                </tr>
                @endforeach
                @if(Cart::count()==0)
                <tr><td colspan="6"><span style="color:Red;">No item in your cart.</span> Please visit our <a href="{{URL::route('site.products')}}">products page</a>.</td></tr>
                @else
                <tr><td colspan="4" style="text-align: right;">Total price:</td><td style="color:Red;">${{number_format(Cart::total(),2)}}</td></tr>
                <tr><td colspan="4" style="text-align: right;">Total quantity:</td><td>{{Cart::count()}}</td></tr>
                <tr><td colspan="12"><input type="submit" name="update" class="btn-vintage" value="update selected"/>&nbsp;&nbsp;
            <input type="submit" name="remove" class="btn-vintage" style="color:Red;" value="remove selected"/></td></tr>    
                @endif
            </tbody>
        </table>
        @if(Cart::count()>0)
        <div>            
            <a class="btn-vintage-dark-gray" href="{{URL::route('site.products')}}">Continue Shopping</a>&nbsp;&nbsp;
            <a class="btn-vintage-dark" href="{{URL::route('site.cart.checkout')}}">Checkout Now</a>
        </div>
        @endif
        {{Form::close()}}
    </div>
</div>


@include('site::_partials.footer')




