@extends('layouts.app')
@section('title')
    Mange your account
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
                    <div class="card-header">My Shops</div>
                    <div class="card-body">
                        {{-- Showing users all Shops --}}
                        @if(!blank(auth()->user()->shops))
                            @foreach (auth()->user()->shops as $shop)
                            <article class="card card-product">
                                <div class="card-body">
                                <div class="row">
                                    <aside class="col-sm-3">
                                        <div class="img-wrap"><img src="@if(!blank($shop->image)){{ $shop->image->url }}@endif"></div>
                                    </aside> <!-- col.// -->
                                    <article class="col-sm-6">
                                            <h4 class="title"> {{ $shop->name }}  </h4>
                                            <div class="rating-wrap  mb-2">
                                                <ul class="rating-stars">
                                                    <li style="width:80%" class="stars-active"> 
                                                        <i class="fa fa-star"></i> <i class="fa fa-star"></i> 
                                                        <i class="fa fa-star"></i> <i class="fa fa-star"></i> 
                                                        <i class="fa fa-star"></i> 
                                                    </li>
                                                    <li>
                                                        <i class="fa fa-star"></i> <i class="fa fa-star"></i> 
                                                        <i class="fa fa-star"></i> <i class="fa fa-star"></i> 
                                                        <i class="fa fa-star"></i> 
                                                    </li>
                                                </ul>
                                                <div class="label-rating">132 reviews</div>
                                                <div class="label-rating">154 orders </div>
                                            </div> <!-- rating-wrap.// -->
                                            <p> {{ $shop->description }} </p>
                                            <dl class="dlist-align">
                                              <dt>Location</dt>
                                              <dd>{{ $shop->location }}</dd>
                                            </dl>  <!-- item-property-hor .// -->
                                            <dl class="dlist-align">
                                              <dt>Products</dt>
                                              <dd>@if(!blank($shop->products)){{ count($shop->products) }}@else No Product @endif</dd>
                                            </dl>  <!-- item-property-hor .// -->
                                            <dl class="dlist-align">
                                              <dt>Delivery</dt>
                                              <dd>Russia, USA, and Europe</dd>
                                            </dl>  <!-- item-property-hor .// -->
                                        
                                    </article> <!-- col.// -->
                                    <aside class="col-sm-3 border-left">
                                        <div class="action-wrap">
                                            <p class="text-success">Free shipping</p>
                                            <br>
                                            <p>
                                                <a href="#" class="btn btn-primary"> Edit </a>
                                                <a href="#" class="btn btn-secondary"> Details  </a>
                                            </p>
                                            <a href="#"><i class="fa fa-heart"></i> Add to wishlist</a>
                                        </div> <!-- action-wrap.// -->
                                    </aside> <!-- col.// -->
                                </div> <!-- row.// -->
                                </div> <!-- card-body .// -->
                            </article>
                            @endforeach
                        @else
                        <p class="text-dark">
                            You doesn't have any shop yet.
                        </p>
                        @endif
                        {{-- End Shops --}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('helpers.subscribe')
    @include('helpers.footer')
@endsection
