@extends('admin._layouts.default')

@section('main')
@include('admin._partials.cart')
<h1>
    Orders
</h1>
{{ Notification::showAll() }}

<table class="table table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th>Title</th>
            <th>Order Date</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($collection as $item)
        <tr>
            <td>{{ $item->id }}</td>
            <td>
                <a href="{{ URL::route('admin.cart.orders.show', $item->id) }}">{{$item->title}}</a>               
            </td>
            <td>
                {{ \Helper::ToDateString($item->order_date,true) }}
            </td>
            <td>
                ${{ number_format($item->tax+$item->shipping_cost+$item->amount,2) }}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@stop
