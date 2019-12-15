@extends('layouts.app')
@section('title')
    Search result of {{ old('name') }}
@endsection
@section('content')
<!-- Start main container -->
<div class="container mx-auto mt-20 min-h-screen">
    <div
      class="w-full rounded-sm border border-gray-400 shadow-md mb-4 bg-white p-4"
    >
      <div class="flex w-full p-2">
        <div class="w-1/6 font-bold">
          You are here :
        </div>
        <div class="w-5/6">
          <nav class="w-full">
            <ol class="list-reset flex text-gray-600">
              <li>
                <a href="{{ route('home') }}" class="text-blue font-light hover:text-teal-500 transition-250"
                  >Home</a
                >
              </li>
              <li><span class="mx-2">/</span></li>
              <li>
                <a href="{{ route('search') }}" class="text-blue font-light hover:text-teal-500 transition-250"
                  >Search</a
                >
              </li>
            </ol>
          </nav>
        </div>
      </div>
      <hr />
      <div class="flex w-full p-2">
        <div class="w-1/6 font-bold">
          Filter by :
        </div>
        <div class="w-5/6">
            <form action="{{ route('search') }}" method="get">
                <input type="hidden" name="name" value="{{ old('name') }}">
            <label for="price">Price</label>
            <input
              class="border border-gray-500 p-1 w-20 rounded focus:border-teal-700"
              type="number"
              name="min"
              value="{{ old('min') }}"
              placeholder="min"
            />
            -
            <input
              class="border border-gray-500 p-1 w-20 rounded focus:border-teal-700"
              type="number"
              name="max"
              value="{{ old('max') }}"
              placeholder="max"
            />
            <button
              class="border-0 bg-gray-300 rounded py-1 px-6 ml-5 focus:shadow-outline focus:outline-none"
            >
              OK
            </button>
          </form>
        </div>
      </div>
    </div>
    <!-- End Jumbotron -->
    <p class="text-gray-600 ml-5">
        {{ $products->count() }} results for "{{ old('name') }}" 
        @if(old('min')) and minimum price {{ old('min') }} @endif
        @if(old('max')) and maximum price {{ old('max') }} @endif
    </p>
    <!-- Start product grid -->
    <div class="flex flex-wrap overflow-hidden">
        @foreach ($products as $product)
            <div class="w-full overflow-hidden md:w-1/3 lg:w-1/4 xl:w-1/4">
                <div
                class="max-w-sm bg-white relative rounded my-2 mx-5 py-2 overflow-hidden shadow hover:shadow-lg hover:bg-blue-100"
                >
                <img
                    class="w-full h-56"
                    src="@if($product->image){{ $product->image->url }}@else https://via.placeholder.com/300x300.png?text=No+Image @endif"
                    alt="{{ $product->name }}"
                />
                @auth
                    @if($product->hasShop() && auth()->user()->can('create product'))
                    <div
                        class="absolute rounded-full cursor-pointer transition-250 bg-primary-normal hover:bg-primary-dark w-8 h-8 text-center font-extrabold text-4xl top-0 right-0"
                        @click="showModel=true,loadShops({{ $product }})"
                    >
                        <span class="plus">&#43;</span>
                    </div>
                    @endif
                @endauth
                <div class="px-6 py-4">
                    <a class="font-bold text-xl mb-2 hover:text-green-500 transition-250" href="{{ $product->slug() }}">
                        {{ $product->name }}
                    </a>
                </div>
                <div class="px-6 py-4">
                    @if($product->lowestPrice()['price'])
                        Starting at <span class="text-green-500 font-semibold">{{ $product->monySign() }}{{ $product->lowestPrice()['price'] }}</span> in {{ $product->lowestPrice()['count'] }} shops.
                    @else
                        Expecting <span class="text-green-500 font-semibold">{{ $product->monySign(). $product->expected_price }}</span>
                    @endif
                </div>
                </div>
            </div>
        @endforeach
    </div>
    <!-- End product grid -->
    <!-- Start pagination -->
    <div class="hidden flex items-center justify-center">
      <ul class="flex w-64 list-reset border border-grey-100 rounded">
        <li>
          <a
            class="block hover:text-white hover:bg-blue-500 text-blue border-r border-grey-100 px-3 py-2"
            href="#"
            >Previous</a
          >
        </li>
        <li>
          <a
            class="block hover:text-white hover:bg-blue-500 text-blue border-r border-grey-100 px-3 py-2"
            href="#"
            >1</a
          >
        </li>
        <li>
          <a
            class="block hover:text-white hover:bg-blue-500 text-blue border-r border-grey-100 px-3 py-2"
            href="#"
            >2</a
          >
        </li>
        <li>
          <a
            class="block text-white bg-blue-500 border-r border-blue-500 px-3 py-2"
            href="#"
            >3</a
          >
        </li>
        <li>
          <a
            class="block hover:text-white hover:bg-blue-500 text-blue-500 px-3 py-2"
            href="#"
            >Next</a
          >
        </li>
      </ul>
    </div>
    <!-- End pagination -->
  </div>
  <!-- End main container -->
  
  <!-- Start Model -->
  <transition name="fade">
    <div class="overflow" v-if="showModel">
      <div class="bg-white rounded w-6/12 px-10">
        <h1>Add product to your shop</h1>
        <hr />
        <div class="flex py-2">
          <div class="w-4/12">
            <img
              class="select-none pointer-events-none"
              :src="previewImage"
              alt=""
            />
          </div>
          <div class="w-8/12 pl-6">
            <form method="POST" ref="addproduct" action="{{ route('home.products.store') }}">
              @csrf
            <div class="relative">
              <select
                class="block appearance-none w-full cursor-pointer bg-gray-100 border border-gray-200 text-gray-700 py-3 px-4 pr-8 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                id="grid-state" name="shop"
                :disabled="shops.length === 0"
              >
                <option v-for="shop in shops" :value="shop.id" :key="shop.id" v-text="shop.name"></option>
              </select>
              <i v-if="shops.length === 0" class="fa fa-circle-notch fa-spin absolute" style="top:17px"></i>
              <div
                class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700"
              >
                <svg
                  class="fill-current h-4 w-4"
                  xmlns="http://www.w3.org/2000/svg"
                  viewBox="0 0 20 20"
                >
                  <path
                    d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"
                  />
                </svg>
              </div>
            </div>
            @if(!blank($variants))
              @foreach ($variants as $variant)
              <div class="mt-2 w-full">
                <label
                  class="bg-gray-100 p-1 pr-0 border border-gray-200 inline-block min-w-full"
                  for="price"
                >
                  {{ $variant->variant_name }}
                  <input
                    class="p-1 bg-white rounded w-auto border border-transparent focus:border-primary-normal"
                    type="number" name="variants[{{ $variant->id }}]"
                    placeholder="00.000"
                  />
                </label>
              </div>
              @endforeach
            @endif

            <div class="mt-2 w-full" v-for="item in addPriceCount">
              <label
                class="bg-gray-100 p-1 pr-0 border border-gray-200 inline-block min-w-full"
                for="price"
              >
                Name
                <input
                  class="p-1 bg-white rounded w-32 border border-transparent focus:border-primary-normal"
                  type="text" name="name[]"
                  placeholder="Name"
                />
                <input
                  class="p-1 bg-white rounded w-32 border border-transparent focus:border-primary-normal"
                  type="text" name="price[]"
                  placeholder="price"
                />
              </label>
            </div>
            <button type="button" @click.prevent="addPriceCount++" class="mt-2 w-full bg-gray-100 p-2">Add New</button>
            <input type="hidden" name="product" :value="productId">
          </form>
          </div>
        </div>
        <hr />
        <div class="text-right p-2">
          <button
            class="shadow-outline rounded px-5 p-1 bg-grey-100 text-white hover:bg-grey-400 ml-5"
            @click="showModel=false,shops=[]"
          >
            Cancel
          </button>
          <button
            class="shadow-outline rounded px-5 p-1 bg-blue-500 text-white hover:bg-blue-600 ml-5"
            :disabled="shops.length === 0 || showLoading"
            @click="$refs.addproduct.submit(),showLoading=true"
          >
          <i v-if="shops.length === 0 || showLoading" class="fa fa-circle-notch fa-spin"></i>
            <span v-text="shops.length === 0 ? 'Loading..':showLoading ? 'Submiting..':'Submit'"></span>
          </button>
        </div>
      </div>
    </div>
  </transition>
  <!-- End Model -->
@endsection
