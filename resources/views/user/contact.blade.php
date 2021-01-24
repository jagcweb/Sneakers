@extends('layouts.app')

@section('title')
Create Category
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
                <div class="card-header">Contact us</div>

                <div class="card-body">
                    <form method="GET" action="{{route('contactmail')}}">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">Name</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" @if(\Auth::user()!=null) value="{{\Auth::user()->name}}" @endif/>
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">Email</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="email" @if(\Auth::user()!=null) value="{{\Auth::user()->email}}" @endif/>
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="reason" class="col-md-4 col-form-label text-md-right">Reason</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="reason"/>
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="description" class="col-md-4 col-form-label text-md-right">Description</label>

                            <div class="col-md-6">
                                <textarea class="form-control" name="description"></textarea>
                            </div>
                        </div>
                        
                        <input class="form-control btn btn-primary" type="submit" value="Send"/>
                        
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
