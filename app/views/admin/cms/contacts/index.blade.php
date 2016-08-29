@extends('admin._layouts.default')

@section('main')
@include('admin._partials.cms')
<h1>
    Contacts/Messages
</h1>

<hr>

{{ Notification::showAll() }}

<table class="table table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th>Contact/Message From</th>
            <th>Message</th>
            <th>Received Date</th>
            <th><i class="icon-cog"></i></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($contacts as $c)
        <tr>
            <td>{{ $c->id }}</td>
            <td>{{ $c->name }}<br/><a href="mailto::{{$c->email}}">{{$c->email}}</a><br/>{{ $c->website }}
            </td>
            
            <td>{{$c->message}}</td>
            <td>{{ $c->created_at }}</td>
            <td>
                {{ Form::open(array('route' => array('admin.cms.contacts.destroy', $c->id), 'method' => 'delete', 'data-confirm' => 'Are you sure?')) }}
                <button type="submit" class="btn btn-danger btn-mini">Delete</butfon>
                    {{ Form::close() }}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@stop
