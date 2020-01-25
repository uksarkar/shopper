<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1, shrink-to-fit=no"
    />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png" />
    <link rel="icon" type="image/png" sizes="16x16" href="{{ $favicon }}" />
    <link rel="stylesheet" href="{{ asset('/css/tailwind.css') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css" integrity="sha256-+N4/V/SbAFiW1MPBCXnfnP9QSN3+Keu+NlB+0ev/YKQ=" crossorigin="anonymous" />
    <title>@yield('title', $site_name)</title>
    @auth
        <link rel="stylesheet" href="{{ asset("css/iziToast.min.css") }}">
    @endauth
    <!-- development version, includes helpful console warnings -->
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
  </head>
  <body class="antialiased bg-gray-200">
    <div id="app">
      <header
        class="lg:px-16 w-full z-50 fixed top-0 px-6 bg-white flex flex-wrap items-center shadow-md lg:py-0 py-2"
      >
        <div class="flex-1 flex justify-between items-center">
          <a class="focus:outline-none" href="/">
            <img class="logo" src="{{ $site_logo }}" alt="{{ $site_name }}">
          </a>
        </div>
        <div class="cursor-pointer lg:hidden block" @click="toggleMenu">
          <svg
            width="30"
            height="30"
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 512 512"
          >
            <path
              d="M96 96c0 26.51-21.49 48-48 48S0 122.51 0 96s21.49-48 48-48 48 21.49 48 48zM48 208c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.49-48-48-48zm0 160c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.49-48-48-48zm96-236h352c8.837 0 16-7.163 16-16V76c0-8.837-7.163-16-16-16H144c-8.837 0-16 7.163-16 16v40c0 8.837 7.163 16 16 16zm0 160h352c8.837 0 16-7.163 16-16v-40c0-8.837-7.163-16-16-16H144c-8.837 0-16 7.163-16 16v40c0 8.837 7.163 16 16 16zm0 160h352c8.837 0 16-7.163 16-16v-40c0-8.837-7.163-16-16-16H144c-8.837 0-16 7.163-16 16v40c0 8.837 7.163 16 16 16z"
            />
          </svg>
        </div>
        <!-- Start left menu -->
        <div
          class="lg:flex lg:item-center lg:w-auto w-full"
          id="menu"
          :class="showMenu"
        >
          <!-- Search form -->
          <form action="{{ route('search') }}" method="GET">
            <div class="bg-white h-10 lg:mt-2 shadow rounded-full flex">
              <span class="w-auto flex justify-end items-center text-grey p-2">
                <i class="search-icon"></i>
              </span>
              <input
                class="w-full rounded focus:outline-none"
                type="text"
                name="name"
                value="{{ old('name') }}"
                placeholder="Search..."
              />
              <button
                class="bg-green-700 hover:bg-green-800 rounded-full transition-250 text-white m-1 focus:outline-none px-6"
              >
                <p class="font-semibold text-xs">Search</p>
              </button>
            </div>
          </form>
          <!-- End search form -->
          <!-- Start menu  -->
          <nav>
            <ul
              class="lg:flex items-center justify-between text-base text-gray-700 pt-4 lg:pt-0"
            >
              <li class="catToggler">
                <a
                  href="#"
                  class="lg:p-4 relative py-3 block focus:outline-none border-b-2 hover:border-indigo-400"
                  :class="allCatBorder"
                  @click.prevent="showCategoriesUI"
                  >All Categories</a
                >
                <!-- Start Categories view -->
                <div
                  :class="showCatContainer ? 'absolute z-10 shadow-lg bg-gray-100 p-8 catContainer showCatContainer' : 'absolute z-10 shadow-lg bg-gray-100 p-8 catContainer'"
                >
                  {!! $menu->outputMenu() !!}
                </div>
                <!-- End Categories view -->
              </li>
              <li>
                <a
                  href="/fake-customers"
                  class="lg:p-4 py-3 block focus:outline-none border-b-2 border-transparent hover:border-indigo-400"
                  >Fake Customers</a
                >
              </li>
              <li>
                <a
                  href="/fake-shops"
                  class="lg:p-4 py-3 block focus:outline-none border-b-2 border-transparent hover:border-indigo-400"
                  >Fake Shops</a
                >
              </li>
              @guest
              <li>
                <a
                  href="/login"
                  class="lg:p-4 py-3 block focus:outline-none border-b-2 border-transparent hover:border-indigo-400"
                  >Login</a
                >
              </li>
              <li>
                <a
                  href="/register"
                  class="lg:p-4 py-3 block focus:outline-none border-b-2 border-transparent hover:border-indigo-400"
                  >Register</a
                >
              </li>
              @else
              <li>
                  <a
                    href="#"
                    class="lg:p-4 py-3 block focus:outline-none border-b-2 border-transparent hover:border-indigo-400"
                    @click.prevent="$refs.logout.submit()"
                    >Logout</a
                  >
                  <form class="hidden" ref="logout" action="{{ route('logout') }}" method="POST">@csrf</form>
                </li>
              @endguest
            </ul>
          </nav>
          <!-- End menu -->
          @if(auth()->check())
          <!-- Start avatar -->
          <a
            href="/account"
            class="lg:ml-4 flex items-center focus:outline-none justify-start lg:mb-0 mb-4 cursor-pointer"
          >
            <img
              src="{{ auth()->user()->getImage() }}"
              alt="avatar"
              ref = "avatarImage"
              class="rounded-full shadow-outline w-10 h-10 border-2 border-transparent transition-250 hover:shadow-md"
            />
          </a>
          <!-- End avatar -->
          @endif
        </div>
      </header>
      @yield('content')
      <!-- Start footer container -->
      <div class="container min-w-full">
        <div class="bg-gray-700 text-white text-center py-12">
          <div class="w-full block flex-grow lg:flex lg:items-center lg:w-auto">
            <div class="text-sm lg:flex-grow">
              @foreach ($menu->footerMenu() as $menu)
                <a
                  href="{{ $menu->slug }}"
                  class="block mt-4 md:inline-block lg:mt-0 text-teal-200 hover:text-white mr-4"
                >
                  {{ $menu->name }}
                </a>
              @endforeach
            </div>
          </div>
          <br />
          <p>
            {{ $menu->getCopyrightText() }}
          </p>
        </div>
      </div>
      <!-- End footer container -->
    </div>
    @auth
      <script src="{{ asset("js/iziToast.min.js") }}"></script>
      <script type="text/javascript">
          @if($errors->count() > 0)
                @foreach($errors->all() as $error)
                    iziToast.warning({
                        timeout: 10000,
                        transitionIn: 'flipInX',
                        transitionOut: 'flipOutX',
                        title: 'Caution',
                        message: "{{ $error }}",
                    });
                @endforeach
            @endif

            @if(session()->has("failedMassage"))
                iziToast.error({
                    timeout: 10000,
                    title: 'Error',
                    message: '{{ session()->get("failedMassage") }}',
                });
            @endif

            @if(session()->has("successMassage"))
                iziToast.success({
                    timeout: 10000,
                    title: 'OK',
                    message: '{{ session()->get("successMassage") }}',
                });
            @endif
      </script>
    @endauth
    <script src="{{ asset('js/script.js') }}"></script>
  </body>
</html>
