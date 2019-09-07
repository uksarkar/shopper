@extends('layouts.app')
@section('title')
    Ditails of {{ $shop->name }}
@endsection
@section('content')
    @include('helpers.header')
<!-- ========================= SECTION TOPBAR ========================= -->
<section class="section-topbar border-top padding-y-sm">
        <div class="container">
            <span>Ditails of {{ $shop->name }}</span>
        </div> <!-- container.// -->
        </section>
        <!-- ========================= SECTION TOPBAR .// ========================= -->
        
        <!-- ========================= SECTION CONTENT ========================= -->
        <section class="section-content bg padding-y-sm">
        <div class="container">
        <nav class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('home.account.index') }}">My account</a></li>
            <li class="breadcrumb-item"><a href="{{ route('home.account.shops') }}">Your shops</a></li>
            <li class="breadcrumb-item active"><a href="{{ route('home.shops.show',$shop->id) }}">{{ $shop->name }}</a></li>
        </ol>  
        </nav>

        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-5">
                        <div class="card">
                            <div class="card-body">
                                <img style="width:100%" src="@isset($shop->image){{ $shop->image->url }}@endisset" alt="{{ $shop->name }}">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-7">
                        <div class="card bg-light">
                            <div class="card-header">
                                Name: {{ $shop->name }}
                            </div>
                            <div class="card-body">
                                <table class="table table-responsive-sm">
                                    <tbody>
                                        <tr>
                                        <td><i class="fa fa-map-marker-alt"></i>  Location</td>
                                        <td>: {{ $shop->location }}</td>
                                        </tr>
                                        <tr>
                                        <td><i class="fa fa-clock"></i>  Created at</td>
                                        <td>: @if(!blank($shop->created_at)){{ $shop->created_at->diffForHumans() }}@endif</td>
                                        </tr>
                                        <tr>
                                        <td><i class="fa fa-history"></i>  Last update</td>
                                        <td>: @if(!blank($shop->updated_at)){{ $shop->updated_at->diffForHumans() }}@endif</td>
                                        </tr>
                                        <tr>
                                        <td><i class="fa fa-sort-numeric-down"></i>  Total products</td>
                                        <td>: {{ $shop->prices->count() }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            @if(auth()->id() === $shop->user_id)
                            <div class="card-footer text-right">
                                <a href="{{ route('home.shops.edit', $shop->id) }}" class="btn btn-secondary">Edit shop</a>
                                <button class="btn btn-danger">Delete Shop</button>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">Shop Descriptions</div>
            <div class="card-body">
                {!! $shop->description !!}
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">
                Shop products
                @if(!blank($shop->prices) && auth()->id() === $shop->user_id)
                    <a href="/" class="btn btn-success btn-sm float-right">
                        <i class="fa fa-plus"></i> Add new product
                    </a>
                @endif
            </div>
            <div class="card-body">
                @if(blank($shop->prices))
                    There is no product is added to this shop. <br><br>
                    @if(auth()->id() === $shop->user_id)
                        <a href="/" class="btn btn-success btn-sm">
                            <i class="fa fa-plus"></i> Add product now
                        </a>
                    @endif
                @else 
                    <table class="table table-responsive-sm table-hover table-outline mb-0">
                        <thead class="thead-light">
                        <tr>
                            <th class="text-center"><i class="icon-picture"></i> Image</th>
                            <th>Product Name</th>
                            <th>Price</th>
                            <th>Created at</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($shop->prices as $price)
                            <tr>
                                <td class="text-center">
                                    <div class="thumbnail"><img class="img img-thumbnail" src="@if($price->product->image) {{ $price->product->image->url }} @else https://via.placeholder.com/100x100.png?text=No+Image @endif" width="100" alt="{{ $price->product->name }}"></div>
                                </td>
                                <td>
                                    <a href="/">{{ $price->product->name }}</a>
                                </td>
                                <td>
                                    <p class="bg-light p-1 rounded">{{ $price->amounts }}</p>
                                </td>
                                <td>
                                    {{  $price->created_at->diffForHumans() }}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
        
        </div><!-- container // -->
        </section>
        <!-- ========================= SECTION CONTENT .END// ========================= -->
        
    @include('helpers.subscribe')
    @include('helpers.footer')
@endsection