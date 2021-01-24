@extends('layouts.app')
@section('title')
Create Address
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
                <div class="card-header">Create address</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('address.save') }} ">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">Name</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name"/>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="surname1" class="col-md-4 col-form-label text-md-right">Surname1</label>

                            <div class="col-md-6">
                                <input id="surname1" type="text" class="form-control" name="surname1"/>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="surname2" class="col-md-4 col-form-label text-md-right">Surname2</label>

                            <div class="col-md-6">
                                <input id="surname2" type="text" class="form-control" name="surname2"/>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="address" class="col-md-4 col-form-label text-md-right">Address</label>

                            <div class="col-md-6">
                                <input id="address" type="text" class="form-control" name="address"/>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="region" class="col-md-4 col-form-label text-md-right">Region</label>

                            <div class="col-md-6">
                                <select class="form-control" name="region">
                                    <option  value="" selected disabled hidden>Choose a region...</option>
                                    @foreach($regions as $region)
                                    <option value="{{$region->region_name}}">
                                        {{$region->region_name}}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="city" class="col-md-4 col-form-label text-md-right">City</label>

                            <div class="col-md-6">
                                <input id="city" type="text" class="form-control" name="city"/>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="postal_code" class="col-md-4 col-form-label text-md-right">Postal Code</label>

                            <div class="col-md-6">
                                <input id="postal_code" type="text" class="form-control" name="postal_code" maxlength="5" pattern="[0-9]*"/>
                            </div>
                        </div>

                        <input class="form-control btn btn-primary" type="submit" value="Save address"/>


                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
