@extends('layouts.app')
@section('title')
    Details of {{ $user->name }}
@endsection
@section('content')
      <!-- Start main container -->
      <div class="container mx-auto mt-20">
        <div class="flex flex-wrap bg-white max-w-6xl mx-auto rounded p-3">
          <div class="sm:w-5/12 w-full">
            <div
              class="big-preview my-6 p-4 cursor-pointer"
              @click="previewImage=true, previewImageUrl='@isset($user->image){{ $user->image->url }}@endisset'"
            >
              <img src="@isset($user->image){{ $user->image->url }}@endisset" alt="{{ $user->name }}" />
            </div>
          </div>
          <div class="sm:w-7/12 w-full">
            <h1 class="mt-3 sm:mt-0">
                {{ $user->name }}
            </h1>
            <hr />
            <div class="flex flex-wrap p-2">
              <div class="w-5/12 border-b border-gray-600 p-2">
                <i class="fa fa-map-marker-alt"></i>  Website
              </div>
              <div class="w-2/12 border-b border-gray-600 p-2">:</div>
              <div class="w-5/12 border-b border-gray-600 p-2">
                Not available
              </div>
              <div class="w-5/12 border-b border-gray-600 p-2">
                <i class="fa fa-clock"></i>  Created at
              </div>
              <div class="w-2/12 border-b border-gray-600 p-2">:</div>
              <div class="w-5/12 border-b border-gray-600 p-2">
                @if(!blank($user->created_at)){{ $user->created_at->diffForHumans() }}@endif
              </div>

              <div class="w-5/12 border-b border-gray-600 p-2">
                <i class="fa fa-history"></i>  Last update
              </div>
              <div class="w-2/12 border-b border-gray-600 p-2">:</div>
              <div class="w-5/12 border-b border-gray-600 p-2">
                @if(!blank($user->updated_at)){{ $user->updated_at->diffForHumans() }}@endif
              </div>

            </div>
          </div>
        </div>
        <div class="max-w-6xl mx-auto rounded mt-4">
            <h4>Write review</h4>
            @auth
            @if(blank(auth()->user()->reviews()->where("reviewable_type","App\User")->where("user_id",$user->id)->get()))
              <div class="flex my-4 pb-3 border-b border-gray-400">
                <div class="w-1/12 flex items-center justify-center">
                    <img class="rounded-full w-16 h-16" src="@if(auth()->user()->image){{ auth()->user()->image->url }}@endif" alt="avatar">
                </div>
                <div class="w-11/12">
                  <form action="{{ route('review.store') }}" method="post">
                    @csrf
                    <textarea class="w-full p-4 rounded focus:outline-none focus:shadow transition-250" placeholder="Write your review text here..." name="body">{{ old('body') }}</textarea>
                    <input type="hidden" name="user" value="{{ $user->id }}">
                    <div>
                        <select class="p-1 rounded" name="rating">
                            <option selected>Select Stars</option>
                            <option value="1">1 Satar</option>
                            <option value="2">2 Satars</option>
                            <option value="3">3 Satars</option>
                            <option value="4">4 Satars</option>
                            <option value="5">5 Satars</option>
                        </select>
                        <button class="rounded border border-primary-normal text-primary-normal px-4 p-1 transition-250 hover:bg-primary-normal hover:text-white focus:outline-none" type="submit">
                            Submit
                        </button>
                    </div>
                  </form>
                </div>
              </div>
              @else
              <p class="bg-white p-4 my-4">
                You already picked a review.
              </p>
              @endif
            @else
              <p class="bg-white p-4 my-4">
                You have to <a class="text-primary-normal transition-250 border-b border-transparent hover:text-primary-dark hover:border-primary-dark" href="{{ route('login') }}">Login</a> to give feedback.
              </p>
            @endauth
            <div class="comments">
              @if(!blank($user->reviews))
                {{-- comment --}}
                @foreach ($user->reviews as $review)
                  <div class="flex border-b border-gray-500 pb-1">
                      <div class="w-1/12 flex items-center justify-center">
                          <img class="rounded-full w-16 h-16" src="{{ $review->userImage() }}" alt="avatar">
                      </div>
                      <div class="w-11/12">
                        <div class="stars" style="--rating:{{ $review->rating }};"></div>
                          <p class="bg-white rounded p-2">
                              {{ $review->body }}
                          </p>
                      </div>
                  </div>
                @endforeach
                {{-- end comment --}}
                @endif
            </div>
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