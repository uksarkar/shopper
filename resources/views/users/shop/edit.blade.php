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
                <div class="card mt-3">
                    <div class="card-header">Edit shop</div>
                    <div class="card-body">
                        <form action="{{ route('home.shops.update',$shop->id) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')
                            <input class="form-control" type="text" name="shop_name" placeholder="Shop name" value="{{ old('shop_name', $shop->name) }}" required> <br>
                            <input class="form-control" type="text" name="shop_url" placeholder="http://www.url.com" value="{{ old('shop_url', $shop->url) }}"> <br>
                            
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