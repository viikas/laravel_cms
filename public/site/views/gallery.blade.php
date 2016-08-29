@include('site::_partials.headerInner')
<h2 align="center">Photo Gallery</h2>
<br/>
@foreach($items as $gal)
<div style="padding:10px; border:1px solid #ddd;width:170px;height:150px;float:left;">
    <a href="{{URL::route('site.gallery.album',$gal->id)}}">
        @if($gal->image)
        <img src="<?php echo Image::resize($gal->image, 200, 120); ?>" alt="{{$gal->name}}" style="border:5px solid #333;">
        @else
        <img src="http://www.placehold.it/170x120/EFEFEF/AAAAAA&amp;text=no+image">
        @endif
    </a>
    <br/><a href="{{URL::route('site.gallery.album',$gal->id)}}">{{$gal->name}}</a>&nbsp;({{$gal->photos()->count()}} photos)
</div>

@endforeach
<div style="clear:both;"></div>
@include('site::_partials.footerInner')