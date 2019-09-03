@extends('layouts.app')
@section('title')
    Edit {{ $shop->name }}
@endsection
@section('content')
    @include('helpers.header')

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-3">
                @include('helpers.accountSidebar')
            </div>
            <div class="col-sm-9">
                @if(count($errors->all()) > 0)
                    @foreach($errors->all() as $error)
                        <div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Coution!</strong> {{ $error }}
                            <button class="close" type="button" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                        </div>
                    @endforeach
                @endif
                <div class="card mt-3">
                    <div class="card-header">Edit shop</div>
                    <div class="card-body">
                        <form action="{{ route('home.shops.update',$shop->id) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')
                            <input class="form-control" type="text" name="shop_name" value="{{ $shop->name }}" placeholder="Shop name" required> <br>
                            <input class="form-control" type="text" name="shop_location" value="{{ $shop->location }}" placeholder="Shop location" required> <br>
                            <textarea class="form-control" name="shop_description" id="" cols="30" placeholder="Shop description" rows="10" required>{{ $shop->description }}</textarea> <br>
                            
                            <input class="form-control" type="file" name="shop_image" accept=".png, .jpg, .jpeg"> <br>

                            <button class="btn btn-warning float-right" type="submit">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('helpers.subscribe')
    @include('helpers.footer')
@endsection