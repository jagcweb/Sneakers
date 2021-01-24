@extends('layouts.app')

@section('title')
Edit Order
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
                <div class="card-header">Editar pedido</div>
                
                @if($order->status == 'finalizado') 
                <h3 class='text-center text-danger'>Este pedido ya ha sido finalizado. No podrás editarlo.</h3>
                @endif
                
                @if($order->status == 'cancelado') 
                <h3 class='text-center text-danger'>Este pedido ha sido cancelado. No podrás editarlo.</h3>
                @endif
                
                @if($order->status == 'pagado') 
                <h3 class='text-center text-danger'>El pedido aún no ha sido enviado. Aún puedes editar el pedido.</h3>
                @endif
                
                @if($order->status != 'pagado' && $order->status != 'finalizado' && $order->status != 'cancelado') 
                <h3 class='text-center text-danger'>El pedido ya ha sido enviado. Únicamente podrás editar el estado del pedido.</h3>
                @endif

                <div class="card-body">
                    <form method="POST" action="{{ route('order.manage.update', ['id' => $order->id, 'address_id' => $order->address->id]) }}">
                        @csrf

                        <div class="form-group row">
                            <label for="status" class="col-md-4 col-form-label text-md-right">Estado</label>

                            <div class="col-md-6">
                                <select class='form-control' name="status" @if($order->status == 'finalizado' || $order->status == 'cancelado') disabled @endif>
                                     <option value="{{$order->status}}" selected hidden>{{$order->status}}</option>
                                    <option>
                                        pagado
                                    </option>

                                    <option>
                                        preparando envío
                                    </option>

                                    <option>
                                        enviado
                                    </option>

                                    <option>
                                        finalizado
                                    </option>

                                    <option>
                                        cancelado
                                    </option>

                                </select>
                            </div>
                        </div>
                        
                      

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">Nombre:</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name='name' value="{{$order->address->name}}"   @if($order->status != 'pagado') disabled @endif/>
                            </div>

                        </div>
                        
                        <div class="form-group row">
                            <label for="surname1" class="col-md-4 col-form-label text-md-right">Apellido 1:</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name='surname1' value="{{$order->address->surname1}}"   @if($order->status != 'pagado') disabled @endif/>
                            </div>

                        </div>
                        
                        
                        <div class="form-group row">
                            <label for="surname2" class="col-md-4 col-form-label text-md-right">Apellido 2:</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name='surname2' value="{{$order->address->surname2}}"   @if($order->status != 'pagado') disabled @endif/>
                            </div>

                        </div>
                        
                        <div class="form-group row">
                            <label for="address" class="col-md-4 col-form-label text-md-right">Dirección:</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name='address' value="{{$order->address->address}}"   @if($order->status != 'pagado') disabled @endif/>
                            </div>

                        </div>
                        
                        <div class="form-group row">
                            <label for="region" class="col-md-4 col-form-label text-md-right">Comunidad Autónoma: </label>

                            <div class="col-md-6">
                                <select class="form-control" name="region"  @if($order->status != 'pagado') disabled @endif>
                                    <option value="{{$order->address->region}}" selected disabled hidden>{{$order->address->region}}</option>
                                    @foreach($regions as $region)
                                    <option value="{{$region->region_name}}">
                                        {{$region->region_name}}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                                                
                        <div class="form-group row">
                            <label for="city" class="col-md-4 col-form-label text-md-right">Ciudad:</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name='city' value="{{$order->address->city}}"   @if($order->status != 'pagado') disabled @endif/>
                            </div>

                        </div>
                        
                        <div class="form-group row">
                            <label for="postal_code" class="col-md-4 col-form-label text-md-right">Código Postal:</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name='postal_code' value="{{$order->address->postal_code}}"   @if($order->status != 'pagado') disabled @endif/>
                            </div>

                        </div>
                        <input class="form-control btn btn-primary" type="submit" value="Editar pedido" @if($order->status == 'finalizado'  || $order->status == 'cancelado') disabled @endif/>


                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
