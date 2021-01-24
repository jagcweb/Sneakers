@extends('layouts.app')

@section('title')
Search
@endsection

@section('content')

<div class="container">

    
   @foreach($products as $product)
   <h2><a href="{{route('product.detail', ['brand' => $product->brand, 'name' => $product->name])}}">{{$product->brand . " ". str_replace('-', ' ', $product->name)}}</a></h2>
   @endforeach
    
    
    
    
</div>

@endsection