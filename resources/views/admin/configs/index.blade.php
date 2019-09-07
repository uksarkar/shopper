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
                                    <table class="table table-responsive-sm table-sm">
                                        <tbody>
                                            <tr>
                                                <td class="bg-dark">Site Name :</td>
                                                <td class="pl-4">{{ $site_name }}</td>
                                            </tr>
                                            <tr>
                                                <td class="bg-dark">Site Logo :</td>
                                                <td class="pl-4"><img src="{{ $site_logo }}" alt="logo"></td>
                                            </tr>
                                            <tr>
                                                <td class="bg-dark">Favicon :</td>
                                                <td class="pl-4"><img src="{{ $favicon}}" alt="logo"></td>
                                            </tr>
                                            <tr>
                                                <td class="bg-dark">Money Sign :</td>
                                                <td class="pl-4">{{ $moneySign }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <h4 class="bg-dark rounded p-1">Edit</h4>
                                            <form action="{{ route('config.siteNameLogoUpdate') }}" method="post" class="form-group">
                                                @csrf
                                                <div class="form-group">
                                                    <label class="bg-secondary rounded p-1" for="site-name">Site Name:</label>
                                                    <input class="form-control" type="text" name="site_name" value="{{ $site_name }}" placeholder="Site Name">
                                                </div>
                                                <div class="form-group">
                                                    <label class="bg-secondary rounded p-1" for="url">Site Logo:</label>
                                                    <input class="form-control" type="text" name="url" value="{{ $site_logo }}">
                                                </div>
                                                <div class="form-group">
                                                    <label class="bg-secondary rounded p-1" for="favicon">Site Favicon:</label>
                                                    <input class="form-control" type="text" name="favicon" value="{{ $favicon }}">
                                                </div>
                                                <div class="form-group">
                                                    <label class="bg-secondary rounded p-1" for="moneySign">Money Sign:</label>
                                                    <input class="form-control" type="text" name="money" value="{{ $moneySign }}">
                                                </div>
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
