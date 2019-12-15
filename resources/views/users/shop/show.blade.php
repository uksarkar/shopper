@extends('layouts.app')
@section('title')
    Details of {{ $shop->name }}
@endsection
@section('content')

      <!-- Start main container -->
      <div class="container mx-auto mt-20">
        <div class="flex flex-wrap bg-white max-w-6xl mx-auto rounded p-3">
          <div class="sm:w-5/12 w-full">
            <div
              class="big-preview my-6 p-4 cursor-pointer"
              @click="previewImage=true, previewImageUrl='@isset($shop->image){{ $shop->image->url }}@endisset'"
            >
              <img src="@isset($shop->image){{ $shop->image->url }}@endisset" alt="{{ $shop->name }}" />
            </div>
          </div>
          <div class="sm:w-7/12 w-full">
            <h1 class="mt-3 sm:mt-0">
                {{ $shop->name }}
            </h1>
            <hr />
            <div class="flex flex-wrap p-2">
              <div class="w-5/12 border-b border-gray-600 p-2">
                <i class="fa fa-map-marker-alt"></i>  Website
              </div>
              <div class="w-2/12 border-b border-gray-600 p-2">:</div>
              <div class="w-5/12 border-b border-gray-600 p-2">
                {{ $shop->url }}
              </div>
              <div class="w-5/12 border-b border-gray-600 p-2">
                <i class="fa fa-clock"></i>  Created at
              </div>
              <div class="w-2/12 border-b border-gray-600 p-2">:</div>
              <div class="w-5/12 border-b border-gray-600 p-2">
                @if(!blank($shop->created_at)){{ $shop->created_at->diffForHumans() }}@endif
              </div>

              <div class="w-5/12 border-b border-gray-600 p-2">
                <i class="fa fa-history"></i>  Last update
              </div>
              <div class="w-2/12 border-b border-gray-600 p-2">:</div>
              <div class="w-5/12 border-b border-gray-600 p-2">
                @if(!blank($shop->updated_at)){{ $shop->updated_at->diffForHumans() }}@endif
              </div>

              <div class="w-5/12 border-b border-gray-600 p-2">
                <i class="fa fa-sort-numeric-down"></i>  Total products
              </div>
              <div class="w-2/12 border-b border-gray-600 p-2">:</div>
              <div class="w-5/12 border-b border-gray-600 p-2">
                {{ $shop->prices->count() }}
              </div>

            </div>
            <div class="text-right mt-2">
              @if(auth()->id() === $shop->user_id)
                <a href="{{ route('home.shops.edit', $shop->id) }}" class="bg-green-700 py-1 px-3 text-white rounded-full m-2">Edit shop</a>
                <a href="#" @click.prevent="$refs.delete.submit()" class="bg-red-700 py-1 px-3 text-white rounded-full m-2">Delete Shop</a>
                <form ref="delete" action="{{ route('home.shops.destroy',$shop->id) }}" method="post">
                  @csrf
                  @method('DELETE')
                </form>
              @endif
            </div>
          </div>
        </div>
        <div class="bg-white max-w-6xl mx-auto rounded mt-4 p-3">
          <h2>Shop products</h2>
          <hr>
          @if(blank($shop->prices))
              There is no product added to this shop. <br><br>
          @else 

          @foreach($shop->prices as $price)
          <div class="flex items-center justify-center border-b border-gray-500 mb-2">
            <div class="w-4/12 p-3">
              <img class="w-10" src="@if($price->product->image) {{ $price->product->image->url }} @else https://via.placeholder.com/100x100.png?text=No+Image @endif" width="100" alt="{{ $price->product->name }}">
            </div>
            <div class="w-6/12">
              <a class="text-green-700 hover:text-blue-500 transition-250" href="{{ $price->product->slug() }}">{{ $price->product->name }}</a>
            </div>
            <div class="w-2/12">
              {{ $price->amounts }}
            </div>
          </div>
          @endforeach

          @endif
        </div>
      </div>
      <!-- End main container -->
          <!-- Image view model -->
          <transition name="fade">
            <div class="overflow" v-if="previewImage">
              <div class="block">
                <img class="max-w-full max-h-full" :src="previewImageUrl" alt="" />
                <button
                  class="times-btn focus:outline-none"
                  @click="previewImage = false"
                >
                  <svg
                    height="30"
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 384 512"
                  >
                    <path
                      d="M323.1 441l53.9-53.9c9.4-9.4 9.4-24.5 0-33.9L279.8 256l97.2-97.2c9.4-9.4 9.4-24.5 0-33.9L323.1 71c-9.4-9.4-24.5-9.4-33.9 0L192 168.2 94.8 71c-9.4-9.4-24.5-9.4-33.9 0L7 124.9c-9.4 9.4-9.4 24.5 0 33.9l97.2 97.2L7 353.2c-9.4 9.4-9.4 24.5 0 33.9L60.9 441c9.4 9.4 24.5 9.4 33.9 0l97.2-97.2 97.2 97.2c9.3 9.3 24.5 9.3 33.9 0z"
                    />
                  </svg>
                </button>
              </div>
            </div>
          </transition>
          <!-- End image view Model -->
          <br>
@endsection