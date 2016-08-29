@extends('admin._layouts.default')

@section('main')
@include('admin._partials.cms')
<h1>
    Photos in<i> {{$gal->name}}</i> <a href="{{ URL::route('admin.cms.gallery.photos.create',$gal->id) }}" class="btn btn-success"><i class="icon-plus-sign"></i> Add new photo</a> <a href="{{ URL::route('admin.cms.gallery.index') }}" class="btn btn-success"><i class="icon-plus-sign"></i> Back to Gallery</a>
</h1>

<hr>

{{ Notification::showAll() }}

<table class="table table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th>Photo</th>
            <th>Caption</th>
            <th>When</th>
            <th><i class="icon-cog"></i></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($gal->photos as $p)
        <tr>
            <td>{{$p->id }}</td>
            <td>
                <div class="fileupload fileupload-new" data-provides="fileupload">
                    <div class="fileupload-preview thumbnail" style="width: 120px; height: 80px;">
                        <a href="<?php echo $gal->p; ?>"><img src="<?php echo Image::resize($p->image, 120, 80); ?>" alt=""></a>
                    </div>
                </div>
            </td>
            <td>{{$p->caption}}</td>
            <td>{{ $gal->created_at }}</td>
        <td>
            <a href="{{URL::action('App\Controllers\Admin\cms\GalleryController@edit_photo',[$gal->id,$p->id])}}" class="btn btn-success btn-mini pull-left">Edit</a>

                {{ Form::open(array('route' => array('admin.cms.gallery.photos.destroy',$gal->id, $p->id), 'method' => 'delete', 'data-confirm' => 'Are you sure?')) }}
                <button type="submit" class="btn btn-danger btn-mini">Delete</butfon>
                    {{ Form::close() }}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@stop
