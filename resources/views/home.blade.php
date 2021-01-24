@extends('layouts.app')

@section('title')
{{$title}}
@endsection

@include('swiperjs.css')


@section('content')


<div class="row justify-content-center">
    <div class="col-xl-12">
        @if(session('message'))
        <h1 class='text-center mb-5'>{{session('message')}}</h1>
        @endif
        <div class="the-best">
            <div id="best-sellers">
                @foreach($best_sellers as $i=>$best)
                <div class="best">
                    @foreach($best->product->product_images as $best_images)
                    <img loading="lazy" src="{{url('product/'.$best_images->image)}}">
                    @endforeach
                    <span>{{$best->product->brand." ".str_replace('-', ' ', $best->product->name)}}</span>
                    <a href="{{route('product.detail', ['brand' => $best->product->brand, 'name' => $best->product->name])}}">Buy</a>
                </div>
                @if($i<1)
                <img loading="lazy" src="{{asset('img/best-sellers.png')}}"/>

                @endif

                @endforeach
            </div>
        </div>


        <div id="cats">
            @foreach($categories as $category)
            <a href="{{ route('products.category', ['id' => $category->id]) }}">
                <div data-aos-anchor-placement="top-bottom"  data-aos="zoom-in" class="cat">
                    <span class="cat-name">{{$category->name}}</span>
                    <img  loading="lazy" class="cat-img" src="{{url('category/'.$category->image)}}">
                </div>
            </a>

            @endforeach
        </div>

        <br/>
        <h1 data-aos="zoom-in-down" data-aos-anchor-placement="center-bottom" class="titles">New arrivals</h1>
        <div class="swiper-container swip  w-50 mx-auto">
            <!-- Additional required wrapper -->
            <div class="swiper-wrapper">
                <!-- Slides -->
                @foreach($products_limit as $product)
                <div class="swiper-slide">
                    <div  loading="lazy" data-aos-anchor-placement="top-bottom"  data-aos="zoom-in" id="card-{{$product->id}}" class="home-card" onmouseenter="mouseEnterMethod('{{$product->id}}')" onmouseleave="mouseLeaveMethod('{{$product->id}}')">
                        @foreach($product->product_images as $i=>$product_image)
                        <a href="{{route('product.detail', ['brand' => $product->brand, 'name' => $product->name])}}">
                            @if($i<1)
                            <img  id="image-{{$product->id}}" class="@if(count($product->stocks)>0) card-image @else card-image-no-stock @endif" src="{{url('product/'.$product_image->image)}}">
                            @endif
                            @endforeach
                            <h2>{{$product->brand . " ". str_replace('-', ' ', $product->name)}}</h2>
                            @if($product->discount>0 && count($product->stocks)>0)
                            <span><s>{{$product->price}} €</s></span>
                            <span class='discount'>-{{$product->discount}}%</span>
                            <div><span class="price">{{\CountCartItem::calcPriceWithDiscount($product->id)}} €</span></div>
                            @else
                            <span></span>
                            <div><span class="price">{{$product->price}} €</span></div>
                        </a>
                        @endif
                        @if(count($product->stocks)>0)


                        <form method="POST" name="stock-size-{{$product->id}}" action="{{route('cart.add', ['id' => $product->id])}}">
                            @csrf
                            <div id="stock-size-{{$product->id}}" class="stock-size" onclick="changeText(event,{{$product->id}})">
                                @foreach($product->stocks->sortBy('size') as $stock)
                                @if($stock->quantity>0)

                                <label>
                                    <input type="radio"  autocomplete="off" name="stock-size" value="{{$stock->size}}" @if($stock->quantity>0) required @else disabled @endif>
                                           <span>{{$stock->size}}</span>
                                </label>

                                @endif
                                @endforeach
                            </div>
                            <input type="submit" class="addCart" id="addCart-{{$product->id}}" value="Add to Cart"/>
                        </form>

                        @else
                        <span class='out-of-stock'>Out of stock</span>
                        <p class="no-stock-product">Out of stock!!</p>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>

            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>
        </div>

        <div data-aos="zoom-out" data-aos-anchor-placement="top-bottom"><a href="{{route('products.all')."?order=discount"}}"><img  loading="lazy" class=' w-100' src='{{asset('img/offer.png')}}'/></a>

        </div>


        <h1 data-aos="zoom-in-down" data-aos-anchor-placement="center-bottom" class='titles'>All our sneakers</h1>

        <div id='home-cards-all'>
            @foreach($products_limit_all as $product_all)
            <div  loading="lazy" class="home-card-all" data-aos="flip-down" data-aos-anchor-placement="top-bottom" >
                @foreach($product_all->product_images as $i=>$product_image_all)
                @if($i<1)
                <a href="{{route('product.detail', ['brand' => $product_all->brand, 'name' => $product_all->name])}}">
                    <img id="image-{{$product_all->id}}" class="@if(count($product_all->stocks)>0) card-image @else card-image-no-stock @endif" src="{{url('product/'.$product_image_all->image)}}">
                    @endif
                    @endforeach
                    <h2>{{$product_all->brand . " ". str_replace('-', ' ', $product_all->name)}}</h2>
                    @if($product_all->discount>0 && count($product_all->stocks)>0)
                    <span><s>{{$product_all->price}} €</s></span>
                    <span class='discount'>-{{$product_all->discount}}%</span>
                    <p>{{\CountCartItem::calcPriceWithDiscount($product_all->id)}} €</p>
                    @else
                    <span></span>
                    <p>{{$product_all->price}} €</p>
                </a>
                @endif
                @if(count($product_all->stocks)==0)
                <span class='out-of-stock'>Out of stock</span>
                <p class="no-stock-product">No hay Stock!!</p>
                @endif
            </div>
            @endforeach
        </div>
        <div data-aos="zoom-in" data-aos-anchor-placement="top-bottom"class='see-more'><a class="see-more-link" href='{{route('products.all')}}'><i class="fas fa-arrow-down mr-2"></i>See more</a></div>
    </div
</div>

<script src="{{ asset('js/add-cart.js') }}" defer></script>

@include('swiperjs.js-home')
@endsection
