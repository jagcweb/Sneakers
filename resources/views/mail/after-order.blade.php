<div class="container">

    Hello <i>{{\Auth::user()->name." ".\Auth::user()->surname}}</i>,
    <p>Thank you for shopping at Sneakers</p>

    <p>Here we leave you the details of your order:</p>

    <br/>
    <br/>
    <div>
        <strong>Address:</strong>
        <p>{{$order->address->name. " ".$order->address->surname1." ".$order->address->surname2}}</p>
        <p>{{$order->address->address." (".$order->address->region.", ".$order->address->city.") "."CP: ".$order->address->postal_code}}</p>
    </div>

    <br/>
    <br/>

    <div>
        <strong>Order Items:</strong>
        @foreach($order->order_items as $order_items)
        <p>{{$order_items->product->brand." ".$order_items->product->name}}</p>
        <p>Price: {{$order_items->price}} | Quantity: {{$order_items->quantity}}</p>

        @foreach($order_items->product->product_images as $i=>$product_image)
        @if($i<1)
        <img style='width: 150px; height: 210px;' src="{{$message->embed(url('product/'.$product_image->image))}}">
        @endif
        @endforeach
        @endforeach
    </div>


    <br/>
    <br/>
    <div>
        <strong>Order:</strong>
        <p>Reference: {{$order->reference}}</p>
        <p>Observations: {{$order->observations}}</p>
        <p>Total price:{{$order->total_price}}</p>
        @if($order->total_price <100)
        <p>Shipping cost: 4.99€</p>
        @endif
    </div>

    You can check the status of your order in the section <a href='{{route('order.user.all')}}'>My orders</a>
    <br/>
    Thank You,
    <br/>
    <i>Sneaker's Team.</i>
</div>
