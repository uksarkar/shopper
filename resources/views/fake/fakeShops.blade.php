@extends('layouts.app')
@section('title')
    Search result of {{ old('name') }}
@endsection
@section('content')
<!-- Start main container -->
<div class="container mx-auto mt-20 min-h-screen">
    <div
      class="w-full rounded-sm border border-gray-300 mb-4 bg-white p-4"
    >
      <form action="/fake-shops" method="get" class="flex items-center justify-center mb-4">
        <input value="{{ old('q') }}" placeholder="Shop name..." class="w-1/3 bg-gray-100 text-grey-500 shadow focus:shadow-md border focus:border-primary-normal transition-250 py-2 px-4 rounded-full focus:outline-none" type="search" name="q">
        <button class="mx-4 px-4 py-2 shadow rounded-full border hover:shadow-md focus:outline-none hover:text-primary-dark hover:border-info-normal transition-250" type="submit">
          Search
        </button>
      </form>
      <hr>
      @if(!blank($shops))
      <div class="m-1 p-2">
        @foreach ($shops as $shop)
          <div
            class="flex flex-wrap items-center justify-center border-b border-grey-100 bg-white max-w-6xl mx-auto"
          >
            <div class="w-full md:w-1/3 p-2">
                <div class="star-block pl-2 md:mr-4 flex justify-between p-2">
                  <img
                  src="{{ $shop->image->url }}"
                  alt="{{ $shop->name }}"
                  class="h-8 sm:h-12 max-w-xs"
                  />
                <div class="text-center">
                  <div class="stars" style="--rating:@if(!blank($rate = $shop->reviews()->avg('rating'))) {{ number_format($rate, 2) }}@else 0 @endif"></div>
                  <div class="text-gray-600">
                    @if(!blank($rate))
                      {{ number_format($rate, 2) }}
                    @else 
                      0.00
                    @endif
                  </div>
                </div>
              </div>

            </div>
            <div class="w-full md:w-1/3">
              <span class="px-1 m-1 border rounded text-xs text-gray-500 border-gray-500" >
                {{ $shop->name }}
              </span>
              <span class="px-1 m-1 border rounded text-xs text-gray-500 border-gray-500" >
                {{ count($shop->reviews) }} Users rate the shop.
              </span>
            </div>
            <div class="w-full md:w-1/3 text-center">
              <a href="{{ route("view-shop",$shop->id) }}"
                class="rounded-full sm:w-40 shadow bg-primary-normal px-4 sm:py-2 text-white transition-250 hover:bg-primary-dark"
              >
                View shop
            </a>
            </div>
          </div>
        @endforeach
      </div>
      <!-- Start pagination -->
      {{ $shops->links() }}
      <!-- End pagination -->
      @elseif($shops === null)
      <div class="m-1 p-2 text-center">
        <span class="text-gray-500">
          Please provide valid shop name to search shops...
        </span>
      </div>
      @else
      <div class="m-1 p-2 text-center">
        <span class="text-red-300">
          No result found for name <strong>"{{ old('q') }}"</strong>
        </span>
      </div>
      @endif
    </div>
    <!-- End List -->
  </div>
  <!-- End main container -->
  <!-- End Model -->
@endsection
