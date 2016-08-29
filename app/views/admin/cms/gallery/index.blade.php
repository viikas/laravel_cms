@extends('admin._layouts.default')

@section('main')
@include('admin._partials.cms')
<h1>
    Photo Gallery <a href="{{ URL::route('admin.cms.gallery.create') }}" class="btn btn-success"><i class="icon-plus-sign"></i> Add new gallery</a>
</h1>

<hr>

{{ Notification::showAll() }}

<table class="table table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th>Album Cover Photo</th>
            <th>Album Name</th>
            <th>When</th>
            <th>Published</th>
            <th><i class="icon-cog"></i></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($gallery as $gal)
        <tr>
            <td>{{$gal->id }}</td>
            <td>
                <div class="fileupload fileupload-new" data-provides="fileupload">
                    <div class="fileupload-preview thumbnail" style="width: 100px; height: 75px;">
                        @if ($gal->image)
                        <a href="<?php echo $gal->image; ?>"><img src="<?php echo Image::resize($gal->image, 100, 75); ?>" alt=""></a>
                        @else
                        <img src="http://www.placehold.it/100x75/EFEFEF/AAAAAA&amp;text=no+image">
                        @endif
                    </div>
                </div>
            </td>
            <td>{{$gal->name}}<br/>[<a href="{{URL::route('admin.cms.gallery.photos',$gal->id)}}">{{$gal->photos()->count()}} photo(s)</a>]</td>
            <td>{{ $gal->created_at }}</td>
            <td>
                <span class="product-available product-available-{{$gal->is_published}}" title="{{$gal->is_published==0 ? 'not published' : 'published'}}">&nbsp;</span>
            </td>
            <td>
                <a href="{{ URL::route('admin.cms.gallery.edit', $gal->id) }}" class="btn btn-success btn-mini pull-left">Edit</a>

                {{ Form::open(array('route' => array('admin.cms.gallery.destroy', $gal->id), 'method' => 'delete', 'data-confirm' => 'Are you sure?')) }}
                <button type="submit" class="btn btn-danger btn-mini">Delete</butfon>
                    {{ Form::close() }}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@stop
