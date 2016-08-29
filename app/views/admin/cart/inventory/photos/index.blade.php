@extends('admin._layouts.default')

@section('main')
@include('admin._partials.cart')
<h1>
    <i>Photos:</i> {{$item->name}} <a href="{{ URL::route('admin.cart.inventory.products.photos.create',$item->id) }}" class="btn btn-success"><i class="icon-plus-sign"></i> Add New</a>
</h1>
@include('admin._partials.notifications')
<hr>
<table class="table table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th>Photo</th>
            <th>Caption</th>
            <th>Sort</th>
            <th><i class="icon-cog"></i></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($photos as $index=>$p)
        <tr>
            <td>{{ $p->id }}</td>
            <td>
                <img class="thumb-image" data-id="full-image-{{$p->id}}" src="{{Image::resize($p->photo,120,120)}}" alt="Click to see full size"/>

                <div style="overflow:scroll;display:none;width:650px;height:450px;border:3px solid #333;padding:3px;background-color: #ddd;" id="full-image-{{$p->id}}">
                    <img src="{{URL::to($p->photo)}}"/>
                </div>
            </td>
            <td>
                {{$p->caption}}
            </td>
            <td>               
                @if($index>0)    
                {{ Form::open(array('route' => array('admin.cart.inventory.products.photos.sortUp', $item->id,$p->id), 'method' => 'post')) }}
                <button type="submit" style="height:26px;">Move Up</butfon>
                    {{ Form::close() }}
                @endif
                @if($index+1 < count($photos))
                    {{ Form::open(array('route' => array('admin.cart.inventory.products.photos.sortDown', $item->id,$p->id), 'method' => 'post')) }}
                <button type="submit" style="height:26px;">Move Down</butfon>
                    {{ Form::close() }}
                @endif
            </td><td>
                <a href="{{URL::action('App\Controllers\Admin\Cart\ProductsController@editphoto',[$item->id,$p->id])}}" class="btn btn-success btn-mini pull-left">edit</a>
                {{ Form::open(array('route' => array('admin.cart.inventory.products.photos.remove', $item->id,$p->id), 'method' => 'post', 'data-confirm' => 'Are you sure?')) }}

                <button type="submit" class="btn btn-danger btn-mini">Delete</butfon>
                    {{ Form::close() }}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
<script src="{{ URL::asset('assets/js/jquery.lightbox_me.js') }}"></script>
<script type="text/javascript">
    $(function(){
        $(".thumb-image").click(function(e){
            var content_id=$(this).attr('data-id');
            $('#'+content_id).lightbox_me(
            {
                centered: true, 
                zIndex:10000,
                onLoad: function() { 
                    //$('#sign_up').find('input:first').focus()
                }
            });
            e.preventDefault();
        });
    });

</script>
@stop
