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
                    <div class="card-header">My Products</div>
                    <div class="card-body">
                        @if(!blank(auth()->user()->prices))
                        Your products
                        @else
                        <p class="text-dark">
                            You doesn't have any product yet.
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
