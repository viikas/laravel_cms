@include('site::_partials.headerInner')
@if(!is_null($item))
<h2 align="center">{{$item->title}}</h2>
<h4 align="left">{{\Helper::ToTimeZone($item->created_at,true)}}</h4>
<br/>
{{$item->body}}
<hr/>
@else
<div class="alert-error width-90-pc">No such page exists.</div>
@endif
@include('site::_partials.footerInner')