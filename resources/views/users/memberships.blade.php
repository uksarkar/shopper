@extends('layouts.app')
@section('title')
    Memberships
@endsection
@section('content')
<!-- Start main container -->
@include('users.sidebar')
<div class="container mx-auto mt-2 min-h-screen rounded bg-white p-2">
    <div class="bg-white">
        <h1>Membership plans</h1>
        <hr />
        <div class="flex flex-wrap items-stretch justify-center">
            @if(!blank($memberships))
                @foreach ($memberships as $membership)
                    <div class="w-full flex justify-center items-center flex-col md:w-1/4 bg-white rounded border border-grey-500 shadow-lg m-2 p-4">
                        <img class="rounded-full border border-gray-500 w-64 h-64" src="@if(!blank($membership->image)){{ $membership->image->url }}@endif" alt="{{ $membership->name }}">
                        <p class="p-2 font-semibold text-lg">
                            {{ $membership->name }}
                        </p>
                        <p class="mt-2 p-2 font-semibold text-green-800">
                            {{ $moneySign.$membership->price }}
                        </p>
                        <p class="mt-2 p-2">
                            You can add {{ $membership->shop_limit }} shops.
                        </p>
                        @if(blank($hasMembership = auth()->user()->memberships()->find($membership->id)))
                        <form action="{{ route('home.memberships.store') }}" method="post">
                            @csrf
                            <input type="hidden" name="plan" value="{{ $membership->id }}">
                            <button class="rounded border py-1 px-4 border-green-700 hover:bg-green-800 hover:border-transparent hover:text-white transition-250">Buy Now!</button>
                        </form>
                        @else
                            @switch($hasMembership->request->status)
                                @case(0)
                                    <p>
                                        Your request is <span class="rounded-full px-2 bg-orange-600 text-white">Panding</span>
                                    </p>
                                    @break
                                @case(1)
                                    <p>
                                        This pack was <span class="rounded-full px-2 bg-green-800 text-white">activeted</span>
                                    </p>
                                    @break
                                @default
                                    <form action="{{ route('home.memberships.store') }}" method="post">
                                        @csrf
                                        <input type="hidden" name="plan" value="{{ $membership->id }}">
                                        <button class="rounded border py-1 px-4 border-green-700 hover:bg-green-800 hover:border-transparent hover:text-white transition-250">Buy Now!</button>
                                    </form>
                                    <p>
                                        Your request was <span class="rounded-full px-2 bg-red-800 text-white">Rejacted</span>
                                    </p>
                                    
                            @endswitch
                        @endif
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</div>
<!-- End main container -->
@endsection
