@extends('layouts.app')
@section('title')
    Your available products
@endsection
@section('content')
<!-- Start main container -->
@include('users.sidebar')
<div class="container mx-auto mt-2 rounded bg-white p-2 min-h-screen">
    <h1>My Products</h1>
    <hr />
    @if(!blank($products))
    @foreach($products as $product)
    <div class="flex border-b border-gray-400 rounded m-1 p-2">
        <div class="w-3/12 flex items-center justify-center">
        <img class="h-16" src="@if($product->image) {{ $product->image->url }} @else https://via.placeholder.com/100x100.png?text=No+Image @endif" alt="{{ $product->name }}" />
        </div>
        <div class="w-7/12">
            <h2 class="ml-2">{{ $product->name }}</h2>
            <small class="ml-2 text-gray-600">
                In {{ count($product->prices) }} shops.
            </small>
            
            @foreach ($product->prices as $price)
            <div
                class="flex items-center justify-center border-b border-gray-500 p-2 m-2 hover:bg-gray-100"
            >
                <div class="w-10/12">
                    <a href="{{ route('home.shops.show',$price->shop->id) }}">
                        {{ $price->shop->name }}
                    </a>
                </div>
                <div class="w-2/12">
                <button
                    class="rounded-full w-6 h-6 bg-blue-500 focus:outline-none text-white text-xs"
                    @click="editPrice({{ $price.','.$price->getAvailableVariants() }})"
                >
                    <i class="fas fa-edit"></i>
                </button>
                <form class="inline" method="POST" action="{{ route("home.products.destroy",$price->id) }}">@csrf @method("DELETE")
                <button
                    class="rounded-full w-6 h-6 bg-red-700 focus:outline-none text-white text-xs"
                >
                    <i class="fas fa-trash-alt"></i>
                </button>
                </form>
                </div>
            </div>
            @endforeach

        </div>
        <div class="w-2/12 text-right relative">
            <button title="options" data-options="btn" class="px-2 relative z-10 bg-gray-200 focus:outline-none border border-transparent transition-250 rounded hover:border-blue-800">
                <i class="fa fa-ellipsis-v relative z-m1" aria-hidden="true"></i>
            </button>
            <div class="hidden bg-white right-0 absolute z-20 border border-gray-300 shadow-md rounded p-2 m-1 options">
                <ul>
                    <li class="cursor-pointer hover:text-green-700 transition-250">
                        <a href="{{ $product->slug() }}">View Product</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    @endforeach
    @else
    <p class="text-gray-500 p-5">
        @if(auth()->user()->shops->count() > 0 && auth()->user()->can('create product'))
            You doesn't have any product yet. <br> <br>
            <p class="bg-light px-5 py-2 mt-3 my-auto">
                Search products and click the plus button to add it.
            </p>
        @else 
            You doesn't have any product yet.
        @endif
    </p>
    @endif
</div>
<!-- End main container -->

  <!-- Start Model -->
<transition name="fade">
<div class="overflow z-40" v-if="showModel">
<div class="bg-white rounded w-6/12 px-10">
    <h1>Add product to your shop</h1>
    <hr />
    <div class="flex py-2 max-h-screen overflow-y-auto">
    <div class="w-8/12 pl-6">
        <form method="POST" ref="editPrice" action="{{ route('home.products.update') }}">
            @csrf
            @method("PATCH")
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
            
              <div class="mt-2 w-full" v-for="(variant,index) in variantsForEdit" :key="index">
                <label
                  class="bg-gray-100 p-1 pr-0 border border-gray-200 inline-block min-w-full"
                  for="price"
                >
                  <span v-text="variant.variant_name"></span>
                  <input
                    class="p-1 bg-white rounded w-auto border border-transparent focus:border-primary-normal"
                    type="number" :name="'variants['+variant.id+']'"
                    placeholder="00.000"
                    :value="variant.price"
                  />
                </label>
              </div>

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
            <input type="hidden" name="product" :value="productId">
            <input type="hidden" name="price" :value="details.priceId">
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
        :disabled="tabs == 9"
        @click="$refs.editPrice.submit(), tabs = 9"
    >
    <i v-if="tabs == 9" class="fa fa-circle-notch fa-spin"></i>
        Submit
    </button>
    </div>
</div>
</div>
</transition>
<!-- End Model -->

@endsection
