@extends('layouts.app')

@section('content')
    @include('helpers.header')

    {{-- Slider Section --}}

    @include('helpers.slider')

    {{-- End slider section --}}
    @if ($contents)
        @foreach ($contents as $content)
            @include('helpers.content',['content',$content])
        @endforeach
    @endif
    @include('helpers.quota')
    @if($items)
        @include('helpers.items', ['items'=>$items])
    @endif
    @include('helpers.links')
    @include('helpers.subscribe')
    @include('helpers.footer')
@endsection
