@include('site::_partials.headerInner')
@if(!is_null($cat))
<h2 align="center">{{$cat->name}}</h2>
<br>
@foreach($items as $q)
<h4><a href="{{URL::route('site.category.details',$q->id)}}">{{$q->title}}</a></span>&nbsp;&nbsp;-&nbsp;&nbsp;{{\Helper::ToTimeZone($q->created_at,true)}}
<p class="style1">{{$q->slug}}&nbsp;&nbsp;&nbsp;<a href="{{URL::route('site.category.details',$q->id)}}">[Read more]</a></p>
<hr/>
@endforeach
@else
<div class="alert-error width-90-pc">No such page exists.</div>
@endif
@include('site::_partials.footerInner')