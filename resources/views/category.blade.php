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
        <div class="col-md-3-24 text-right"> 
         <a href="#" data-toggle="tooltip" title="List view"> <i class="fa fa-bars"></i></a>
         <a href="/{{ $category->slug }}" data-toggle="tooltip" title="Grid view"> <i class="fa fa-th"></i></a>
        </div> <!-- col.// -->
    </div> <!-- row.// -->
    <hr>
    <div class="row">
        <div class="col-md-3-24"> <strong>Filter by:</strong> </div> <!-- col.// -->
        <div class="col-md-21-24"> 
            <ul class="list-inline">
              <li class="list-inline-item"><a href="#">Product type</a></li>
              <li class="list-inline-item"><a href="#">Brand name</a></li>
              <li class="list-inline-item"><a href="#">Color</a></li>
              <li class="list-inline-item"><a href="#">Size</a></li>
              <li class="list-inline-item">
                  <div class="form-inline">
                      <label class="mr-2">Price</label>
                    <input class="form-control form-control-sm" placeholder="Min" type="number">
                        <span class="px-2"> - </span>
                    <input class="form-control form-control-sm" placeholder="Max" type="number">
                    <button type="submit" class="btn btn-sm ml-2">Ok</button>
                </div>
              </li>
            </ul>
        </div> <!-- col.// -->
    </div> <!-- row.// -->
        </div> <!-- card-body .// -->
    </div> <!-- card.// -->
    
    <div class="padding-y-sm">
    <span>{{ $category->products->count() }} results for "{{ $category->name }}"</span>	
    </div>
    
    <div class="row-sm">
        @foreach ($category->products as $product)
        <div class="col-md-3 col-sm-6">
            <figure class="card card-product">
                <div class="img-wrap"> <img src="@if($product->image){{ $product->image->url }}@else https://via.placeholder.com/300x220.png?text=No+Image @endif"></div>
                <figcaption class="info-wrap">
                    <a href="{{ $product->slug() }}" class="title">{{ $product->name }}</a>
                    <div class="price-wrap">
                        Starting at <span class="text-success">{{ $product->monySing() }}{{ $product->lowestPrice()['price'] }}</span> in {{ $product->lowestPrice()['count'] }} shops.
                    </div> <!-- price-wrap.// -->
                </figcaption>
            </figure> <!-- card // -->
        </div> <!-- col // -->
        @endforeach
    </div> <!-- row.// -->
    
    
    </div><!-- container // -->
    </section>
    <!-- ========================= SECTION CONTENT .END// ========================= -->

    @include('helpers.subscribe')
    @include('helpers.footer')
@endsection
