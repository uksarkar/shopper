@extends('layouts.app')
@section('title')
    Create new shop
@endsection
@section('content')
<div class="container mx-auto mt-16">
    <div class="max-w-sm flex shadow-lg flex-col bg-cover bg-center justify-content mx-auto my-24 bg-white p-6 rounded py-20">
        <div class="text-center text-gray-600 mb-6">
            <h2>{{ __('Create shop') }}</h2>
        </div>
        <div class="text-center">
            <form action="{{ route('home.shops.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <input class="block w-full p-2 bg-transparent border-b transition-250 focus:border-green-700 @error('shop_name') border-red-500 @else mb-6 border-gray-400 @enderror" type="text" name="shop_name" placeholder="Shop name" required value="{{ old('shop_name') }}">
              @error('shop_image')
              <small class="text-red-500">
                {{ $message }}
              </small>
              @enderror
                <input class="block w-full p-2 bg-transparent border-b transition-250 focus:border-green-700 @error('shop_url') border-red-500 @else mb-6 border-gray-400 @enderror" type="text" name="shop_url" placeholder="http://www.url.com" required value="{{ old('shop_url') }}">
              @error('shop_url')
              <small class="text-red-500">
                {{ $message }}
              </small>
              @enderror
                <input class="block w-full p-2 bg-transparent border-b transition-250 focus:border-green-700 @error('shop_image') border-red-500 @else mb-6 border-gray-400 @enderror" type="file" name="shop_image" accept=".png, .jpg, .jpeg" required value="{{ old('shop_image') }}">
              @error('shop_image')
              <small class="text-red-500">
                {{ $message }}
              </small>
              @enderror
                <button class="px-6 py-2 mt-5 rounded-full text-white bg-green-700" type="submit">Create</button>
            </form>
        </div>
    </div>
</div>
@endsection
