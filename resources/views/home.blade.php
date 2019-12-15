@extends('layouts.app')

@section('content')
      <!-- Start caption content -->
      <div
        class="container mt-5 min-w-full min-h-screen flex items-center justify-center top-bg-full"
      >
        <div class="">
          <div class="flex-grow container mx-auto sm:px-4 pt-6 pb-8">
            <div
              class="bg-white border-t border-b sm:border-l sm:border-r sm:rounded shadow mb-6"
            >
              <div class="flex flex-wrap overflow-hidden">
                <div class="w-1/2 overflow-hidden md:w-1/6 text-center py-2">
                  <div class="border-r text-green-800">
                    <div
                      class="text-sm uppercase text-grey cursor-pointer py-5 px-12 tracking-wide"
                    >
                      <svg
                        height="30"
                        fill="#2f855a"
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 576 512"
                      >
                        <path
                          d="M528 0H48C21.5 0 0 21.5 0 48v320c0 26.5 21.5 48 48 48h192l-16 48h-72c-13.3 0-24 10.7-24 24s10.7 24 24 24h272c13.3 0 24-10.7 24-24s-10.7-24-24-24h-72l-16-48h192c26.5 0 48-21.5 48-48V48c0-26.5-21.5-48-48-48zm-16 352H64V64h448v288z"
                        />
                      </svg>
                    </div>
                    Desktop
                  </div>
                </div>
                <div class="w-1/2 overflow-hidden md:w-1/6 text-center py-2">
                  <div class="border-r text-green-800">
                    <div
                      class="text-sm uppercase text-grey cursor-pointer py-5 px-12 tracking-wide"
                    >
                      <svg
                        height="30"
                        fill="#2f855a"
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 384 512"
                      >
                        <path
                          d="M96 256V96c0-53.019 42.981-96 96-96s96 42.981 96 96v160c0 53.019-42.981 96-96 96s-96-42.981-96-96zm252-56h-24c-6.627 0-12 5.373-12 12v42.68c0 66.217-53.082 120.938-119.298 121.318C126.213 376.38 72 322.402 72 256v-44c0-6.627-5.373-12-12-12H36c-6.627 0-12 5.373-12 12v44c0 84.488 62.693 154.597 144 166.278V468h-68c-6.627 0-12 5.373-12 12v20c0 6.627 5.373 12 12 12h184c6.627 0 12-5.373 12-12v-20c0-6.627-5.373-12-12-12h-68v-45.722c81.307-11.681 144-81.79 144-166.278v-44c0-6.627-5.373-12-12-12z"
                        />
                      </svg>
                    </div>
                    Microphone
                  </div>
                </div>
                <div class="w-1/2 overflow-hidden md:w-1/6 text-center py-2">
                  <div class="border-r text-green-800">
                    <div
                      class="text-sm uppercase text-grey cursor-pointer py-5 px-12 tracking-wide"
                    >
                      <svg
                        height="30"
                        fill="#2f855a"
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 320 512"
                      >
                        <path
                          d="M272 0H48C21.5 0 0 21.5 0 48v416c0 26.5 21.5 48 48 48h224c26.5 0 48-21.5 48-48V48c0-26.5-21.5-48-48-48zM160 480c-17.7 0-32-14.3-32-32s14.3-32 32-32 32 14.3 32 32-14.3 32-32 32z"
                        />
                      </svg>
                    </div>
                    Mobile
                  </div>
                </div>
                <div class="w-1/2 overflow-hidden md:w-1/6 text-center py-2">
                  <div class="border-r text-green-800">
                    <div
                      class="text-sm uppercase text-grey cursor-pointer py-5 px-12 tracking-wide"
                    >
                      <svg
                        height="30"
                        fill="#2f855a"
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 512 512"
                      >
                        <path
                          d="M512 144v288c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V144c0-26.5 21.5-48 48-48h88l12.3-32.9c7-18.7 24.9-31.1 44.9-31.1h125.5c20 0 37.9 12.4 44.9 31.1L376 96h88c26.5 0 48 21.5 48 48zM376 288c0-66.2-53.8-120-120-120s-120 53.8-120 120 53.8 120 120 120 120-53.8 120-120zm-32 0c0 48.5-39.5 88-88 88s-88-39.5-88-88 39.5-88 88-88 88 39.5 88 88z"
                        />
                      </svg>
                    </div>
                    Camera
                  </div>
                </div>
                <div class="w-1/2 overflow-hidden md:w-1/6 text-center py-2">
                  <div class="border-r text-green-800">
                    <div
                      class="text-sm uppercase text-grey cursor-pointer py-5 px-12 tracking-wide"
                    >
                      <svg
                        height="30"
                        fill="#2f855a"
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 512 512"
                      >
                        <path
                          d="M256 32C114.52 32 0 146.496 0 288v48a32 32 0 0 0 17.689 28.622l14.383 7.191C34.083 431.903 83.421 480 144 480h24c13.255 0 24-10.745 24-24V280c0-13.255-10.745-24-24-24h-24c-31.342 0-59.671 12.879-80 33.627V288c0-105.869 86.131-192 192-192s192 86.131 192 192v1.627C427.671 268.879 399.342 256 368 256h-24c-13.255 0-24 10.745-24 24v176c0 13.255 10.745 24 24 24h24c60.579 0 109.917-48.098 111.928-108.187l14.382-7.191A32 32 0 0 0 512 336v-48c0-141.479-114.496-256-256-256z"
                        />
                      </svg>
                    </div>
                    Headphone
                  </div>
                </div>
                <div class="w-1/2 overflow-hidden md:w-1/6 text-center py-2">
                  <div class="text-green-800">
                    <div
                      class="text-sm uppercase text-grey cursor-pointer py-5 px-12 tracking-wide"
                    >
                      <svg
                        height="30"
                        fill="#2f855a"
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 640 512"
                      >
                        <path
                          d="M512 64v256H128V64h384m16-64H112C85.5 0 64 21.5 64 48v288c0 26.5 21.5 48 48 48h416c26.5 0 48-21.5 48-48V48c0-26.5-21.5-48-48-48zm100 416H389.5c-3 0-5.5 2.1-5.9 5.1C381.2 436.3 368 448 352 448h-64c-16 0-29.2-11.7-31.6-26.9-.5-2.9-3-5.1-5.9-5.1H12c-6.6 0-12 5.4-12 12v36c0 26.5 21.5 48 48 48h544c26.5 0 48-21.5 48-48v-36c0-6.6-5.4-12-12-12z"
                        />
                      </svg>
                    </div>
                    Laptop
                  </div>
                </div>
              </div>
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
