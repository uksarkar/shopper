@extends('layouts.app')
@section('title')
    Your Shops
@endsection
@section('content')
    @include('helpers.header')

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-3">
                @include('helpers.accountSidebar')
            </div>
            <div class="col-sm-9">
                @if(session()->has('successMassage'))
                    <div class="alert alert-success alert-dismissible mt-2 fade show" role="alert"><strong>Success!</strong> {{ session()->get('successMassage') }}
                        <button class="close" type="button" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                    </div>
                @endif
                <div class="card mt-3">
                    <div class="card-header">
                        My Shops
                        @if (auth()->user()->can('create shop'))
                            <a href="{{ route('home.shops.create') }}" class="btn btn-sm btn-success float-right">
                                Add new shop
                            </a>
                        @endif
                    </div>
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
                                            <dl class="dlist-align">
                                              <dt>URL: </dt>
                                              <dd>{{ $shop->url }}</dd>
                                            </dl>  <!-- item-property-hor .// -->
                                            <dl class="dlist-align">
                                              <dt>Products</dt>
                                              <dd>@if(!blank($shop->products)){{ count($shop->products) }}@else No Product @endif</dd>
                                            </dl>  <!-- item-property-hor .// -->
                                        
                                    </article> <!-- col.// -->
                                    <aside class="col-sm-3 border-left">
                                        <div class="action-wrap">
                                            <p>
                                                <a href="{{ route('home.shops.edit', $shop->id) }}" class="btn btn-primary"> Edit </a>
                                                <a href="{{ route('home.shops.show',$shop->id) }}" class="btn btn-secondary"> Details  </a>
                                            </p>
                                        </div> <!-- action-wrap.// -->
                                    </aside> <!-- col.// -->
                                </div> <!-- row.// -->
                                </div> <!-- card-body .// -->
                            </article>
                            @endforeach
                        @else
                        <p class="bg-light p-1">
                            You doesn't have any shop yet.
                        </p>
                        <p>
                            @can('create shop')
                                <a href="{{ route('home.shops.create') }}" class="btn btn-success">
                                    Add your shop
                                </a>
                            @else 
                                Please upgrade your membership to add new shop.
                            @endcan
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
