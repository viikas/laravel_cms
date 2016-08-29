@include('site::_partials.headerInner')
@if(is_null($gal))
<div class="alert-error width-90-pc">No such page exists.</div>
@else
<h2 align="center">{{$gal->name}}</h2>
<br/>
<div class="pretty-gallery">
    @foreach($items as $p)
    <div style="padding:10px; border:1px solid #ddd;width:170px;height:150px;float:left;">

        <a href="{{URL::to($p->image)}}" rel="prettyPhoto[pp_gal]" title="{{$p->caption}}">
            @if($p->image)
            <img src="<?php echo Image::resize($p->image, 200, 120); ?>" alt="{{$p->name}}" style="border:5px solid #333;">        
            @else
            <img src="http://www.placehold.it/170x120/EFEFEF/AAAAAA&amp;text=no+image">
            @endif
        </a>
    </div>
    @endforeach
    <div style="clear:both;"></div>
</div>

{{HTML::style('site/assets/prettyPhoto/css/prettyPhoto.css')}}
{{HTML::script('site/assets/prettyPhoto/jquery.prettyPhoto.js',array("type" => "text/javascript"))}}
<script type="text/javascript">
    $(function () {
        $(".pretty-gallery a").prettyPhoto();
    });
</script>
@endif
@include('site::_partials.footerInner')