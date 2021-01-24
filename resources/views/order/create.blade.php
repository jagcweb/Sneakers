@extends('layouts.app')

@section('title')
Order
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
                <div class="card-header">Finalize order</div>

                <div class="card-body">
                    <form method="GET" action="{{ route('stripe.payment') }} ">
                        @csrf


                        @if(count($address)>0)
                        <div class="form-group row">
                            <label for="observations" class="col-md-4 col-form-label text-md-right">Delivery address</label>

                            @foreach($address as $address_default)
                            <div class="col-md-6">
                                <div>
                                    <span>{{$address_default->name." ".$address_default->surname1." ".$address_default->surname2}}</span>
                                    <p>{{$address_default->address." (".$address_default->region.", ".$address_default->city.")"}}</p>
                                    <input type="hidden" name="address_id" value="{{$address_default->id}}"/>
                                </div>
                                <a href="{{route('order.address')}}">Change delivery address</a>
                            </div>
                            @endforeach
                        </div>

                        <div class="form-group row">
                            <label for="observations" class="col-md-4 col-form-label text-md-right">Observations</label>

                            <div class="col-md-6">
                                <textarea  class="form-control" name="observations" placeholder="Any additional information you want to give us about the order?"></textarea>
                            </div>
                        </div>

                        @else
                        <div class="form-group row">

                            <div class="col-md-6">
                                <div>
                                    <p class="text-center">You don't have any address created or you do not have one marked as default. <a href="{{route('order.address')}}">check your addresses</a></p>
                                </div>
                            </div>
                        </div>
                        @endif

                        <input class="form-control btn btn-primary" type="submit" value="Finalize order"  @if(count($address)==0) disabled @endif/>


                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
