@extends('layouts.app')

@section('title')
Edit Product
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
                <div class="card-header">Edit Product</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('product.update', ['id' => $product->id]) }} " enctype="multipart/form-data">
                        @csrf

                        <div class="form-group row">
                            <label for="category" class="col-md-4 col-form-label text-md-right">Category</label>

                            <div class="col-md-6">
                                <select name="category_id">
                                    @foreach($categories as $category)
                                    @if($category->id == $product->category_id)
                                    <option value="{{$category->id}}" selected hidden>{{$category->name}}</option>
                                    @endif
                                    @endforeach
                                    @foreach($categories as $category)
                                    <option value="{{$category->id}}">
                                        {{$category->name}}
                                    </option>
                                    @endforeach

                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">Name</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{str_replace('-', ' ', $product->name)}}"/>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="brand" class="col-md-4 col-form-label text-md-right">Brand</label>

                            <div class="col-md-6">
                                <input id="brand" type="text" class="form-control" name="brand" value="{{$product->brand}}"/>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="price" class="col-md-4 col-form-label text-md-right">Price</label>

                            <div class="col-md-6">
                                <input id="price" type="number" step=0.01 class="form-control" name="price" value="{{$product->price}}"/>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="gender" class="col-md-4 col-form-label text-md-right">Gender</label>

                            <div class="col-md-6">
                                @if($product->gender == 'M')
                                <input type="radio" id="man" name="gender" value="M" checked>
                                <label for="man">Man</label>

                                <input type="radio" id="woman" name="gender" value="W" class='ml-3'>
                                <label for="woman">Woman</label>
                                @else
                                <input type="radio" id="man" name="gender" value="M">
                                <label for="man">Man</label>

                                <input type="radio" id="woman" name="gender" value="W" class='ml-3' checked>
                                <label for="woman">Woman</label>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="gender" class="col-md-4 col-form-label text-md-right">Child</label>

                            <div class="col-md-6">
                                @foreach($product->childs as $child)
                                @if($child->child == 1)
                                <input type="checkbox" id="child" name="child" value="1" checked>
                                @else
                                <input type="checkbox" id="child" name="child" value="1">
                                @endif
                                @endforeach
                                <label for="child">Child</label>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="discount" class="col-md-4 col-form-label text-md-right">Discount</label>

                            <div class="col-md-6">
                                <input id="discount" type="number" maxlength="2" pattern="[0-9]*" class="form-control" name="discount" value="{{$product->discount}}"/>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="discount" class="col-md-4 col-form-label text-md-right">Description</label>

                            <div class="col-md-6">
                                <textarea name='description' class="form-control" placeholder="{{$product->description}}"></textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="image" class="col-md-4 col-form-label text-md-right">Add image</label>


                            <div class="col-md-6 mb-3">
                                <input id="image" multiple="multiple" type="file" class="form-control" name="image[]"/>
                            </div>

                            @foreach($product->product_images as $product_image)
                            <div class="text-center p-3 mx-auto mt-1">
                                @if(session('message'))
                                <p mb-3>{{session('message')}}</p>
                                @endif

                                <img class="image p-2" src="{{url('product/'.$product_image->image)}}">
                                <button type=button class="border-0 bg-transparent text-danger font-weight-bold" data-toggle="modal" data-target="#exampleModal-{{$product->id}}">
                                    X
                                </button>

                                <!-- Modal -->
                                <div class="modal fade" id="exampleModal-{{$product->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Delete image</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                               Deleting the selected image will also erase its file completely from the system storage.

                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="text-secondary border-0 bg-transparent" data-dismiss="modal">Close</button>
                                                <a href="{{route('product_image.delete', ['id' => $product_image->id])}}" class="text-danger">Permanently delete</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </div>

                            @endforeach
                        </div>



                        <input class="form-control btn btn-primary" type="submit" value="Edit product"/>


                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
