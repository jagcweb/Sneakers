@extends('layouts.app')

@section('title')
Index - Order
@endsection


@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            
            @if(session('message'))
            {{session('message')}}
            @endif
            
            <div class="card mb-3">         
              <h2><a href="{{route('order.manage.all')}}">All orders</a></h2>
            </div>
            
            <div class="card mb-3">         
              <h2><a href="{{route('order.manage.pending')}}">Pending orders</a></h2>
            </div>
            
            <div class="card mb-3">
                <h2><a href="{{route('order.manage.finalized')}}">Orders already completed</a></h2>
            </div>
            
            <div class="card mb-3">
                <h2><a href="{{route('order.manage.canceled')}}">Orders canceled</a></h2>
            </div>
        </div>
    </div>
</div>
@endsection
