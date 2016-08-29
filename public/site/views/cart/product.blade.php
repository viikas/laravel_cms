@include('site::_partials/header')
<div class="row">
    <div class="large-12 columns">
        @include('site::_partials/breadcrumb')
    </div>
</div>
<div class="row">
    <div class="large-12 columns">
        {{ Notification::showAll() }}
    </div>
</div>

<div class="animated fadeInUp">	
    <works>		
        <div class="row">
            <div class="large-6 columns">
                <social1>
                    <a href="" class="social twitter">t</a>
                    <a href="" class="social facebook">f</a>
                    <a href="" class="social google">g+</a>
                </social1>
                <div class="slideshow-wrapper">
                    <div class="preloader"></div>
                    <ul id="slider" data-orbit data-options="timer_speed:5000;bullets:false;">
                        {{$item->photos()->count()}}
                        @foreach($photos as $p)
                        <li>{{HTML::image($p->photo,'',array('style'=>'width:100%;height:100%;'))}}<div>{{$p->caption}}</div></li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="large-6 columns">
                <h1 class="theme-color">{{$item->name}}</h1>
                <div style="text-align:left;">
                    <span class="featured-new-price number margin-right-20 font-size-26">${{$item->new_price.' USD'}}</span>
                    @if($item->old_price > $item->new_price)
                                        <span class="featured-old-price number margin-right-20 font-size-26">${{$item->old_price.' USD'}}</span>

                    <span class="you-save-amount number">
                        Save <br/> {{\Helper::GetPercentage($item->old_price,$item->new_price).'%'}}
                    </span>

                    @endif
                </div>
                 {{ Form::open(array('route' => array('site.cart.add', $item->slug), 'method' => 'post')) }}
                <p style="margin-top: 15px;">
                    <span class="product-qty">Qty</span>
                    <span>
                        <select id="qty" name="qty" style="width:9%;">
                            @foreach(\Helper::GetQuantities(1,10) as $x)
                            <option value="{{$x}}">{{$x}}</option>
                            @endforeach
                        </select>
                    </span>
                </p>
                <h4>Overview</h4>
                <p>
                    @foreach(\Helper::GetTextArrayByLineFeed($item->summary) as $x)
                <div class="product-summary"><span>&nbsp;</span>{{$x}}</div>
                            @endforeach
                </p>
               

                <input type="submit" value="add to cart" class="btn-vintage"/>
                    {{ Form::close() }}
            </div>
        </div>
    </works>
</div><!-- animation -->


@include('site::_partials.footer')
<script>
    document.write('<script src=' +
        ('__proto__' in {} ? 'site/assets/js/vendor/zepto' : 'site/assets/js/vendor/jquery') +
        '.js><\/script>')
</script>
<script src="site/assets/js/foundation.min.js"></script>
<script>
    $(document).foundation();
</script>
<script>
    window.onload = function() {
        setTimeout(function(){window.scrollTo(0, 1);}, 1);
    }
</script>



