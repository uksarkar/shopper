@extends('admin.layouts.app')

@section('title')
    All uploaded photos
@endsection

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
                @include('admin.layouts.breadcrumbMenu')
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

                                            <div class="row flex">
                                                @foreach ($photos as $photo)
                                                <div class="col-sm-3">
                                                    <img class="img img-thumbnail img-fluid" src="{{ $photo->path }}">
                                                    <form action="{{ route('photos.destroy', $photo->id) }}" method="post">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button class="btn btn-link text-danger delete-photo-btn" type="submit"><i class="fa fa-2x fa-trash-o"></i></button>
                                                    </form>
                                                </div>
                                                @endforeach
                                            </div>

                                            @else
                                                <p>No photo to show</p>
                                            @endif

                                            <div class="mx-auto flex-column">{{ $photos->links() }}</div>
                                        </div>
                                        <div id="upload_photos" class="tab-pane fade">
                                            <form id="dropzone-uploader" action="{{ route('photos.store') }}" class="dropzone rounded">
                                                @csrf
                                                <div class="dz-message d-flex flex-column">
                                                    <i class="fa fa-cloud-upload fa-3x"></i>
                                                    Drag &amp; Drop here or click
                                                </div>
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
