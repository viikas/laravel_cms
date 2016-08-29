@include('site::_partials.headerInner')
@if(!is_null($page))
<h2 align="center">{{$page->title}}</h2>
<br>
<p class="style1">{{$page->body}}</p>
@else
<div class="alert-error width-90-pc">No such page exists.</div>
@endif
<br>

@include('site::_partials.footerInner')