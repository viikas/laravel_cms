@include('site::_partials/header')
<article>
    <div id="content">
        <h1 align="left">Online Booking</h1>
        <div style="font-size:12px;font-family: sans-serif,arial;margin-bottom: 10px;">You can place the booking order by filling up the form below. It is easy and convenient. Only a few steps and you will be guided in each step.</div>
        <div></div>
        {{Form::open(array('method'=>'post','route'=>'booking.store','id'=>'form1'))}}
        <div id="book-wizard">
            <h3>Choose Limousine</h3>
            <fieldset>
                <legend class="lgstep">Choose Limousine
                    <small>Please consider the available number of seats and capacity of luggage while choosing the right limousine for your journey.</small>
                    <small><B>Click in a vehicle below to select it.</B></small>

                </legend>
                @foreach($limousines as $limo)
                <div class="div-limousine-holder">
                    <table>
                        <tr>
                            <td>
                                {{Form::radio('limousine',$limo->id,false,array('id'=>'radio'.$limo->id,'capacity'=>$limo->capacity,'luggage'=>$limo->baggage,'limo'=>$limo->name))}}
                            </td>
                            <td>
                                <label for="{{'radio'.$limo->id}}" title="Click to choose this limousine">
                                    <img src="{{ \Image::resize($limo->photo, 200, 150) }}" alt=""/>
                                    <div class="limo-name-capacity-holder"><div class="div-limousine-name">{{$limo->name}}</div><div class="div-limousine-capacity">No. of seats: {{$limo->capacity}}&nbsp;&nbsp;|&nbsp;&nbsp;Luggage: {{$limo->baggage}}</div></div>
                                </label>
                            </td>
                        </tr>
                    </table>
                </div>
                @endforeach

                <div class="clear"></div>
            </fieldset>
            <h3>Transfer details</h3>
            <fieldset>
                <legend class="lgstep">
                    Transfer details
                    <small>Please specify pickup and destination address. <span style="color:red;font-weight: bold;">IMPORTANT: All date and time should be LOCAL (SYDNEY/AUSTRALIA)</span></small>
                </legend>
                <div class="form-group" data="Type the pickup/destination address">
                    <div style="float:left;margin-right:20px;">  
                        {{Form::label('source','Pickup From')}}
                        <!--{{Form::text('source','',array('class'=>'text-mild source-destination','autocomplete'=>'off'))}}-->
                        <div>
                            <select id="source" name="source" class="text source-destination" style="display:block;">
                                <option value="" selected="selected">--choose pickup address--</option>
                                @foreach($destinations as $dest)
                                <option value="{{$dest->value}}">{{$dest->text}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>                  
                    <div style="float:left;margin-right:20px;">  
                        {{Form::label('destination','Transfer To')}}
                        <div>
                            <select id="destination" name="destination" class="text source-destination" style="display:block;">
                                <option value="" selected="selected">--choose destination address--</option>
                            </select>
                        </div>
                    </div>
                    <div class="clear"></div>
                </div>
                <div class="form-group" data="Provide the detailed address for pickup and transfer locations">
                    <div style="float:left;margin-right:20px;">     
                        {{Form::label('source-address-line-1','Pickup Address Line 1')}}
                        {{Form::text('source-address-line-1','',array('class'=>'text','style'=>'width:170px'))}}
                    </div>
                    <div style="float:left;margin-right:8px;">     
                        {{Form::label('destination-address-line-1','Transfer Address Line 1')}}
                        {{Form::text('destination-address-line-1','',array('class'=>'text','style'=>'width:170px'))}}
                    </div>
                    <div class="clear"></div>
                    <div style="margin-top: 20px;">
                        <div style="float:left;margin-right:20px;">     
                            {{Form::label('source-address-line-2','Pickup Address Line 2')}}
                            {{Form::text('source-address-line-2','',array('class'=>'text','style'=>'width:170px'))}}
                        </div>
                        <div style="float:left;margin-right:8px;">     
                            {{Form::label('destination-address-line-2','Transfer Address Line 2')}}
                            {{Form::text('destination-address-line-2','',array('class'=>'text','style'=>'width:170px'))}}
                        </div>
                    </div>
                    <div class="clear"></div>
                </div>
                <div class="form-group" data="Specify the date and time to pickup">
                    <div style="float:left;margin-right:20px;">     
                        {{Form::label('datetime','Pickup Date (local)')}}
                        {{Form::text('datetime','',array('class'=>'text','style'=>'width:170px'))}}
                    </div>
                    <div style="float:left;margin-right:8px;">     
                        {{Form::label('time-hour','Hour')}}                  
                        {{Form::select('time-hour',$hours,1,array('class'=>'text','style'=>'display:block'))}}
                    </div>
                    <div style="float:left;margin-right:8px;">  
                        {{Form::label('time-min','Minute')}}
                        {{Form::select('time-min',$minutes,0,array('class'=>'text','style'=>'display:block'))}}
                    </div>
                    <div style="float:left;">     
                        {{Form::label('time-ampm','AM/PM')}}
                        {{Form::select('time-ampm',array('AM'=>'AM','PM'=>'PM'),'AM',array('class'=>'text','style'=>'width:60px;display:block;'))}}
                    </div>
                    <div class="clear"></div>
                </div>

                <div class="form-group" data="Check if you want to return back to the pickup address">    
                    {{Form::checkbox('return','1',false,array('class'=>'check','id'=>'return'))}}
                    {{Form::label('return','I will return back to picked up address')}}
                </div>
                <div class="form-group" data="Specify the return date and time" id="return-date-div" style="display:none;">
                    <div style="float:left;margin-right:20px;">     
                        {{Form::label('returndate','Return Date (local)')}}
                        {{Form::text('returndate','',array('class'=>'text','style'=>'width:170px'))}}
                    </div>
                    <div style="float:left;margin-right:8px;">     
                        {{Form::label('time-hour-return','Hour')}}                  
                        {{Form::select('time-hour-return',$hours,1,array('class'=>'text','style'=>'display:block'))}}
                    </div>
                    <div style="float:left;margin-right:8px;">  
                        {{Form::label('time-min-return','Minute')}}
                        {{Form::select('time-min-return',$minutes,0,array('class'=>'text','style'=>'display:block'))}}
                    </div>
                    <div style="float:left;">     
                        {{Form::label('time-ampm-return','AM/PM')}}
                        {{Form::select('time-ampm-return',array('AM'=>'AM','PM'=>'PM'),'AM',array('class'=>'text','style'=>'width:60px;display:block;'))}}
                    </div>
                    <div class="clear"></div>
                </div>
            </fieldset>
            <h3>Personal Info</h3>
            <fieldset>
                <legend class="lgstep">
                    Personal Info
                    <small>Please provide your personal information</small></legend>
                <div class="form-group" data="Type your first and last name">
                    <div style="float:left;margin-right:20px;">  
                        {{Form::label('fname','First name')}}
                        {{Form::text('fname','',array('class'=>'text-mild'))}}
                    </div>                  
                    <div style="float:left;margin-right:20px;">  
                        {{Form::label('lname','Last name')}}
                        {{Form::text('lname','',array('class'=>'text-mild'))}}
                    </div>
                    <div class="clear"></div>
                </div>
                <div class="form-group" data="Type your valid email address and phone/mobile number">
                    <div style="float:left;margin-right:20px;">  
                        {{Form::label('email','Email')}}
                        {{Form::text('email','',array('class'=>'text-mild'))}}
                    </div>                  
                    <div style="float:left;margin-right:20px;">  
                        {{Form::label('phone','Phone')}}
                        {{Form::text('phone','',array('class'=>'text-mild'))}}
                    </div>
                    <div class="clear"></div>
                </div>
                <div class="form-group" data="Type your city/country name">
                    <div style="float:left;margin-right:20px;">  
                        {{Form::label('city','City')}}
                        {{Form::text('city','',array('class'=>'text-mild'))}}
                    </div>                  
                    <div style="float:left;margin-right:20px;">  
                        {{Form::label('country','Country')}}
                        {{Form::text('country','',array('class'=>'text-mild'))}}
                    </div>
                    <div class="clear"></div>
                </div>
            </fieldset>
            <h3>Passenger details</h3>
            <fieldset>
                <legend class="lgstep">
                    Passenger details
                    <small>Please fill up the information of the passengers</small>
                </legend>
                <div class="form-group" data="Type the total number of adults/children">
                    <div style="float:left;margin-right:20px;">  
                        {{Form::label('adult','No. of adults')}}
                        {{Form::text('adult','0',array('class'=>'text-mild'))}}
                    </div>                  
                    <div style="float:left;margin-right:20px;">  
                        {{Form::label('children','No. of children')}}
                        {{Form::text('children','0',array('class'=>'text-mild'))}}
                    </div>
                    <div class="clear"></div>                    
                </div>
                <div class="form-group" data="Type the total number of babies and their age group">
                    <div style="float:left;margin-right:20px;">  
                        {{Form::label('baby','No. of babies')}}
                        {{Form::text('baby','0',array('class'=>'text-mild'))}}
                    </div>                  
                    <div style="float:left;margin-right:20px;">  
                        {{Form::label('babyage','Baby age group')}}
                        <div>
                            <select id="babyage" name="babyage" class="text">
                                <option value="-" selected="selected">--select--</option>
                                <option value="Upto 3 months">Upto 3 months</option>
                                <option value="3 to 6 months">3 to 6 months</option>
                                <option value="6 months to 1 year">6 months to 1 year</option>
                                <option value="1 to 2 years">1 to 2 years</option>
                                <option value="Above 2 years">Above 2 years</option>
                            </select>
                        </div>
                    </div>
                    <div class="clear"></div>                    

                </div>
                <div class="form-group" data="Type the total number of baggages">
                    {{Form::label('baggage','No. of baggages')}}
                    {{Form::text('baggage','0',array('class'=>'text-mild'))}}
                </div>
            </fieldset>

            <h3>Flight details</h3>
            <fieldset>
                <legend class="lgstep">
                    Flight Info
                    <small>If you are taking a flight to Sydney, please provide us your flight information
                    </small>
                </legend>
                <div class="form-group" data="Specify the airport you will land at">
                    {{Form::label('airport','Airport')}}
                    {{Form::text('airport','',array('class'=>'text'))}}
                </div>
                <div class="form-group" data="Specify the airline you will travel by">
                    {{Form::label('airline','Airline')}}
                    {{Form::text('airline','',array('class'=>'text'))}}
                </div>
                <div class="form-group" data="Specify the flight number">
                    {{Form::label('flight','Flight No.')}}
                    {{Form::text('flight','',array('class'=>'text'))}}
                </div>
                <div class="form-group" data="Check the box if you agree with the terms and conditions ">
                    <hr>
                    <input type="checkbox" id="terms" name="terms">
                    <label for="terms">I agree with the <a href="{{URL::route('terms-and-conditions')}}" style="color:blue;">terms and conditions</a> of this company's service</label>
                    <div>By checking the box above you agree with our terms and conditions. So please read the terms and conditions carefully before you proceed submitting the form.</div>
                </div>
            </fieldset>            
        </div>
        {{Form::hidden('hiddenSID','0',array('id'=>'hiddenSID'))}}
        {{Form::hidden('hiddenDID','0',array('id'=>'hiddenDID'))}}
        {{Form::hidden('hidden-dest',$destinations)}}
        {{Form::hidden('hidden-return','false',array('id'=>'hidden-return'))}}
        {{Form::close()}}
        <div id="div-summary" class="easymodel" style="display:none;">
            <div class="header"><h3>Booking Summary</h3></div>
            <div class="content">
                <div class="info">IMPORTANT : Please review your booking details. If this is correct, please click Proceed to Pay button.<br/> If you need to edit the information, click Cancel button and update your information.</div>
                <div class="container">
                    <table id="tbl-summary">
                        <tr><th colspan="4" style="padding-top: 0px;">TRANSFER DETAILS</th></tr>
                        <tr class="row">
                            <td class="bold">Vehicle:</td>
                            <td colspan="3" id="sum-vehicle"></td>
                        </tr>
                        <tr class="row">
                            <td class="bold">Pickup from:</td>
                            <td id="sum-pickup"></td>
                            <td class="bold2">Pickup address:</td>
                            <td id="sum-pickup-address"></td>
                        </tr>
                        <tr class="row">
                            <td class="bold">Transfer to:</td>
                            <td id="sum-transfer"></td>
                            <td class="bold2">Transfer address:</td>
                            <td id="sum-transfer-address"></td>
                        </tr>
                        <tr class="row">
                            <td class="bold">Pickup date:</td>
                            <td id="sum-pickup-date"></td>
                            <td class="bold2">Pickup time:</td>
                            <td id="sum-pickup-time"></td>
                        </tr>
                        <tr class="row" id="tr-return">
                            <td class="bold">Return date:</td>
                            <td id="sum-return-date"></td>
                            <td class="bold2">Return time:</td>
                            <td id="sum-return-time"></td>
                        </tr>
                        <tr><th colspan="4">PERSONAL INFO</th></tr>
                        <tr class="row">
                            <td class="bold">First name:</td>
                            <td id="sum-fname"></td>
                            <td class="bold2">Last name:</td>
                            <td id="sum-lname"></td>
                        </tr>
                        <tr class="row">
                            <td class="bold">Email:</td>
                            <td id="sum-email"></td>
                            <td class="bold2">Phone:</td>
                            <td id="sum-phone"></td>
                        </tr>
                        <tr class="row">
                            <td class="bold">City:</td>
                            <td id="sum-city"></td>
                            <td class="bold2">Country:</td>
                            <td id="sum-country"></td>
                        </tr>
                        <tr><th colspan="4">PASSENGER DETAILS</th></tr>
                        <tr class="row">
                            <td class="bold">No. of. Adult:</td>
                            <td id="sum-adult"></td>
                            <td class="bold2">No. of children:</td>
                            <td id="sum-children"></td>
                        </tr>
                        <tr class="row">
                            <td class="bold">No. of baby:</td>
                            <td id="sum-baby"></td>
                            <td class="bold2">Baby age group:</td>
                            <td id="sum-babyage"></td>
                        </tr>
                        <tr class="row">
                            <td class="bold">No. of luggage:</td>
                            <td colspan="3" id="sum-luggage"></td>
                        </tr>
                        <tr><th colspan="4">FLIGHT DETAILS</th></tr>
                        <tr class="row">
                            <td class="bold">Airport:</td>
                            <td id="sum-airport"></td>
                            <td class="bold2">Airline:</td>
                            <td id="sum-airline"></td>
                        </tr>
                        <tr class="row">
                            <td class="bold">Flight No.:</td>
                            <td colspan="3" id="sum-flight"></td>
                        </tr>
                    </table>                    
                </div>
                <div class="div-action-buttons">
                    <div class="btns">
                    <a style="width:82px;color:#fff;float: left;margin-right:15px;" id="a-pay-now" class="step-like" href="javascript:void(0);">Proceed to Pay</a>
                            <a style="width:40px;color:#111;float:left;" id="a-cancel-now" class="step-like-cancel" href="javascript:void(0);">Cancel</a>
                            </div>
                    <div class="proceed">
                        {{HTML::image("/site/assets/icons/working.gif",'',array('style'=>'vertical-align:middle;margin-right:5px;'))}}working.. please wait..
                    </div>
                </div>
            </div>

        </div>
</article>
@include('site::_partials/footer')

{{HTML::style('site/assets/css/jquery.steps.css')}}
{{HTML::style('site/assets/css/smoothness/jquery-ui-1.10.4.custom.min.css')}}

{{HTML::script('site/assets/js/jquery-ui-1.10.4.custom.min.js',array("type" => "text/javascript"))}}
{{HTML::script('site/assets/js/JSLINQ.js',array("type" => "text/javascript"))}}
{{HTML::script('site/assets/js/jquery.steps.min.js',array("type" => "text/javascript"))}}
{{HTML::script('site/assets/js/jquery.easyModal.js',array("type" => "text/javascript"))}}

<script type="text/javascript">
    
    var destinations=JSON.parse($('input[name=hidden-dest]').val());
    
    $(function(){
        jQuery.validator.addMethod("notEqual", function(value, element, param) {
            return this.optional(element) || value != $(param).val()
        }, "Please specify a different value");
        jQuery.validator.addMethod("requiredEx", function(value, element, param) {
            return value != '';
        }, "Please specify a different value");
        $('#book-wizard').steps({
            headerTag: "h3",
            bodyTag: "fieldset",
            onStepChanging: function (event, currentIndex, newIndex)
            {
                $('#form1').validate({
                    rules:{                        
                        //first step
                        'source':{
                            'required':true,
                            'notEqual':$('#destination').val()
                        },
                        'destination':{
                            'required':true,
                            'notEqual':'#source'
                        },
                        'datetime':{
                            'required':true,
                            'date':true
                        },
                        'returndate':{
                            'required':true,
                            'date':true
                        },
                        'time-hour':{
                            'required':true,
                            'min':1,
                            'max':12
                        },
                        'time-min':{
                            'required':true
                        },
                        'time-hour-return':{
                            'required':true
                        },
                        'time-min-return':{
                            'required':true
                        },
                        //second step
                      
                        'adult':{'required':true,'min':1,'max':20},
                        'children':{'required':true,'min':0,'max':20},
                        'baby':{'required':true,'min':0,'max':20},
                        'babyage':{'required':true},
                        'baggage':{'required':true,'min':0,'max':20},
                        //third step
                        'fname':{'required':true},
                        'lname':{'required':true},
                        'email':{'required':true,'email':true},
                        'phone':{'required':true},
                        'city':{'required':true},
                        'country':{'required':true},
                         
                        //fourth step
                        'limousine':{'required':true},
                         
                        'terms':{'required':true}
                    },
                    messages:{
                        'time-hour':"*required",'time-min':"*required",'datetime':'*pickup date required','returndate':'*return date required','time-hour-return':"*required",'time-min-return':"*required",'source':{'required':'*source address required','notEqual':'*must be other than destination address'},'destination':{'required':'* destination address required','notEqual':'*must be other than pickup address'},
                        'adult':'*required (min:1, max:20)','children':'*required (min:1, max:20)','baby':'*required (min:1, max:20)','babyage':'*required (min:1, max:5)','baggage':'*required (min:1, max:20)',
                        'fname':'*first name required','lname':'*last name required','phone':'*phone/mobile required','email':'*valid email address required','city':'*city\'s name required','country':'*country name required',
                        'limousine':'*limousine required','terms':'*you should agree before submitting the form'
                    }
                }).settings.ignore = ":disabled,:hidden";
                var v1=$("#form1").valid();
                return v1;
            },
            onFinishing: function (event, currentIndex)
            {
                $(this).validate().settings.ignore = ":disabled";
                return $('#form1').valid();
            },
            onFinished: function (event, currentIndex)
            {
                //var source_id='';
                //var dest_id='';
                //var x=JSLINQ(destinations);
                //source_id=x.Where(function(item){ return item.text == $('#source').val(); }).Select(function(item){ return item.value; }).ToArray()
                //dest_id=x.Where(function(item){ return item.text == $('#destination').val(); }).Select(function(item){ return item.value; }).ToArray()
                $('#hiddenSID').val($('#source').val());
                $('#hiddenDID').val($('#destination').val());
                //if(confirm('You will be redirected to the payment page. Click OK to continue. If you want to edit the information, click Cancel.'))
                //$('#form1').submit();
                getSummary();                 
                $('#div-summary').trigger('openModal');
                
                //alert('Thank you for filling the form. We are working with payment integration..');
            }
        });
        
        $('#a-pay-now').click(function(){
            $('tr#tr-action-buttons').html('<td><b>Proceeding to pay.. please wait..</b></td>');
            $('div.btns').remove();
            $('div.proceed').show();
            $('#form1').submit();
        });    
        $('#a-cancel-now').click(function(){
            $('#div-summary').trigger('closeModal');
        });
        
        $('#div-summary').easyModal({
            top: 50,
            autoOpen: false,
            overlayOpacity: 0.3,
            overlayColor: "#333",
            overlayClose: false,
            closeOnEscape: false
        });
        
        $('select#source').change(function(){
            updateSourceDestination();
            costify();
        });
        $('div.form-group').mouseenter(function(){
            var data=$(this).attr('data'); 
            var h='<div class="hover-data">'+data+'</div>';
            $(this).addClass('focus-data');
            $(this).after(h);
        }).mouseleave(function(){
            $('div.hover-data').remove();
            $(this).removeClass('focus-data');
        });
        
        $('#datetime').datepicker();
        $('#returndate').datepicker();
        $('#datetime').change(function(){
            $('#returndate').val($(this).val());
        });
        $('input[name=return]').change(function(){
            $('#return-date-div').toggle();
            $('#hidden-return').val($(this).is(':checked'));
            costify();
        });
        $('input[name=limousine]').change(function(){
            costify();
        });
        
        $('#destination').change(function(){
            costify(); 
        });
        
        $('div.div-limo-feature').each(function(){
            var data=$(this).text();
            $(this).html(getFeatures(data));
        });
        
    $('input:radio[name=limousine]:first').attr('checked',true);
        
    });
    var sid='';
    var did='';    
    var bp=0.00;
    var tax=7.00;
    
    function getRandomArbitrary(min, max) {
        return Math.random() * (max - min) + min;
    }
    
    function costify()
    {         
        var limousine=$('#limousine').val();                
        var source=$('#source').val();
        var destination=$('#destination').val();
        if(source=='' || destination=='' || source==destination || limousine=='')
        {            
            setCost(0.00,0.00,0.00);
            return;
        }
        
        var pf=parseFloat($('#limousine').find('option:selected').attr('price-factor'));
        var bp=getBasePrice();    
            
        var cost=(pf/100*bp+bp).toFixed(2);
        var tax_cost=(cost*tax/100).toFixed(2);
        var total=(parseFloat(cost) + parseFloat(tax_cost)).toFixed(2);
        setCost(cost,tax_cost,total);
    }
    
    function getBasePrice()
    {
        var source=$('#source').find('option:selected').text();
        var destination=$('#destination').find('option:selected').text();
        var bp=0.00;
        var isCBD=source.indexOf('CBD')>-1;
        var isDOM=source.indexOf('Sydney Airport')>-1;
        var isINT=source.indexOf('Sydney Int. Airport')>-1;
        if(isCBD || isDOM  || isINT)
        {
            var x=JSLINQ(destinations);
            var y=x.Where(function(item){ return item.text == destination; })
            //.OrderBy(function(item) { return item.FirstName; })
            if(isCBD)
                bp=y.Select(function(item){ return item.price_cbd; }).ToArray();
            else if(isDOM)
                bp=y.Select(function(item){ return item.price_dom; }).ToArray();
            else
                bp=y.Select(function(item){ return item.price_int; }).ToArray();
        }
        else
        {
            var isCBDX=destination.indexOf('CBD')>-1;
            var isDOMX=destination.indexOf('Sydney Airport')>-1;
            var isINTX=destination.indexOf('Sydney Int. Airport')>-1;   
        
            var x=JSLINQ(destinations);
            var y=x.Where(function(item){ return item.text == source; })
            //.OrderBy(function(item) { return item.FirstName; })
            if(isCBDX)
                bp=y.Select(function(item){ return item.price_cbd; }).ToArray();
            else if(isDOMX)
                bp=y.Select(function(item){ return item.price_dom; }).ToArray();
            else
                bp=y.Select(function(item){ return item.price_int; }).ToArray();
        }
        return parseFloat(bp);
    }

    function isSuburb(sourceID)
    {
        var source=$('#'+sourceID).find('option:selected').text();
        var isCBD=source.indexOf('CBD')>-1;
        var isDOM=source.indexOf('Sydney Airport')>-1;
        var isINT=source.indexOf('Sydney Int. Airport')>-1;
        var test=(isCBD || isDOM || isINT);
        if(test==true)
            return false;
        else
        {
            var linq=JSLINQ(destinations);
            var sub=linq.Where(function(item){ return item.text ==source }).ToArray();
            if(sub=='')
                return false;
            else
                return true;
        }
    }
    
    function setCost(cost,tax,total)
    {
        var isReturn=$("#hidden-return").val();
        if(isReturn=='true')
        {
            total=total*2;
            cost=cost*2;
            tax=tax*2;
        }
        $('#cost').val(cost);
        $('#tax').val(tax);
        $('#total').val(total);
    }
    
    function getFeatures(data)
    {
        if(data.length==0) return "";
        var arr=data.split(";");
        var all='<ul>';
        
        for (var i = 0; i < arr.length; i++) 
        {
            all+='<li>'+arr[i]+'</li>';
        }
        all+='</ul>';
        return all;
    }
    
    function updateSourceDestination()
    {
        var suburb=isSuburb('source');
        var dest_new='';
        var linq=JSLINQ(destinations);
        if(suburb==true)
        {                
            dest_new=linq.Where(function(item){ return (item.type=='cbd' || item.type=='dom' || item.type=='int') }).ToArray();
            $('#destination').empty();
            $('#destination').append('<option value="">--choose destination address</option>');
            $.each(dest_new,function(index, element) 
            {                
                $('#destination').append('<option value=' + element.value + '>' + element.text + '</option>');
            });
        }
        else
        {
            dest_new=linq.Where(function(item){ return (item.type=='cbd' || item.type=='dom' || item.type=='int' || item.type=='suburb') }).ToArray();
            $('#destination').empty();
            $('#destination').append('<option value="">--choose destination address</option>');
            $.each(dest_new,function(index, element) 
            {                
                $('#destination').append('<option value=' + element.value + '>' + element.text + '</option>');
            });
        }     
    }
    
    function getSummary()
    {
        //transfer details
        var vehicle=$('input[name=limousine]:radio:checked');
        var capacity=$(vehicle).attr('capacity');
        var luggage=$(vehicle).attr('luggage');
        var limoName=$(vehicle).attr('limo');
        $('#sum-vehicle').text(limoName+'[Seat capacity: '+capacity+', Luggage capacity: '+luggage+' ]');
        $('#sum-pickup').text($('#source').find('option:selected').text());
        $('#sum-pickup-address').text($('#source-address-line-2').val()+', '+$('#source-address-line-1').val());
        $('#sum-transfer').text($('#destination').find('option:selected').text());
        $('#sum-transfer-address').text($('#destination-address-line-2').val()+', '+$('#destination-address-line-1').val());
        $('#sum-pickup-date').text($('#datetime').val());
        $('#sum-pickup-time').text($('#time-hour').val()+':'+$('#time-min').val()+' '+$('#time-ampm').val());
        
        var _return=$('#return').prop('checked');
        if(_return==true)
        {
            $('#sum-return-date').text($('#returndate').val());
            $('#sum-return-time').text($('#time-hour-return').val()+':'+$('#time-min-return').val()+' '+$('#time-ampm-return').val());
        }
        
        //perosnal details
        $('#sum-fname').text($('#fname').val());
        $('#sum-lname').text($('#lname').val());
        $('#sum-email').text($('#email').val());
        $('#sum-phone').text($('#phone').val());
        $('#sum-city').text($('#city').val());
        $('#sum-country').text($('#country').val());
        
        //passenger details
        $('#sum-adult').text($('#adult').val());
        $('#sum-children').text($('#children').val());
        $('#sum-baby').text($('#baby').val());
        $('#sum-babyage').text($('#babyage').val());
        $('#sum-luggage').text($('#baggage').val());
        
        //flight details
        $('#sum-airport').text($('#airport').val());
        $('#sum-airline').text($('#airline').val());
        $('#sum-flight').text($('#flight').val());
        
        $('table#tbl-summary tr td').each(function(){
            if($(this).text()=='')
            {
                $(this).text('-');
            }
        });
    }
</script>