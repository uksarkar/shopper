@extends('admin.layouts.app')

@section('content')
    <body class="app header-fixed sidebar-fixed aside-menu-fixed sidebar-lg-show">
    @include("admin.layouts.header")
    <div class="app-body">
        @include('admin.layouts.sidebar')
        <main class="main">
            <!-- Breadcrumb-->
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><i class="icon-home"></i></li>
                <li class="breadcrumb-item active">Admin</li>
                <li class="breadcrumb-item active">Settings</li>
                <!-- Breadcrumb Menu-->
                <li class="breadcrumb-menu d-md-down-none">
                    <div class="btn-group" role="group" aria-label="Button group"><a class="btn" href="/"><i class="icon-graph"></i>  Dashboard</a></div>
                </li>
            </ol>
            <div class="container-fluid">
                <div class="animated fadeIn">
                    @if(session()->has("successMassage"))
                        <div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Success!</strong> {{ session()->get("successMassage") }}
                            <button class="close" type="button" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                        </div>
                    @endif
                    <!-- /.row-->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">All Settings</div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-2 text-right">
                                            <p class="bg-light p-1 rounded">Site Name:</p>
                                            <p class="bg-light p-1 rounded">Site Logo:</p>
                                        </div>
                                        <div class="col-sm-6">
                                            <p>
                                                {{ config('site.header.name') }}
                                            </p>
                                            <p>
                                                <img src="{{ config('site.header.logo') }}" alt="logo">
                                            </p>
                                        </div>
                                        <div class="col-sm-4">
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <form action="{{ route('config.siteNameLogoUpdate') }}" method="post" class="form-group">
                                                @csrf
                                                @method('PUT')
                                                <label for="site-name">Site Name:</label>
                                                <input class="form-control" type="text" name="site_name" value="{{ config('site.header.name') }}" placeholder="Site Name">
                                                <label for="url">Site Logo:</label>
                                                <input class="form-control" type="text" name="url" value="{{ config('site.header.logo') }}">
                                                <button class="btn btn-info btn-sm">Update</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.col-->
                    </div>
                    <!-- /.row-->
                </div>
            </div>
        </main>
    </div>
    <footer class="app-footer">
        <div><a href="https://github.com/utpalongit">Utpal Sarkar</a><span>&copy; 2019.</span></div>
        <div class="ml-auto"><span>Powered by</span> Utpal Sarkar</div>
    </footer>
    @include('admin.layouts.footer')
    </body>
@endsection
