@include('site::_partials/header')
<style>input[type=text]{width:100%;}</style>
<div class="row">
    <div class="large-12 columns">
        @include('site::_partials/breadcrumb')
    </div>
</div>
<div class="row">
    <div class="large-12 columns">
        <h2>Checkout</h2>
        <p>Please fill the shipping and billing address and confirm the items in the cart.</p>
    </div>
</div>
<div class="row">
    <div class="large-12 columns" style="background-color:#eee;padding-top: 6px;padding-bottom: 6px;">
        @if($errors->has())
        <p style="color:red;font-weight: bold;">Please fix the following errors and submit again.</p>
         <div class="float-left">
            <div style="color:Red;font-weight: bold;">Errors in billing address:</div>
            @foreach ($errors->all() as $error)
            @if (strpos($error, 'billing:') !== FALSE)
            <div style="color:red;padding:5px 0;">{{ substr($error,9) }}</div>
            @endif
            @endforeach
        </div>
        <div class="float-left" style="margin-left: 60px;">
            <div style="color:Red;font-weight: bold;">Errors in shipping address:</div>
            @foreach ($errors->all() as $error)
            @if (strpos($error, 'shipping:') !== FALSE)
            <div style="color:red;padding:5px 0;">{{ substr($error,9) }}</div>
            @endif
            @endforeach
        </div>
        <div class="clear"></div>
        @endif
    </div>
</div>
<div class="row">
    <div class="large-12 columns">
        <h3><span class="badge-vintage">1</span> Billing and Shipping Address</h3>       
    </div>
</div>
{{Form::open(array('route'=>'site.cart.payment','method'=>'post'))}}
<div class="row">
    <div class="large-6 columns">
        <table style="width:85%">
            <tr><th colspan="2">Billing Address</th></tr>
            <tr>
                <td>Title</td>
                <td>{{Form::select('title',\Helper::GetTitles(true,'--choose title--',''),$shop->title)}}</td>
            </tr>
            <tr>
                <td>First Name</td>
                <td>{{Form::text('first_name',$shop->first_name)}}</td>
            </tr>
            <tr>
                <td>Last Name</td>
                <td>{{Form::text('last_name',$shop->last_name)}}</td>
            </tr>
            <tr>
                <td>Email</td>
                <td>{{Form::text('email',$shop->email)}}</td>
            </tr>
            <tr>
                <td>Company</td>
                <td>{{Form::text('company',$shop->company)}}</td>
            </tr>
            <tr>
                <td>Country</td>
                <td>{{Form::select('country',\Helper::GetCountries(true,'--select country--',''),$shop->country)}}</td>
            </tr>
            <tr>
                <td>State/province</td>
                <td>{{Form::text('state',$shop->state)}}</td>
            </tr>
            <tr>
                <td>City</td>
                <td>{{Form::text('city',$shop->city)}}</td>
            </tr>
            <tr>
                <td>Address 1</td>
                <td>{{Form::text('address1',$shop->address1)}}</td>
            </tr>
            <tr>
                <td>Address 2 </td>
                <td>{{Form::text('address2',$shop->address2)}}</td>
            </tr>
            <tr>
                <td>Zip/postal code</td>
                <td>{{Form::text('zip',$shop->zip)}}</td>
            </tr>
            <tr>
                <td>Phone number</td>
                <td>{{Form::text('home_phone',$shop->home_phone)}}</td>
            </tr>
        </table>
    </div>
    <div class="large-6 columns">
        <table style="width:85%">
            <tr><th colspan="2">Shipping Address</th></tr>
            <tr>
                <td colspan="2"><input type="checkbox" id="chkSame" style="margin-right: 8px;"/><label for="chkSame">Same as billing address and edit</label></td>
            </tr>
            <tr>
                <td>Title</td>
                <td>{{Form::select('title_s',\Helper::GetTitles(true,'--choose title--',''),$shop->title_s)}}</td>
            </tr>
            <tr>
                <td>First Name</td>
                <td>{{Form::text('first_name_s',$shop->first_name_s)}}</td>
            </tr>
            <tr>
                <td>Last Name</td>
                <td>{{Form::text('last_name_s',$shop->last_name_s)}}</td>
            </tr>
            <tr>
                <td>Email</td>
                <td>{{Form::text('email_s',$shop->email_s)}}</td>
            </tr>
            <tr>
                <td>Company</td>
                <td>{{Form::text('company_s',$shop->company_s)}}</td>
            </tr>
            <tr>
                <td>Country</td>
                <td>{{Form::select('country_s',\Helper::GetCountries(true,'--select country--',''),$shop->country_s)}}</td>
            </tr>
            <tr>
                <td>State/province</td>
                <td>{{Form::text('state_s',$shop->state_s)}}</td>
            </tr>
            <tr>
                <td>City</td>
                <td>{{Form::text('city_s',$shop->city_s)}}</td>
            </tr>
            <tr>
                <td>Address 1</td>
                <td>{{Form::text('address1_s',$shop->address1_s)}}</td>
            </tr>
            <tr>
                <td>Address 2 </td>
                <td>{{Form::text('address2_s',$shop->address2_s)}}</td>
            </tr>
            <tr>
                <td>Zip/postal code</td>
                <td>{{Form::text('zip_s',$shop->zip_s)}}</td>
            </tr>
            <tr>
                <td>Phone number</td>
                <td>{{Form::text('home_phone_s',$shop->home_phone_s)}}</td>
            </tr>
        </table>
    </div>
</div>	

<div class="row">
    <div class="large-12 columns">
        <h3><span class="badge-vintage">2</span> Cart Summary</h3>       
    </div>
</div>
<div class="row">
    <div class="large-12 columns">
        <table style="width: 100%">
            <thead>
                <tr>
                    <th>product</th>
                    <th>quantity</th>
                    <th>unit price</th>
                    <th>total</th>
                </tr>
            </thead>
            <tbody>

                @foreach (Cart::content() as $item)
                <tr>
                    <td>{{$item->name}}</td>
                    <td>{{Form::label('qty-'.$item->rowid, $item->qty,array('style'=>'padding:5px;width:60px;','maxlength'=>2))}}</td>
                    <td>${{$item->price}}</td>
                    <td>${{number_format($item->qty * $item->price,2)}}</td>

                </tr>
                @endforeach
                <tr><td colspan="3" style="text-align: right;">Total price:</td><td style="color:Red;">${{number_format(Cart::total(),2)}}</td></tr>
                <tr><td colspan="3" style="text-align: right;">Total quantity:</td><td>{{Cart::count()}}</td></tr>
            </tbody>
        </table>
    </div>
</div>
<div class="row">
    <div class="large-12 columns">
        <h3><span class="badge-vintage">3</span> Booking Confirmation</h3>       
    </div>
</div>
<div class="row">
    <div class="large-12 columns">
        <input type="submit" class="btn-vintage-dark" value="Confirm Booking and Proceed to Pay"/>
        &nbsp;&nbsp;
        <a class="btn-vintage" style="color:red;" href="{{URL::route('site.cart.index')}}">Cancel</a>   
    </div>
</div>
{{Form::close()}}

@include('site::_partials.footer')
<script type="text/javascript" src="{{asset('site/assets/js/jquery.js')}}"></script>
<script type="text/javascript">
    $(function(){
        $('#chkSame').click(function(){
            if($(this).is(':checked'))
            {
                $('select[name=title_s]').val($('select[name=title]').val());
                $('input[name=first_name_s]').val($('input[name=first_name]').val());
                $('input[name=last_name_s]').val($('input[name=last_name]').val());
                $('input[name=email_s]').val($('input[name=email]').val());
                $('input[name=company_s]').val($('input[name=company]').val());
                $('select[name=country_s]').val($('select[name=country]').val());
                $('input[name=state_s]').val($('input[name=state]').val());
                $('input[name=city_s]').val($('input[name=city]').val());
                $('input[name=address1_s]').val($('input[name=address1]').val());
                $('input[name=address2_s]').val($('input[name=address2]').val());                
                $('input[name=zip_s]').val($('input[name=zip]').val());
                $('input[name=home_phone_s]').val($('input[name=home_phone]').val());
            }
        });
    });
    
    
    </script>


