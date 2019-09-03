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
                        My Products
                        @if(auth()->user()->shops->count() > 0 && auth()->user()->prices->count() > 0 && auth()->user()->can('create product'))
                            <a href="{{ route('home.products.create') }}" class="btn btn-sm btn-success float-right"><i class="fa fa-plus"></i> Add new products</a>
                        @endif
                    </div>
                    <div class="card-body">
                        @if(!blank(auth()->user()->prices))
                        Your products
                        @else
                        <p class="text-dark">
                            @if(auth()->user()->shops->count() > 0 && auth()->user()->can('create product'))
                                You doesn't have any product yet. <br> <br>
                                <a href="{{ route('home.products.create') }}" class="btn btn-sm btn-success"><i class="fa fa-plus"></i> Add products</a>
                            @else 
                                You doesn't have any shop yet.
                            @endif
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
