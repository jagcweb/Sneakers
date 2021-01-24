@extends('layouts.app')

@section('title')
My Orders
@endsection


@section('content')
@if(count($orders)>0)
<h1 class="titles2">All your orders</h1>

@if(session('message'))
<p>{{session('message')}}</p>
@endif


@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
<div class="my-orders-filters">
    <form method="GET" action="{{route('order.manage.all')}}" id="buscador">
        <label for="date1">From
            <input type="date" class="mb-2"name="date1"/>
        </label>
        <label for="date2">To
            <input type="date" class="mb-2" name="date2"/>
        </label>

        <input style="height: 40px;"class="btn btn-primary" type="submit" value="Filter"/> 

    </form>
</div>

<div class="my-orders">
    @foreach($orders as $i=>$order)
    <div id="my-orders-cards">
        <span class="font-weight-bold" style="position: absolute;">{{$order->reference}}</span>
        @foreach($order->order_items as $order_item)
        <div class="my-orders-card mx-auto">
            <h2>{{$order_item->product->brand." ".$order_item->product->name}}</h2>
            @foreach($order_item->product->product_images as $i=>$product_images)
            @if($i<1)
            <img class="my-orders-image" src="{{url('product/'.$product_images->image)}}">
            @endif
            @endforeach

        </div>
        @endforeach
        <div class="order-details" style="width:100%;">
            <span class="d-block">Bought on {{$order->date_order}}</span>
            <a href="{{route('order.manage.detail', ['id' => $order->id])}}">See order details</a>
        </div>
    </div>
    @endforeach
</div>
{{$orders->links("pagination::bootstrap-4")}}
@else
<p class="text-center">There is no order yet</p>
@endif
@endsection
