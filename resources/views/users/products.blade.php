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
                        
                        <table class="table table-responsive-sm table-hover table-outline mb-0">
                            <thead class="thead-light">
                            <tr>
                                <th class="text-center"><i class="icon-picture"></i> Image</th>
                                <th>Product Name</th>
                                <th>Actions</th>
                                <th>Your Price</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach(auth()->user()->prices as $price)
                                    <tr>
                                        <td class="text-center">
                                            <div class="thumbnail"><img class="img img-thumbnail" src="@if($price->product->image) {{ $price->product->image->url }} @else https://via.placeholder.com/100x100.png?text=No+Image @endif" width="100" alt="image"></div>
                                        </td>
                                        <td>
                                            <div>{{ $price->product->name }}</div>
                                            <div class="small text-muted">Created: {{ $price->product->created_at->diffForHumans() }}</div>
                                        </td>
                                        <td>
                                            <a href="/" class="btn btn-sm btn-primary">View</a>
                                            <a href="/" class="btn btn-sm btn-info">Edit</a>
                                            <button data-sub="e{{ $price->product->id }}" class="btn btn-danger btn-sm subbtn">Delete</button>
                                            <form data-sub="e{{ $price->product->id }}" class="formsub" method="POST" action="/">@csrf @method("DELETE")</form>
                                        </td>
                                        <td>
                                            {{-- {{  Str::limit($price->product->description, 70, ' (...)') }} --}}
                                            {{ $price->amounts }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
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
