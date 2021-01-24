@extends('layouts.app')

@section('title')
Order Detail
@endsection


@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if(session('message'))
            <p>{{session('message')}}</p>
            @endif
            @if(count($orders)>0)
            @foreach($orders as $order)
            @if($order->user_id == \Auth::user()->id)
            @if($order->user->role == 'admin')
            <a href="{{route('order.manage.edit', ['id' => $order->id])}}" class="text-secondary mr-3">Editar</a>
            @endif
            <div class="card mb-5 line">
                <h3 class="text-left ml-5">{{"Fecha de pedido: ".$order->date_order." | "."Referencia: ".$order->reference}} </h3>
                <h3 class="text-center">{{$order->address->name." ".$order->address->surname1." ".$order->address->surname2}}</h3>
                <h3 class="text-center">{{$order->address->address." (".$order->address->region.", ".$order->address->city.")"}}</h3>

                @foreach($order->order_items as $order_item)
                <h3 class="text-center">{{$order_item->product->brand." ".$order_item->product->name}}</h3> 

                @foreach($order_item->product->product_images as $product_images)
                <img class="cart-image" src="{{url('product/'.$product_images->image)}}">
                @endforeach
                @if($order_item->quantity>1)
                <h3 class="text-center">{{$order_item->price}} € | {{$order_item->quantity}} unidades</h3> 
                @else
                <h3 class="text-center">{{$order_item->price}} € | {{$order_item->quantity}} unidad</h3> 
                @endif
                @endforeach
                <span class="text-center">Precio total: {{\OrderItemHelper::calcTotalPriceOrder($order->id)['total_price']}} €</span>

                <h3 class="text-center">Comentarios: {{$order->observations}}</h3>
            </div>
            @else
            <script>window.location = "/order/user/all";</script>
            @endif
            @endforeach
            @else
            <p>El pedido no existe</p>
            @endif
        </div>
    </div>
</div>
@endsection
