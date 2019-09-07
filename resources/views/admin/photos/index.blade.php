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
                <li class="breadcrumb-item active">All Photos</li>
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
                                {{-- <div class="card-header">All Photos</div> --}}
                                <div class="card-body">
                                    <ul class="nav nav-tabs">
                                        <li class="nav-item">
                                            <a class="nav-link active show" data-toggle="tab" href="#all_photos">Photos</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#upload_photos">Upload</a>
                                        </li>
                                    </ul>
                                    
                                    <div class="tab-content">
                                        <div id="all_photos" class="tab-pane fade in active show">
                                            @if(!blank($photos))
                                                    
                                            <div class="jumbotron">
                                                <h1><i class="fa fa-camera-retro" aria-hidden="true"></i> Lenses</h1>
                                                <p>Images provided free of copyright by wonderful people</p>
                                            </div>

                                            <div class="row flex">
                                                @foreach ($photos as $photo)
                                                <div class="col-lg-4 col-sm-6">
                                                    <div class="thumbnail">
                                                        <img src="{{ $photo->path }}">
                                                    </div>
                                                </div>
                                                @endforeach
                                            </div>
                                            @else
                                                <p>No photo to show</p>
                                            @endif

                                            <div class="mx-auto flex-column">{{ $photos->links() }}</div>
                                        </div>
                                        <div id="upload_photos" class="tab-pane fade">
                                            upload
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
