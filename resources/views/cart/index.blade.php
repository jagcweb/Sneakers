@extends('layouts.app')

@section('title')
Cart
@endsection


@section('content')
    @if(session('message'))
    <h1>{{session('message')}}</h1>
    @endif
    <div id="cart-content">



        @if(count($cart_items)>0)
        <div id="cart-cards">
            <div class="cart-card mx-auto">
                <span class="cesta">Cart: ({{count(\CountCartItem::countItems())}})</span>
            </div>
            @foreach($cart_items as $cart_item)
            <div class="cart-card mx-auto">
                @foreach($cart_item->product->product_images as $i=>$product_images)
                @if($i<1)
                <img class="cart-image" src="{{url('product/'.$product_images->image)}}">
                @endif
                @endforeach
                <div>
                    <div><h2>{{$cart_item->product->brand." ".$cart_item->product->name}}</h2></div>
                    <span class="cart-size">Size: {{$cart_item->size}}</span>
                    @if($cart_item->product->discount>0)
                    <div><span>{{\CountCartItem::calcPriceWithDiscount($cart_item->product->id)}} €</span></div>
                    @else
                    <div><span>{{$cart_item->product->price}} € </span></div>
                    @endif
                    <div>
                        @if($cart_item->quantity!=1)
                        <a href="{{route('cart.less-quantity', ['id' => $cart_item->id])}}"><img class="more-and-less"src="{{asset('img/minus.png')}}"/></a>
                        @else
                        <img class="more-and-less-disabled" src="{{asset('img/minus.png')}}"/>
                        @endif
                        <span class="quantity">{{$cart_item->quantity}}</span>
                        @if($cart_item->quantity == \CountCartItem::countTotalQuantityOfStock($cart_item->product_id, $cart_item->size))
                        <img class="more-and-less-disabled" src="{{asset('img/plus.png')}}"/>
                        <span>Sorry! We have no more stock of this size</span>
                        @else
                    <a href="{{route('cart.more-quantity', ['id' => $cart_item->id])}}"><img class="more-and-less" src="{{asset('img/plus.png')}}"/></a>
                                @endif
                                </div>
                                <div>
                                    <a href="{{route('cart.delete', ['id' => $cart_item->id])}}"class="delete-cart-item"><img src="{{asset('img/bin.png')}}"/></a>
                                </div>
                                </div>

                                </div>
                                @endforeach
                                </div>

                                <div id="cart-info">
                                    <div><h2>Order summary:<h2></div>
                                                <div>Subtotal <span>{{\CountCartItem::calcTotalPrice()['subtotal_price']}} €</span></div>
                                                @if(\CountCartItem::calcTotalPrice() <100)
                                                <div class="shipping">Shipping <span>{{\CountCartItem::calcTotalPrice()['shipping_tax']}} €</span></div>
                                                <div class="total">Total<span>{{\CountCartItem::calcTotalPrice()['total_price']}} €</span></div>
                                                @else
                                                <div class="shipping">Shipping <span>{{\CountCartItem::calcTotalPrice()['shipping_tax']}} €</span></div>
                                                <div class="total">Total<span>{{\CountCartItem::calcTotalPrice()['total_price']}} €</span></div>
                                                @endif
                                                <div class="finish-order"><a href="{{route('order.create')}}">Make order</a></div>
                                                </div>
                                                @else
                                                <p>The shopping cart is empty</p>
                                                @endif
                                                </div>
                                                @endsection
