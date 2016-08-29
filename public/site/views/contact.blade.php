@include('site::_partials.headerInner')
<h2 align="center">{{$page->title}}</h2>
<br/>
{{$page->body}}
<hr/><br/>
<div style="font-weight:bold;">For quick contact, please fill the form below and submit.<br/></div>
{{Form::open(array('method'=>'post','route'=>'site.contact.save','id'=>'form1'))}}
<style>.contact-td-width{width:150px;padding:10px;}</style>
<div style="padding:10px;border:1px solid #333;margin-top:20px;margin-bottom:20px;" with="600px;">
<table style="margin-top:20px;margin-bottom:20px;" cellpadding="5" width="600px">
    <tbody>
        <tr>
            <th colspan="3" class="tdheader">
                <div align="center">Contact Form</div></th></tr>
<tr><td colspan="2">@include('admin._partials.notifications')</td></tr>
        <tr>
            <td class="contact-td-width">Full Name</td>
            <td><input name="name" type="text" value="" size="30" /></td></tr>
        <tr>
            <td class="contact-td-width">Email</td>
            <td><input name="email" type="text" size="30" /></td></tr>
        <tr>
            <td class="contact-td-width">Website <br/>[*optional]</td>
            <td><input name="website" type="text" value="" size="30" /></td></tr>
        <tr>
            <td>Your message<br />(max. 1000 characters)
            <td><textarea name="message" cols="20" rows="5" id="remarks"></textarea></td></tr>
        <tr>
            <td></td>
            <td><input type="submit" value="Submit" style="padding:10px;" />&nbsp;&nbsp;<input style="padding:10px;" type="reset" value="Reset" /></td></tr>
        <tr>
            <td colspan="3"></td></tr></tbody></table></div>

{{Form::close()}}
@include('site::_partials.footerInner')