@extends('layouts.app')
<link rel="stylesheet" href="{{asset('css/rSlider.min.css')}}">
@section('title')
{{$title. " ".$category->name}}
@endsection

@section('content')


<form method="GET" action="{{route('products.category', ['id' => $category->id])}}">
    <div class="filters">

        <div class="filter">
            <span class="filters-styles" id="button-gender" onclick="openDiv('gender');">Gender...<i class="fas fa-chevron-down arrow"></i></span>
            <div class="search-g open-div" id="search-gender" onclick="changeText(event, 'gender');">
                <label>
                    <input type="radio" value="M" name="gender">
                    <span>Man</span>
                </label>
                <label>
                    <input type="radio" value="W" name="gender">
                    <span>Woman</span>
                </label>

                <hr/>

                <div class="kids-container">
                    <label>
                        <input type="checkbox" name="kids" value="1">
                        <span class="kids-box">Kids?</span>
                    </label>

                </div>
            </div>
        </div>

        <div class="filter">
            <span class="filters-styles" id="button-brand" onclick="openDiv('brand');">Brand...<i class="fas fa-chevron-down arrow"></i></span>
            <div class="search-g open-div" id="search-brand" onclick="changeText(event, 'brand');">
                @foreach($products_all as $product_all)
                <label>
                    <input type="radio" value="{{$product_all->brand}}" name="brand">
                    <span>{{$product_all->brand}}</span>
                </label>
                @endforeach
            </div>
        </div>

        <div class="filter">
            <span class="filters-styles" id="button-orderby" onclick="openDiv('orderby');">Order by...<i class="fas fa-chevron-down arrow"></i></span>
            <div class="search-g open-div" id="search-orderby" onclick="changeText(event, 'orderby');">
                <label>
                    <input type="radio" value="discount" name="order">
                    <span>% Discount</span>
                </label>
                <label>
                    <input type="radio" value="news" name="order">
                    <span>New Arrivals</span>
                </label>
                <label>
                    <input type="radio" value="a-z" name="order">
                    <span>A to Z</span>
                </label>
                <label>
                    <input type="radio" value="z-a" name="order">
                    <span>Z to A</span>
                </label>
                <label>
                    <input type="radio" value="less-price" name="order">
                    <span>Cheaper -> expensive</span>
                </label>
                <label>
                    <input type="radio" value="more-price" name="order">
                    <span>Expensive -> cheaper</span>
                </label>
            </div>
        </div>

        <div class="filter">
            <span class="filters-styles" id="button-price" onclick="openDiv('price');">Price...<i class="fas fa-chevron-down arrow"></i></span>
            <div class="search-g open-div" id="search-price" onclick="changeText(event, 'price');">
                <label>
                    <input type="text" class="start d-none" name="price-start" />
                    <input type="text" class="end d-none" name="price-end" />
                    <input type="text" id="sampleSlider" />
                </label>
            </div>
        </div>

        <div class="filter">
            <span class="filters-styles" id="button-size" onclick="openDiv('size');">Size...<i class="fas fa-chevron-down arrow"></i></span>
            <div class="search-g open-div" id="search-size" onclick="changeText(event, 'size');">
                @foreach($sizes as $size)
                <label>
                    <input type="radio" value="{{$size->size}}" name="size">
                    <span>{{$size->size}}</span>
                </label>
                @endforeach
            </div>
        </div>
        <div class="filter">
            <input type="submit" class="btn btn-secondary filters-styles"value="Filter"/>
        </div>

    </div>
</form>


@if(count($products)>0)
<h1 class='titles2'>Category: {{$category->name}}</h1>
@else
<h1 class='titles2'>There are no products with these filters</h1>
@endif
<div id='alls'>
    @foreach($products as $product)
    <div class="all">
        @foreach($product->product_images as $i=>$product_image)
        @if($i<1)
        <a href="{{route('product.detail', ['brand' => $product->brand, 'name' => $product->name])}}">
            <img id="image-{{$product->id}}" class="@if(count($product->stocks)>0) card-image2 @else card-image-no-stock @endif" src="{{url('product/'.$product_image->image)}}">
        </a>
        @endif
        @endforeach
        <h2>{{$product->brand . " ". str_replace('-', ' ', $product->name)}}</h2>
        @if($product->discount>0 && count($product->stocks)>0)
        <span><s>{{$product->price}} €</s></span>
        <span class='discount'>-{{$product->discount}}%</span>
        <p>{{\CountCartItem::calcPriceWithDiscount($product->id)}} €</p>
        @elseif($product->discount>0 && count($product->stocks)<1)
        <span class='out-of-stock' style="padding: 0px;">Out of stock</span>
          <span><s>{{$product->price}} €</s></span>
        <p>{{\CountCartItem::calcPriceWithDiscount($product->id)}} €</p>
        @else
        <span></span>
        <p>{{$product->price}} €</p>
        @endif
    </div>
    @endforeach
</div>


<script src="{{ asset('js/add-cart.js') }}" defer></script>
<script src="{{ asset('js/rSlider.min.js') }}" defer></script>
<script src="{{ asset('js/price-range-slider.js') }}" defer></script>
<script src="{{ asset('js/products-filters.js') }}" defer></script>
@endsection