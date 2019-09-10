@extends('layouts.app')
@section('title')
    All products of {{ $category->name }}
@endsection
@section('content')
    @include('helpers.header')


<!-- ========================= SECTION CONTENT ========================= -->
<section class="section-content bg padding-y-sm">
    <div class="container">
    <div class="card">
        <div class="card-body">
    <div class="row">
        <div class="col-md-3-24"> <strong>Your are here:</strong> </div> <!-- col.// -->
        <nav class="col-md-18-24"> 
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            @foreach (explode('/', $category->slug) as $k => $slug)
                @if($k > 0)
                    <li class="breadcrumb-item @if($category->getNameSlugOfCategory($slug)['id'] == $category->id) active @endif"><a href="{{ $category->getNameSlugOfCategory($slug)['slug'] }}">{{ $category->getNameSlugOfCategory($slug)['name'] }}</a></li>
                @endif
            @endforeach
        </ol>  
        </nav> <!-- col.// -->
    </div> <!-- row.// -->
    <hr>
    <form action="{{ route('search') }}" method="get">
        <input type="hidden" name="name" value="{{ old('name') }}">
        <div class="row">
                <div class="col-md-3-24"> <strong>Filter by:</strong> </div> <!-- col.// -->
                <div class="col-md-21-24"> 
                    <ul class="list-inline">
                    <li class="list-inline-item">
                        <div class="form-inline">
                            <label class="mr-2">Price</label>
                            <input name="min" class="form-control form-control-sm" placeholder="Min" type="number" value="{{ old('min') }}">
                                <span class="px-2"> - </span>
                            <input name="max" class="form-control form-control-sm" placeholder="Max" type="number" value="{{ old('max') }}">
                            <button type="submit" class="btn btn-sm ml-2">Ok</button>
                        </div>
                    </li>
                    </ul>
                </div> <!-- col.// -->
        </div> <!-- row.// -->
    </form>
        </div> <!-- card-body .// -->
    </div> <!-- card.// -->
    
    <div class="padding-y-sm">
    <span>{{ $category->products->count() }} results for "{{ $category->name }}"</span>	
    </div>
    
    <div class="row-sm">
        @foreach ($category->products as $product)
        <div class="col-md-3 col-sm-6">
            @auth
                @if($product->hasShop() && auth()->user()->can('create product'))
                    <div class="addProduct text-right">
                        <button data-id="{{ $product->id }}" class="btn btn-outline-success text-secondary btn-sm circle addProductBtn" type="button" data-toggle="modal" data-target="#addProductModel">
                            <i class="fa fa-plus"></i>
                        </button>
                    </div>
                @endif
            @endauth
            <figure class="card card-product">
                <div class="img-wrap"> <img src="@if($product->image){{ $product->image->url }}@else https://via.placeholder.com/300x220.png?text=No+Image @endif"></div>
                <figcaption class="info-wrap">
                    <a href="{{ $product->slug() }}" class="title">{{ $product->name }}</a>
                    <div class="price-wrap">
                        Starting at <span class="text-success">{{ $product->monySign() }}{{ $product->lowestPrice()['price'] }}</span> in {{ $product->lowestPrice()['count'] }} shops.
                    </div> <!-- price-wrap.// -->
                </figcaption>
            </figure> <!-- card // -->
        </div> <!-- col // -->
        @endforeach
    </div> <!-- row.// -->
    
    
    </div><!-- container // -->
    </section>
    <!-- ========================= SECTION CONTENT .END// ========================= -->

    @auth
    @if(auth()->user()->can('create product'))
        <div class="modal fade show" id="addProductModel" tabindex="-1" role="dialog" aria-labelledby="addProductModel" aria-modal="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add this product to your shop.</h4>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-4" id="model-product-img">
                            {{-- jQuery Will add the image here --}}
                        </div>
                        <div class="col-sm-8">
                            <h4 id="model-product-name" class="mb-2"></h4>
                            <form method="POST" id="SubForm" action="{{ route('home.products.store') }}">
                                @csrf
                                <input type="hidden" name="product" value="">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text">Shop</span></div>
                                        <select class="form-control" name="shop" id="shop_options">
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text">Price</span></div>
                                        <input class="form-control" id="amounts" type="number" name="amounts" placeholder="00.000" required>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                    <button id="subBtn" class="btn btn-primary" type="button">Save</button>
                </div>
                </div>
                <!-- /.modal-content-->
            </div>
            <!-- /.modal-dialog-->
        </div>
    @endif
@endauth


    @include('helpers.subscribe')
    @include('helpers.footer')

@endsection
