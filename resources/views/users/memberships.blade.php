@extends('layouts.app')
@section('title')
    Your available products
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
                    <div class="card-header">
                        Membership plans
                    </div>
                    <div class="card-body">
                        @if(!blank($memberships))
                        <div class="row-sm">
                            @foreach ($memberships as $membership)
                                <div class="col-md-4">
                                    <figure class="card card-product">
                                        <div class="img-wrap"> 
                                            @if(!blank($membership->image))
                                                <img src="{{ $membership->image->url }}" alt="{{ $membership->name }}">
                                            @endif
                                        </div>
                                        <figcaption class="info-wrap">
                                            <h6 class="title ">Golden Membership</h6>
                                            <div class="price-wrap">
                                                <span class="price-new">
                                                    <span class="text-success">{{ $moneySing.$membership->price }}</span>
                                                </span>
                                            </div> <!-- price-wrap.// -->
                                            <hr>
                                            You can add {{ $membership->shop_limit }} shops.
                                            <hr>
                                            <button class="btn btn-success">Buy Now!</button>
                                        </figcaption>
                                    </figure> <!-- card // -->
                                </div> <!-- col // -->
                            @endforeach
                        </div>
                        @else
                        <p class="text-dark">
                            No memberships are available now!
                        </p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('helpers.subscribe')
    @include('helpers.footer')
@endsection
