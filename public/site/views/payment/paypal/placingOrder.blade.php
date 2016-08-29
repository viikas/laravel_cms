@include('site::_partials/header')
<div class="row">
    <div class="large-12 columns"><h2>Placing Order</h2></div>

    <div id="content-simple" style="font-size: 14px;font-family: Arial, Helvetica, sans-serif;text-align: left;"">
        {{Form::open(array('method'=>'post','route'=>'site.cart.checkout.paypal_process','id'=>'form1'))}}
        <div style="margin:20px;font-weight: bold;font-size: 14px;">
            <div style="color:#468847;">We are processing your order. Please keep patience..
                {{HTML::image("/site/assets/icons/working.gif",'',array('style'=>'vertical-align:middle;margin-right:5px;'))}}</div>
        </div>
    </div>
</div>
@include('site::_partials/footer')
<script type="text/javascript" src="{{asset('site/assets/js/jquery.js')}}"></script>
<script type="text/javascript">
    $(function(){
        $('#form1').submit();
    });
    
</script>
