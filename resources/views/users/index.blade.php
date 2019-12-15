@extends('layouts.app')
@section('title')
    Mange your account
@endsection
@section('content')
      <!-- Start main container -->
      @include('users.sidebar')
      <div class="container mx-auto mt-2 min-h-screen rounded bg-white p-2">
        <div class="bg-white">
            <h1>Dashboard</h1>
            <hr />
        </div>
      </div>
      <!-- End main container -->
@endsection
