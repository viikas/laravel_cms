@include('site::_partials/header')
<div class="row">
    <div class="large-12 columns">
        @include('site::_partials/breadcrumb')
    </div>
</div>
<div class="row">
    <div class="large-12 columns">
        <h2>{{$item->name}}</h2>
    </div>
</div>

<div class="row">
    <div class="large-12 columns">
        <products>
            <ul class="small-block-grid-2 large-block-grid-3">
                @foreach($collection as $p)
                <li>
                    <div class="price-holder">
                        <a href="{{URL::route('site.product',$p->slug)}}">
                            @if($p->photos()->count()>0)
                            {{HTML::image($p->photos()->first()->photo,'',array('style'=>'width:100%;height:100%;'))}}
                            @else
                            {{HTML::image('http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+photo')}}
                            @endif
                        </a>
                        <div class="product-name">{{$p->name}}</div>
                        <span class="featured-new-price margin-left-10">${{$p->new_price}}</span>
                        @if($p->old_price > $p->new_price)
                        <span class="featured-old-price margin-left-10">${{$p->old_price}}</span>
                        @endif
                        <div class="featured-btn"><a class="btn-vintage" href="{{URL::route('site.product',$p->slug)}}">buy now</a></div>
                    </div>
                </li>
                @endforeach
            </ul>
            @if($collection->count()==0)
            <div>No products yet in this category. Please <a href="{{URL::route('site.home')}}">visit our home page</a>.</div>
            @endif
        </products>
    </div>
</div>	

@include('site::_partials.footer')




