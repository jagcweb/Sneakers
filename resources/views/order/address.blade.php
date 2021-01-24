@extends('layouts.app')

@section('title')
Address
@endsection


@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if(session('message'))
            {{session('message')}}
            @endif
            <br/>
            
            {{\Cookie::queue('order', 1, 20)}}

            <a href="{{route('address.create')}}">Create new address</a>

            @if(count($addresses)>0)
            <div id="address-cards">
                <div class="address-card mx-auto">
                    <h1>My addresses</h1>
                </div>

                @foreach($addresses as $address)
                <div class="adresss-links">
                    <a href="{{route('address.edit', ['id' => $address->id])}}" class="text-secondary mr-3">Edit</a>
                    <button class="text-danger border-0 bg-transparent" data-toggle="modal" data-target="#exampleModal-{{$address->id}}">
                        Delete
                    </button>

                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal-{{$address->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Delete the address: {{$address->address ." (".$address->region.", ".$address->city.")"}}

                                        @if($address->default_address == 1)
                                        <p class="text-danger font-weight-bold">The address you want to delete is your default delivery address</p>
                                        @endif

                                    </h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    The specified address will be deleted. Are you sure?

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="text-secondary border-0 bg-transparent" data-dismiss="modal">Close</button>
                                    <a href="{{route('address.delete', ['id' => $address->id])}}" class="text-danger">Delete</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if($address->default_address!=1)
                    <a href="{{route('address.set-default', ['id' => $address->id])}}" class="text-secondary ml-3">Set as default address</a>
                    @else
                    <span class="text-secondary ml-3">Default address</span>
                    @endif
                </div>



                <div class="address-card mx-auto">
                    <div>
                        <h3>{{$address->name." ".$address->surname1." ".$address->surname2}}</h3>
                        <p>{{$address->address ." (".$address->region.", ".$address->city.")"}}</p>

                    </div>

                </div>
                <form method="GET" action="{{route('order.create')}}">
                    <input class="d-none" name="id" value="{{$address->id}}"/>

                    <input type="submit" class="btn btn-primary" style="width: 100%; margin: 0px auto; margin-bottom: 30px;"value="Choose this address"/>
                </form>
                @endforeach
            </div>
            @else
            <p>You don't have any address created.</p>
            <button class="btn btn-success"><a href="{{route('address.create')}}">Create new address</a></button>
            @endif

        </div>
    </div>
    @endsection
