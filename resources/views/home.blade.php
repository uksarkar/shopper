@extends('layouts.app')

@section('content')
    @include('helpers.header')

    {{-- Slider Section --}}

    @if(App\Helper::sliderSection())
        @include('helpers.slider')
    @endif

    {{-- End slider section --}}

    @include('helpers.content')
    @include('helpers.content')
    @include('helpers.quota')
    @include('helpers.items')
    @include('helpers.links')
    @include('helpers.subscribe')
    @include('helpers.footer')
@endsection
