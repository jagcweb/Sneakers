@extends('layouts.app')

@section('title')
Stock
@endsection


@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            @if(session('message'))
            <h1>{{session('message')}}</h1>
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

            <div class="card">
                <div class="card-header">Add Stock for {{$product->brand." ".$product->name}}</div>


                <div class="card-body">
                    <form method="POST" action="{{ route('product.updateStock', ['id' => $product->id]) }}">
                        @csrf

                        <div class="form-group row">
                            <label for="stock" class="col-md-4 col-form-label text-md-right">Stock quantity</label>

                            <div class="col-md-6">
                                <input id="stock" type="number" class="form-control" name="quantity"/>
                            </div>
                        </div>

                        @foreach($product->childs as $child)
                        @if($product->gender == 'M' && $child->child==0)
                        <p class='text-center'>The sneakers to edit belong to a adult man. Enter a size from 36 to 50</p>
                        @elseif($product->gender == 'W' && $child->child==0)
                        <p class='text-center'>The sneakers to edit belongs to an adult woman. Enter a size from 34 to 46</p>
                        @elseif($product->gender == 'M' && $child->child==1)
                        <p class='text-center'>The sneakers to edit belongs to a small child. Enter a size from 19 to 35</p>
                        @else
                        <p class='text-center'>The sneakers to edit belongs to a little girl. Enter a size from 19 to 33</p>
                        @endif
                        @endforeach

                        <div class="form-group row">
                            <label for="size" class="col-md-4 col-form-label text-md-right">Size</label>

                            <div class="col-md-6">
                                <input id="size" type="number" class="form-control" name="size"/>
                            </div>
                        </div>
                        <input class="form-control btn btn-primary" type="submit" value="Add stock"/>
                    </form>

                    <hr/>
                    <hr/>
                    <span>Current stock of {{$product->brand." ".$product->name}} (by sizes / units)</span>
                    @foreach($product->stocks->sortBy('size') as $stock)
                    <div>
                        <span>{{$stock->size}} / {{$stock->quantity}} units</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
