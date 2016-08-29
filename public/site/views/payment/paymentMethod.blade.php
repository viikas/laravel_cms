@include('site::_partials/headersimple')
<article>
    <div id="content-simple" style="font-size: 14px;font-family: Arial, Helvetica, sans-serif;">
        <h1 align="left">Choose Payment Method</h1>
        <p>You have successfully submitted the booking form. You are now only one step away from placing the booking order. Please review the payment details and choose from the available payment methods to place the order.</p>
        {{Form::open(array('method'=>'post','url'=>'booking/paystore','id'=>'form1'))}}
        <div id="book-wizard" style="padding-left: 15px;background-color:#eee;">
            <fieldset>
                <legend class="lgstep">Payment Details
                </legend>
                <div class="form-group">
                    <table class="payment-summary">
                        <tr>
                            <td class="pay-head">{{$source.'  to  '.$destination}} :</td>
                            <td class="pay-price">${{$cost.' '.$currency}}</td>
                        </tr>
                        @if($return=='true')
                        <tr>
                            <td class="pay-head">{{'Return from '.$destination.'  to  '.$source}} :</td>
                            <td class="pay-price">${{$cost.' '.$currency}}</td>
                        </tr>
                        @endif
                        <tr>
                            <td class="pay-head">Tax :</td>
                            <td class="pay-price">${{$tax.' '.$currency}}</td>
                        </tr>
                        <tr>
                            <td class="pay-head">Total :</td>
                            <td class="pay-price" style="color:red;font-weight: bold;">${{$total.' '.$currency}}</td>
                        </tr>
                    </table>
                </div>
            </fieldset>
            <fieldset>
                <legend class="lgstep">Payment Method
                </legend>
                <div class="form-group">
                    <p style="text-align: left;">
                        {{Form::radio('paymethod','bank',true,array('class'=>'inline','id'=>'bank'))}}
                        <label for="bank">{{HTML::image('site/assets/icons/australian-bank.png','Securely Pay with Australian Bank',array('style'=>'vertical-align:middle;'))}}</label>
                    </p>
                    <p style="text-align: left;">
                        {{Form::radio('paymethod','paypal',false,array('class'=>'inline','id'=>'paypal'))}}
                        <label for="paypal">{{HTML::image('site/assets/icons/paypal.gif','Pay with PayPal - Secured',array('style'=>'vertical-align:middle;'))}}</label>
                    </p>
                </div>                
            </fieldset>            
        </div>
        <div class="clear"></div>
        <div style="margin:10px 60px 10px 0" id="div-pay-btns">
            <a id="a-cancel-now" style="color:#fff;font-size:12px;float:right;" class="step-like" data="cancel" href="javascript:void(0);" class="btn btn-large">Cancel</a> 
            <a style="color:#fff;font-size:12px;float:right;margin-right: 10px;" class="step-like" id="a-pay-now" href="javascript:void(0);">Pay Now</a>                    
            <div class="clear"></div>
        </div>
        <div style="margin:10px 60px 10px 0;display: none;text-align: right;font-weight: bold;font-size: 13px;color: #159ffd;" id="working-wait">
                {{HTML::image("/site/assets/icons/working.gif",'',array('style'=>'vertical-align:middle;margin-right:5px;'))}}Redirecting you to secure payment.. please wait...
        </div>
        {{Form::close()}}
    </div>
</article>
@include('site::_partials/footer')
<script type="text/javascript" src="{{asset('site/assets/js/jquery.js')}}"></script>
{{HTML::style('site/assets/css/jquery.steps.css')}}

{{HTML::script('site/assets/js/jquery.steps.min.js',array("type" => "text/javascript"))}}
<script type="text/javascript">
    $(function(){
        $('a#a-pay-now').on('click',function(){
            $('div#div-pay-btns').hide();
            $('div#working-wait').show();
            $('#form1').submit();
        });
        $('a#a-cancel-now').on('click',function(){
            if(confirm('You are going to cancel the booking process. Are you sure?'))
            {
                window.location.href=$(this).attr('data');
            }
        });
    });
</script>
