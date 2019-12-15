@extends('layouts.app')
@section('title')
    Ditails of {{ $product->name }}
@endsection
@section('content')
      <!-- Start main container -->
      <div class="container mx-auto mt-20 min-h-screen">
            <div class="flex flex-wrap bg-white max-w-6xl mx-auto rounded p-3">
              <div class="sm:w-5/12 w-full">
                <div
                  class="big-preview my-6 p-4 cursor-pointer"
                  @click="previewImage=true, previewImageUrl='@isset($product->image){{ $product->image->url }}@endisset'"
                >
                  <img src="@isset($product->image){{ $product->image->url }}@endisset" alt="" />
                </div>
                
                @if(!blank($product->photos))
                <div class="flex items-center justify-center mt-5">
                    @foreach ($product->photos as $photo)
                    <div
                      class="w-1/6 border bg-grey-300 rounded hover:shadow-outline mr-2 cursor-pointer transition-250 transition-all"
                      @click="previewImage=true, previewImageUrl='{{ $photo->path }}'"
                    >
                      <img src="{{ $photo->path }}" alt="" />
                    </div>
                    @endforeach
                </div>
                @endif
              </div>
              <div class="sm:w-7/12 w-full">
                <h1 class="mt-3 sm:mt-0">
                    {{ $product->name }}
                </h1>
                <hr />
                <input type="hidden" name="vue-product-id" ref="theProductId" value="{{ $product->id }}">
                <div class="flex items-center justify-center p-1 md:p-5">
                  <div class="md:w-3/12 w-4/12">
                    <h3 class="text-sm sm:text-base">
                      Lowest price :
                    </h3>
                  </div>
                  <div class="md:w-3/12 w-4/12">
                    <var class="text-primary-dark md:text-2xl sm:font-extrabold">
                            @if($product->price)
                                {{ $product->price . " ". $moneySign }}
                                <span class="text-xs text-gray-500 font-normal px-2 rounded border border-gray-500">
                                  {{ $product->variant }}
                                </span>
                            @else
                                {{ $product->expected_price . " ". $moneySign }}
                            @endif
                        
                    </var>
                  </div>
                  <div class="md:w-6/12 w-4/12 flex items-center justify-center">
                    @if(!blank($product->prices))
                        <a class="rounded-full shadow bg-primary-normal px-1 md:px-4 py-1 md:py-2 text-white hover:bg-primary-dark transition-250" href="/shops/fixthis"> <i class="fa fa-envelope"></i> Contact Shop </a>
                    @endif
                  </div>
                </div>
                <hr />
                <p class="p-5">
                    {!! $product->short_description !!}
                </p>
              </div>
            </div>
            <!-- Start specifications -->
            <div class="flex flex-wrap max-w-6xl mt-5 mx-auto overflow-hidden">
              <div
                class="my-1 cursor-pointer border-r border-gray-500 sm:text-lg hover:text-blue-700 transition-250 px-1 w-1/2 p-2 sm:p-5 overflow-hidden text-center"
                @click="tabs = 1"
                :class="tabs === 1 ? 'bg-gray-300 text-green-700':'bg-white'"
              >
                Compare Price
              </div>
    
              <div
                class="my-1 cursor-pointer sm:text-lg hover:text-blue-700 transition-250 px-1 w-1/2 p-2 sm:p-5 overflow-hidden text-center"
                @click="tabs = 2"
                :class="tabs === 2 ? 'bg-gray-300 text-green-700':'bg-white'"
              >
                Specifications
              </div>
            </div>
            <!-- ------ -->
            <div v-if="tabs === 2">
              {!! $product->description !!}
            </div>
            <!-- shops -->
            <div v-if="tabs === 1">
              <div class="shop-container" v-if="!loadFailed">
                <div class="flex items-center justify-center border-b border-gray-500 bg-white max-w-6xl mx-auto">
                  <div class="w-1/3 p-2">
                    Image
                  </div>
                  <div class="w-1/3 p-2">
                    Price By 
                    <select class="border border-gray-400" v-model="selectedVariant" @change="serializeShops(storedPrices)">
                      <option v-for="(variant,index) in productVariants" :key="variant" :value="variant" v-text="variant"></option>
                    </select>
                  </div>
                  <div class="w-1/3 p-2">
                    Link
                  </div>
                </div>

                <div class="flex justify-center items-center m-4" v-if="storedPrices.length === 0">
                  <i class="fa fa-circle-notch fa-spin fa-5x"></i>
                </div>

                <div
                  class="flex flex-wrap items-center justify-center border-b border-gray-500 bg-white max-w-6xl mx-auto"
                  v-for="(price,index) in prices"
                  :key = "index"
                >
                  <div class="w-full md:w-1/3 p-2">
                      <div class="star-block pl-2 md:mr-4 flex justify-around bg-gray-100 border border-gray-500 rounded p-2">
                        <img
                        :src="price.shop_image"
                        :alt="price.shop_name"
                        class="h-8 sm:h-12 max-w-xs"
                        />
                      <div class="text-center">
                        <div class="stars" :style="'--rating:'+price.shop_rating"></div>
                        <div class="text-gray-600">
                          <span v-text="price.shop_rating"></span>
                        </div>
                      </div>
                    </div>

                  </div>
                  <div class="w-full md:w-1/3">
                    <span 
                      class="px-1 m-1 border rounded inline-block" 
                      v-for="(variant,index) in price.variants" 
                      :key="index" 
                      v-text="variant.variant_name+': '+variant.price"
                      :class="selectedVariant === variant.variant_name ? 'text-primary-dark border-primary-dark':'text-gray-500 border-gray-500'"
                      >
                    </span>
                  </div>
                  <div class="w-full md:w-1/3 text-center">
                    <a
                    :href="price.shop_url"
                      class="rounded-full sm:w-40 shadow bg-primary-normal px-4 sm:py-2 text-white transition-250 hover:bg-primary-dark"
                    >
                      View shop
                  </a>
                  </div>
                </div>

              </div>
              <div class="flex items-center justify-center max-w-6xl mx-auto" v-else>
                Not available...
              </div>
            </div>
            <!-- End specifications -->
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