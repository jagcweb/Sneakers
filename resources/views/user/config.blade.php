@extends('layouts.app')

@section('title')
Config
@endsection


@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            @if(session('message'))
            <h1>{{session('message')}}</h1>
            @endif
            <div class="card">
                <div class="card-header">Update</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('user.update') }}"  enctype="multipart/form-data">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">Name</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{\Auth::user()->name}}"/>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="surname" class="col-md-4 col-form-label text-md-right">Surname</label>

                            <div class="col-md-6">
                                <input id="surname" type="text" class="form-control" name="surname" value="{{\Auth::user()->surname}}"/>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">Email</label>

                            <div class="col-md-6">
                                <input id="email" type="text" class="form-control" name="email" value="{{\Auth::user()->email}}"/>
                            </div>
                        </div>

                        <div class="form-group row">

                            <label for="avatar" class="col-md-4 col-form-label text-md-right">Avatar</label>

                            <div class="col-md-6">

                                <input id="avatar" type="file" class="form-control" name="avatar"/>
                            </div>
                        </div>

                        @if(\Auth::user()->image != null)
                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">Avatar Actual:</label>

                            <div class="col-md-6">
                                <img src="{{url('user/avatar/'.Auth::user()->image)}}" class="avatar"/>
                            </div>
                        </div>

                        @endif
                        
                        <input class="form-control btn btn-primary" type="submit" value="Update user"/>
                        
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
