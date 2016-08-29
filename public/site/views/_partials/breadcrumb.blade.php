<ul id="bread">
    <li><a href="{{URL::route('site.home')}}">home</a></li>
    @foreach($bread as $b)
        <li><a href="{{$b['url']}}">{{$b['name']}}</a></li>
    @endforeach
</ul>
