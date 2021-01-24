@extends('layouts.app')

@section('title')
Orders
@endsection


@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            @if(count($orders)>0)
            <h1 class="text-center">All orders</h1>

            @if(session('message'))
            <p>{{session('message')}}</p>
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

            <form method="GET" action="{{route('order.manage.all')}}" id="buscador">
                <div class="row">
                    <div class="form-group col">
                        <label for="date1" class="col-md-4 col-form-label">From</label>

                        <input type="date" class="mb-2"name="date1"/>
                    </div>  

                    <div class="form-group col">
                        <label for="date2" class="col-md-4 col-form-label">To</label>
                        <input type="date" class="mb-2" name="date2"/>
                    </div>
                    
                    <div class="form-group col">
                        <label for="reference" class="col-md-4 col-form-label">Reference</label>
                        <input type="text" class="mb-2" name="reference"/>
                    </div>

                    <div class="form-group col">
                        <input class="btn btn-primary" type="submit" value="Filter"/>
                    </div>   
                </div>

            </form>

            @foreach($orders as $order)
            <div class="card mb-5 line">
                <a href="{{route('order.manage.detail', ['id' => $order->id])}}">
                <h3 class="text-left ml-5">{{"Order date: ".$order->date_order." | "."Reference: ".$order->reference}} </h3>
                </a>
            </div>

            
            @endforeach
            {{$orders->links("pagination::bootstrap-4")}}
            @else
            <p>There is no order yet</p>
            @endif
        </div>
    </div>
</div>
@endsection
