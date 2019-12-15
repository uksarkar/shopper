@extends('layouts.app')

@section('content')
<!-- Start main container -->
      <div class="container mx-auto mt-20">
        <div
          class="max-w-sm flex shadow-lg flex-col bg-cover bg-center justify-content mx-auto my-24 bg-white p-6 rounded py-20"
        >
          <div class="text-center text-gray-600 mb-6">
            <h2>{{ __('Login') }}</h2>
          </div>
          <div>
            <form method="POST" action="{{ route('login') }}">
              @csrf
              <input
                class="bg-transparent transition-250 border-b m-auto block w-full text-gray-600 pb-1 focus:border-teal-700 @error('email') border-red-500 @else mb-6 border-gray-400 @enderror"
                type="email"
                name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
                placeholder="{{ __('Email') }}"
              />
              @error('email')
              <small class="text-red-500">
                {{ $message }}
              </small>
              @enderror
              <input
                class="bg-transparent transition-250 border-b m-auto block w-full text-gray-600 pb-1 focus:border-teal-700 @error('password') border-red-500 @else mb-6 border-gray-400 @enderror"
                type="password"
                name="password" required autocomplete="current-password"
                placeholder="{{ __('Password') }}"
              />
              @error('password')
              <small class="text-red-500">
                {{ $message }}
              </small>
              @enderror
              <div class="flex mt-4">
                <label class="custom-label flex">
                  <div
                    class="bg-white shadow w-6 h-6 p-1 flex justify-center items-center mr-2"
                  >
                    <input type="checkbox" name="remember" class="hidden" {{ old('remember') ? 'checked' : '' }} />
                    <svg
                      class="hidden w-4 h-4 text-green-600 pointer-events-none"
                      viewBox="0 0 172 172"
                    >
                      <g
                        fill="none"
                        stroke-width="none"
                        stroke-miterlimit="10"
                        font-family="none"
                        font-weight="none"
                        font-size="none"
                        text-anchor="none"
                        style="mix-blend-mode:normal"
                      >
                        <path d="M0 172V0h172v172z" />
                        <path
                          d="M145.433 37.933L64.5 118.8658 33.7337 88.0996l-10.134 10.1341L64.5 139.1341l91.067-91.067z"
                          fill="currentColor"
                          stroke-width="1"
                        />
                      </g>
                    </svg>
                  </div>
                  <span class="select-none text-gray-600">
                      {{ __('Remember Me') }}
                  </span>
                </label>
              </div>
              <input
                class="shadow-lg pt-3 pb-3 mt-6 w-full text-white bg-green-800 hover:bg-green-900 cursor-pointer transition-250 rounded-full "
                type="submit"
                value="SIGN IN"
              />
            </form>
          </div>
          <div>
            <p class="mt-4 text-grey text-sm">
              Haven't an account?
              <a
                href="/register"
                class="no-underline text-green-800 hover:text-green-900"
                >Sing Up
              </a>
            </p>
          </div>
        </div>
      </div>
      <!-- End main container -->
@endsection
