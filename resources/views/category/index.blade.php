@extends('layouts.app')

@section('title')
Index - Category
@endsection


@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            
            @if(session('message'))
            {{session('message')}}
            @endif
            
            <div class="card">         
              <h2><a href="{{route('category.create')}}">Create new categories</a></h2>
            </div>
            
            <div class="card">
                <h2><a href="{{route('category.all')}}">Edit existing categories</a></h2>
            </div>
        </div>
    </div>
</div>
@endsection
