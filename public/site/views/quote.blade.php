@include('site::_partials/header')
<article>
    <div id="content">
        <div id="main">
            <div class="featured-post">
                <div class="post-title">
                    <h2>Get A Quote</h2></div>
                <p>You should fill up the form below and submit to get a free quote. We will send you the quote directly to your email inbox. You will get a quote number which you can use while querying us via phone or email if needed.</p>
                <p style="color:red;">**IMPORTANT** Pickup date and time should be specified in local (Sydney/Australia time zone)</p>
                <div class="post-entry">
                    <div id="quote-wizard">
                        {{Form::open(array('method'=>'post','route'=>'quote.store','id'=>'form1'))}}
                            <table width="542" height="523" border="0" cellpadding="1" cellspacing="1" id="mytable">
                                <tbody>
                                    <tr>
                                        <td colspan="3" class="tdheader">
                                            <div align="center">Get A Free Quote</div></td></tr>
                                    <tr>
                                        <td width="188">Full Name</td>
                                        <td width="14">&nbsp;</td>
                                        <td width="266"><input name="name" type="text" value="" size="30" /></td></tr>
                                    <tr>
                                        <td>Email</td>
                                        <td>&nbsp;</td>
                                        <td><input name="email" type="text" size="30" /></td></tr>
                                    <tr>
                                        <td>Phone</td>
                                        <td>&nbsp;</td>
                                        <td><input name="phone" type="text" size="30" /></td></tr><!-- tr>
                                        <td>Mobile</td>
                                        <td>:</td>
                                        <td><input name="mobile" type="text" size="15" /></td></tr -->
                                    <tr>
                                        <td>Pickup Date</td>
                                        <td>&nbsp;</td>
                                        <td><input id="datetime" name="datetime" type="text" size="2" style="width: 73%;" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Pickup Time</td>
                                        <td>&nbsp;</td>
                                        <td id="td-time-holder">
                                            <table style="width:80%;margin-left: -7px;">
                                                <tr>
                                                    <td style="vertical-align: top;"><input name="datehour" type="text" size="30" style="width:45px;"/></td>
                                                    <td style="vertical-align: top;"><input name="datemin" type="text" size="30" style="width:45px;"/></td>
                                                    <td style="vertical-align: top;">
                                                        <select name="dateampm">
                                                            <option value="AM" selected="selected">AM</option>
                                                            <option value="PM">PM</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Want to return back from destination?</td>
                                        <td>&nbsp;</td>
                                        <td><input type="checkbox" id="return" name="return"/>&nbsp;&nbsp;<label for="return">Yes, I want to return back </label> </td>
                                    </tr>
                                    <tr class="tr-return" style="display:none;">
                                        <td>Return Date</td>
                                        <td>&nbsp;</td>
                                        <td><input id="returndate" name="returndate" type="text" size="2" style="width: 73%;" />
                                        </td>
                                    </tr>
                                    <tr class="tr-return" style="display:none;">
                                        <td>Return Time</td>
                                        <td>&nbsp;</td>
                                        <td id="td-time-holder">
                                            <table style="width:80%;margin-left: -7px;">
                                                <tr>
                                                    <td style="vertical-align: top;"><input name="returnhour" type="text" size="30" style="width:45px;"/></td>
                                                    <td style="vertical-align: top;"><input name="returnmin" type="text" size="30" style="width:45px;"/></td>
                                                    <td style="vertical-align: top;">
                                                        <select name="returnampm">
                                                            <option value="AM" selected="selected">AM</option>
                                                            <option value="PM">PM</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Pick Up Address</td>
                                        <td>&nbsp;</td>
                                        <td><textarea name="source" cols="20" rows="5" id="source"></textarea></td></tr>
                                    <tr>
                                        <td height="41">Destination Address</td>
                                        <td>&nbsp;</td>
                                        <td><textarea name="destination" cols="20" rows="5" id="destination"></textarea></td></tr>
                                    <tr>
                                        <td>No. of adults</td>
                                        <td>&nbsp;</td>
                                        <td><input name="adult" type="text" size="30" style="width:45px;"/></td></tr>
                                    <tr>
                                        <td>No. of baby</td>
                                        <td>&nbsp;</td>
                                        <td><input name="baby" type="text" size="30" style="width:45px;" /></td></tr>
                                    <tr>
                                        <td>Baby age group</td>
                                        <td>&nbsp;</td>
                                        <td>
                                            <select id="babyage" name="babyage" class="text">
                                                <option value="-" selected="selected">--select--</option>
                                                <option value="Upto 3 months">Upto 3 months</option>
                                                <option value="3 to 6 months">3 to 6 months</option>
                                                <option value="6 months to 1 year">6 months to 1 year</option>
                                                <option value="1 to 2 years">1 to 2 years</option>
                                                <option value="Above 2 years">Above 2 years</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>No. of children</td>
                                        <td>&nbsp;</td>
                                        <td><input name="children" type="text" size="30" style="width:45px;"/></td></tr>
                                    <tr>
                                        <td>No. of luggages</td>
                                        <td>&nbsp;</td>
                                        <td><input name="luggage" type="text" size="30" style="width:45px;"/></td></tr>
                                    <tr>
                                        <td>Additional Remarks <br />
                                        <td>&nbsp;</td>
                                        <td><textarea name="remarks" cols="20" rows="5" id="remarks"></textarea></td></tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td><input type="submit" value="submit" /></td></tr>
                                    <tr>
                                        <td colspan="3"></td></tr></tbody></table>
                        
                        {{Form::close()}}<br />
                    </div><!-- xxxxxxxxx --></div></div>
            <div class="clear"></div></div>  </div>

    @include('site::_partials.right')
</article>
<style>
    label.error {
        color: #FF0000;
        display: block;
        font-weight:normal;
        margin: 2px 0 6px;}
    #td-time-holder label.error{display:inline;}
    
</style>
@include('site::_partials/footer')
{{HTML::style('site/assets/css/smoothness/jquery-ui-1.10.4.custom.min.css')}}
{{HTML::script('site/assets/js/jquery-ui-1.10.4.custom.min.js',array("type" => "text/javascript"))}}
<script type="text/javascript">
    $(function(){
        $('#datetime').datepicker();
        $('#returndate').datepicker();
        $('#return').click(function(){
           $('tr.tr-return').toggle(); 
        });
        $('#form1').validate({
                rules:{                        
                    'source':{
                        'required':true
                    },
                    'destination':{
                        'required':true
                    },
                    'datetime':{
                        'required':true,
                        'date':true
                    },
                    'returndate':{
                        'required':true,
                        'date':true
                    },
                    'datehour':{
                        'required':true,
                        'min':1,
                        'max':12
                    },
                    'datemin':{
                        'required':true,
                        'min':0,
                        'max':59
                    },
                    'returnhour':{
                        'required':true,
                        'min':1,
                        'max':12
                    },
                    'returnmin':{
                        'required':true,
                        'min':0,
                        'max':59
                    },
                      
                    'adult':{'required':true,'min':1,'max':20},
                    'children':{'min':0,'max':20},
                    'baby':{'min':0,'max':20},
                    'name':{'required':true},
                    'email':{'required':true,'email':true},
                    'phone':{'required':true}
                },
                messages:{
                    'datehour':"*hour",'datemin':"*minute",'datetime':'*pickup date required','returndate':'*return date required','returnhour':"*hour",'returnmin':"*minute",'source':{'required':'*pickup address required'},'destination':{'required':'* destination address required'},
                    'adult':'*required (min:1, max:20)','children':'*required (min:1, max:20)','baby':'*required (min:1, max:20)','babyage':'*required (min:1, max:5)','baggage':'*required (min:1, max:20)',
                    'name':'*your name required','phone':'*phone/mobile required','email':'*valid email address required'
                }
            }).settings.ignore = ":disabled,:hidden";
        $('#form1').submit(function(){
            return $(this).validate();
            //return false;
        });
    });
</script>