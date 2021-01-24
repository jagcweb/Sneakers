@extends('layouts.app')

@section('title')
Products
@endsection


@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-xl-12">
            @if(session('message'))
            {{session('message')}}
            @endif
            <br/>
            @if(count($products)>0)
            <div id="cards-all">
                @foreach($products as $product)
                <div class="card-all">
                    @foreach($product->product_images as $i=>$product_image)
                    @if($i<1)
                    <img class="image-all" src="{{url('product/'.$product_image->image)}}">
                    @endif
                    @endforeach

                    <h3 class="text-center">{{$product->brand." ".str_replace('-', ' ', $product->name)." - ".$product->price}} €</h3>
                    
                    
                <a href="{{route('product.edit', ['id' => $product->id])}}" class="edit-all">Edit</a>
                <a href="{{route('product.stock', ['id' => $product->id])}}" class="add-stock-all"> Add stock</a>
                <button class="delete-all text-danger" data-toggle="modal" data-target="#exampleModal-{{$product->id}}">
                    Delete
                </button>

                <!-- Modal -->
                <div class="modal fade" id="exampleModal-{{$product->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Borrar el producto: {{str_replace('-', ' ', $product->name)}} </h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                When deleting the product {{str_replace('-', ' ', $product->name)}}; All stocks and images that are included in it will also be deleted, as well as all orders and order items.

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="text-secondary border-0 bg-transparent" data-dismiss="modal">Close</button>
                                <a href="{{route('product.delete', ['id' => $product->id])}}" class="text-danger">Delete permanently</a>
                            </div>
                        </div>
                    </div>
                </div>

                </div>
                @endforeach

            </div>
            @else
            <p>There is no product created yet. What are you waiting for to <a href="{{route('product.create')}}">create</a>them?</p>
            @endif
        </div>
    </div>
</div>
@endsection
