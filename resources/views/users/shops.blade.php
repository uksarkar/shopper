@extends('layouts.app')
@section('title')
    Your Shops
@endsection
@section('content')
<!-- Start main container -->
@include('users.sidebar')
<div class="container mx-auto mt-2 min-h-screen rounded bg-white p-2">
    <div class="bg-white">
        <h1>
            Shops
            @if (auth()->user()->can('create shop'))
            <a href="{{ route('home.shops.create') }}" class="float-right text-base bg-green-700 rounded p-1 text-white m-1">
                Add new shop
            </a>
            @endif
        </h1>
        <hr />
        @if(!blank(auth()->user()->shops))
            @foreach (auth()->user()->shops as $shop)
                <div class="flex flex-wrap border-b border-gray-400 rounded m-1 p-2">
                    <div class="w-full md:w-3/12 flex items-center justify-center border-r border-gray-400">
                    <img class="h-16" src="@if(!blank($shop->image)){{ $shop->image->url }}@endif" />
                    </div>
                    <div class="w-full md:w-7/12">
                    <h2 class="ml-2">{{ $shop->name }}</h2>
                    <p class="p-2 text-xs text-gray-600">
                        @if(!blank($shop->prices)){{ count($shop->prices) }} Products @else No Product @endif
                    </p>
                    </div>
                    <div class="w-full md:w-2/12 text-right relative">
                        <button @click="showTooltips($event)" title="options" data-options="btn" class="px-2 relative z-10 bg-gray-200 focus:outline-none border border-transparent transition-250 rounded hover:border-blue-800">
                            <i class="fa fa-ellipsis-v relative z-m1" aria-hidden="true"></i>
                        </button>
                        <div class="hidden bg-white text-left right-0 absolute z-20 border border-gray-300 shadow-md rounded p-2 m-1 options">
                            <ul>
                                <li class="cursor-pointer border-b border-gray-400 hover:text-green-700 transition-250">
                                    <a href="{{ route('home.shops.show',$shop->id) }}">View details</a>
                                </li>
                                <li class="cursor-pointer hover:text-green-700 transition-250">
                                    <a href="{{ route('home.shops.edit', $shop->id) }}">Edit details</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>
<!-- End main container -->
@endsection
