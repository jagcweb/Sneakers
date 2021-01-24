@extends('layouts.app')

@section('title')
Edit Category
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
                <div class="card-header">Update</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('category.update', ['id' => $category->id]) }}" enctype="multipart/form-data">
                        @csrf
                        
                         <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">id</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{$category->id}}" disabled/>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">Name</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{$category->name}}"/>
                            </div>
                        </div>
                        
                        <div class="w-100 mx-auto text-center">
                            <img class="image p-2" src="{{url('category/'.$category->image)}}">
                        </div>
                        
                        
                         <div class="form-group row">
                            <label for="image" class="col-md-4 col-form-label text-md-right">Image</label>

                            <div class="col-md-6">
                                <input id="image" type="file" class="form-control" name="image"/>
                            </div>
                        </div>
                        
                        <input class="form-control btn btn-primary" type="submit" value="Edit category"/>
                        
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
