@extends('layouts.app')
@section('title')
    Create new shop
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
                    <div class="card-header">Create shop</div>
                    <div class="card-body">
                        <form action="{{ route('home.shops.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <input class="form-control" type="text" name="shop_name" placeholder="Shop name" required> <br>
                            <input class="form-control" type="text" name="shop_url" placeholder="http://www.url.com" required> <br>
                            
                            <input class="form-control" type="file" name="shop_image" accept=".png, .jpg, .jpeg" required> <br>

                            <button class="btn btn-primary" type="submit">Create</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('helpers.subscribe')
    @include('helpers.footer')
@endsection
