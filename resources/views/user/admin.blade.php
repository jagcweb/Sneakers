@extends('layouts.app')

@section('title')
Administration
@endsection


@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card mb-3">         
                <h2><a href="{{route('category.index')}}">Categories</a></h2>
            </div>
            
            <div class="card mb-3">
                <h2><a href="{{route('product.index')}}">Products</a></h2>
            </div>

            <div class="card mb-3">
                <h2><a href="{{route('order.manage')}}">Orders</a></h2>
            </div>
        </div>
    </div>
</div>
@endsection
