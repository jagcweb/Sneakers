@extends('layouts.app')

@section('title')
Categories
@endsection


@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if(session('message'))
            <p>{{session('message')}}</p>
            @endif
            @if(count($categories)>0)
            @foreach($categories as $category)
            <a href="{{route('category.edit', ['id' => $category->id])}}" class="text-secondary mr-3">Edit</a>
            <!-- Trigger the modal with a button -->
            <!-- Button trigger modal -->
            <button class="text-danger border-0 bg-transparent" data-toggle="modal" data-target="#exampleModal-{{$category->id}}">
                Delete
            </button>

            <!-- Modal -->
            <div class="modal fade" id="exampleModal-{{$category->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Borrar la categoría: {{$category->name}} </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                           Deleting the category {{$category->name}} will also delete all the products that are included in it, as well as all the objects in the customers' cart, orders and products of the orders.
                            
                            @foreach($category->products as $products)
                            <br/>
                            <span class="text-danger">{{$products->name}}</span>
                            @endforeach
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="text-secondary border-0 bg-transparent" data-dismiss="modal">Close</button>
                            <a href="{{route('category.delete', ['id' => $category->id])}}" class="text-danger">Permanently delete</a>
                        </div>
                    </div>
                </div>
            </div>


            <div class="card mb-5 line">

                <h3 class="text-center">{{$category->name}}</h3>
            </div>
            
            @endforeach
            @else
            <p>There are no categories created yet. So what are you waiting to  <a href="{{route('category.create')}}">create </a>them?</p>
            @endif
        </div>
    </div>
</div>
@endsection
