@extends('admin._layouts.default')

@section('main')

<h1>
    Manage Cart Settings
</h1>
{{ Notification::showAll() }}

<table class="table table-striped">
    <tbody>
        <tr>
            <td>
                <a href="{{URL::route('admin.cart.settings.units.index')}}">Units</a>
            </td>
            <td>
                
            </td>
            <td>
                <a href="#">Date Format and Time Zone</a>
            </td>
        </tr>
        <tr>
            <td>
                <a href="#">Payment Methods</a>
            </td>
            <td>
                <a href="#">General</a>
            </td>
            <td>
                <a href="#">Global Settings</a>
            </td>
        </tr>
    </tbody>
</table>

@stop
