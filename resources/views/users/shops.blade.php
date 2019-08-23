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
                                            <br>
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
                                              <dt>Brance</dt>
                                              <dd>0</dd>
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
