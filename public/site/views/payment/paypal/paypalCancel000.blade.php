@include('site::_partials/headersimple')
<article>
    <div id="content-simple">        
        <div></div>
        <div class="alert alert-error">
            <div id="head">Booking Cancelled</div>
            We saw that you have cancelled your booking process. You can always continue your purchase from your <a href="{{URL::route('site.cart.index')}}">shopping cart</a>.
            Thank you!
        </div>
    </div>
</article>
@include('site::_partials/footer')