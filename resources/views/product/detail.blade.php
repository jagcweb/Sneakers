@extends('layouts.app')

@section('title')
{{$title}}
@endsection

@include('swiperjs.css')
@section('content')
<div class="container-detail">
    <div class="row justify-content-center">
        <div class="col-xl-12">
            @if(session('message'))
            {{session('message')}}
            @endif
            @foreach($products as $product)

            <div id='cards-detail'>

                <div class="swiper-container swiper-detail">
                    <div class="swiper-wrapper">
                        @foreach($product->product_images as $product_image)
                        <div class="swiper-slide">
                            <img class='detail-img' src="{{url('product/'.$product_image->image)}}">
                        </div>

                        @endforeach
                    </div>
                    <div class="swiper-pagination swiper-pagination-black"></div>
                    @if($product->discount>0 && count($product->stocks)>0)
                    <span class='discount'>-{{$product->discount}}%</span>
                    @endif

                </div>
                <div class='info-detail'>
                    <h2>{{$product->brand . " ". str_replace('-', ' ', $product->name)}}</h2>

                    <p class="desc">Sneakers
                        @foreach($categories as $category)
                        @if($category->id == $product->category_id)
                        {{$category->name}}
                        @endif
                        @endforeach

                        @if($product->gender == 'M')
                        Man
                        @else
                        Woman
                        @endif

                        @foreach($product->childs as $child)
                        @if($child->child==1)
                        Child
                        @else
                        Adult
                        @endif
                        @endforeach
                    </p>

                    @if($product->discount>0 && count($product->stocks)>0)
                    <span><s>{{$product->price}} €</s></span>
                    <p class="price">{{\CountCartItem::calcPriceWithDiscount($product->id)}} €  <span>IVA inc.</span></p>
                    @else
                    <span></span>
                    <p class="price">{{$product->price}} €  <span>IVA inc.</span></p>
                    </a>
                    @endif

                    @if(count($product->stocks)>0)

                        <form method="POST" name="stock-size-{{$product->id}}" action="{{route('cart.add', ['id' => $product->id])}}">
                            @csrf
                              <span class='placeholder-size'>Choose a size</span>
                            <div id="stock-size-{{$product->id}}" class="stock-size" onclick="changeText(event,{{$product->id}})">
                                @foreach($product->stocks->sortBy('size') as $stock)
                                @if($stock->quantity>0)
                                <label class='d-inline-block mr-2'>
                                    <input type="radio"  autocomplete="off" name="stock-size" value="{{$stock->size}}" @if($stock->quantity>0) required @else disabled @endif>
                                           <span>{{$stock->size}}</span>
                                </label>

                                @endif
                                @endforeach
                            </div>
                              <br/>
                            <input type="submit" class="add-cart-detail" id="addCart-{{$product->id}}" value="Add to Cart"/>
                        </form>
                        @if($product->price<100)
                        <span class='detail-properties'><i class="fas fa-truck mr-2"></i>Free shipping on orders over 100€ (If the amount is less than 100€, the shipping will be 4.99€)</span>
                        @else
                        <span class='detail-properties'><i class="fas fa-truck mr-2"></i>Free shipping for this product</span>
                        @endif

                        <span class='detail-properties'><i class="fas fa-box mr-2"></i>Delivery in 2-3 business days</span>
                        <span class='detail-properties'><i class="fas fa-undo-alt mr-2"></i>Changes and returns within 30 days after receiving the order</span>
                        @else
                        <p class='out-of-stock'>Out of stock</p>
                        @endif
                </div>
                @endforeach

            </div>

            <div class='more-info-detail'>
                <span>Product info</span>
                <p>{{$product->description}}</p>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/add-cart.js') }}" defer></script>
    @include('swiperjs.js-detail')
    @endsection
