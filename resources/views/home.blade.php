@extends('layouts.app')

@section('content')
      <!-- Start caption content -->
      <div
        class="container mt-5 min-w-full min-h-screen flex items-center justify-center top-bg-full"
        style = "background-image: url({{ asset('assets/images/bg.jpg') }});"
      >
          <div class="flex-grow container mx-auto sm:px-4 pt-6 pb-8">
            <div
              class="flex flex-wrap items-center justify-center overflow-hidden p-10"
            >
            <div class="bg-white middle-bg rounded-full flex flex-wrap items-center justify-center overflow-hidden px-16 py-5 text-2xl">
              <a class="mx-4" href="/" v-for="index in 5">
                <i class="fa fa-desktop middle-button" aria-hidden="true"></i>
                <span class="text-sm block">Desktop</span>
              </a>
            </div>
          </div>
        </div>
      </div>
      <!-- End caption content -->
      <!-- Start main container -->
      <div class="container mx-auto">
        <!-- Start info caption -->
        <div class="hidden lg:block steps-container mt-2">
          <div class="steps">
            <span
              ><img src="./assets/shipping1.png" alt="" />
              <span>
                Search Products
              </span>
            </span>
          </div>
          <div class="steps">
            <span
              ><img src="./assets/shipping2.png" alt="" /><span
                >Compare Price</span
              ></span
            >
          </div>
          <div class="steps">
            <span
              ><img src="./assets/shipping3.png" alt="" /><span
                >Rate Shops</span
              ></span
            >
          </div>
          <div class="steps">
            <span
              ><img src="./assets/shipping4.png" alt="" /><span
                >Happy Shopping</span
              ></span
            >
          </div>
        </div>
        <!-- End info caption -->
        <!-- Start compare caption -->
        <div class="flex items-center justify-center my-20">
          <div class="w-2/6 bg-indigo-500 h-48 mx-5">
            Left side
          </div>
          <div class="w-4/6 bg-indigo-500 h-48 mx-5">
            Right side
          </div>
        </div>
        <!-- End compare caption -->
        <h1 class="md:text-4xl font-semibold my-6 text-center">
          Recommended Products
        </h1>

        <!-- Start product grid -->
        <div class="flex flex-wrap items-stretch overflow-hidden">
          @if (!blank($items))
          @foreach ($items->products as $product)
          <div class="w-full overflow-hidden md:w-1/3 lg:w-1/3 bg-white rounded py-1 m-2 overflow-hidden shadow transition-250 hover:shadow-lg">
            <div
              class="flex max-w-sm"
            >
              <div class="w-5/12 flex items-center justify-center">
                <img
                  src="@isset($product->image){{ $product->image->url }}@endisset"
                  alt="{{ $product->name }}"
                />
              </div>
              <div class="w-7/12">
                <div class="px-1 py-4 font-bold text-base mb-2">
                  {{ $product->name }}
                </div>
                @if(!blank($lowest = $product->prices()->orderBy('amounts','desc')->limit(2)->get()))
                  @foreach ($lowest as $prod)
                  <p class="m-1 text-sm">
                    {{ $prod->shop->name }}
                    <span class="text-green-500 font-semibold">{{ $prod->amounts." ".$moneySign }}</span>
                  </p>
                  @endforeach
                  @if(count($lowest) == 1)
                  <p class="m-1 text-sm">
                    <span class="text-green-500 font-semibold">&nbsp;</span>
                  </p>
                  @endif
                @endif
                <div
                  class="p-1 bg-info-normal text-white text-center cursor-pointer transition-250 hover:bg-info-darkest rounded m-2"
                >
                  <a class="block" href="{{ $product->slug() }}">Compare now</a>
                </div>
              </div>
            </div>
          </div>
          @endforeach
          @endif
        </div>
        <!-- End product grid -->
      </div>
      <!-- End main container -->
      <div class="container min-w-full mt-6">
        <div
        class="bg-white text-gray-900 mt-5 py-8 rounded shadow text-center"
      >
        <div
          class="bg-indigo-400 mt-6 px-10 lg:mx-40 mx-5 lg:flex lg:items-center lg:justify-center"
        >
          <div class="sm:w-2/6 p-4">
            <img
              class="w-64 h-64"
              src="https://damjanun.com/_nuxt/img/905b2fb.png"
              alt=""
            />
          </div>
          <div class="sm:w-4/6 text-left">
            <h1 class="text-3xl font-bold">
              Find & Compare Millions of Products all in one spot.
            </h1>
            <p>
              Thousands of product information and hundreds of merchants with
              different prices are available for you. Search product name or
              browse categories then compare prices and get the best one with
              lowest price.
            </p>
          </div>
        </div>
      </div>
      </div>
@endsection
