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
        <h2>Payment Cancelled</h2>
    </div>
</div>
<div class="animated fadeInUp">	
    <works>		
        <div class="row">
            <div class="large-12 columns">
               We saw that you have cancelled your payment process. You can always continue your purchase from your <a href="{{URL::route('site.cart.index')}}">shopping cart</a>.
            Thank you!
            </div>
        </div>
    </works>
</div>
@include('site::_partials.footer')



