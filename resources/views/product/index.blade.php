@extends('layouts.app')

@section('title')
Index - Product
@endsection


@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            
            @if(session('message'))
            {{session('message')}}
            @endif
            
            <div class="card mb-3">         
              <h2><a href="{{route('product.create')}}">Create new products</a></h2>
            </div>
            
            <div class="card mb-3">
                <h2><a href="{{route('product.all')}}">Edit existing products</a></h2>
            </div>
        </div>
    </div>
</div>
@endsection
