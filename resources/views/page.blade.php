@extends('layouts.app')

@section('title')
    {{ $page->title }}
@endsection

@section('content')
<div class="container mx-auto mt-20 min-h-screen bg-white shadow p-5">
    <h1>{{ $page->title }}</h1>
    <hr>
    <p>
        {!! $page->descriptions !!}
    </p>
</div>
@endsection
