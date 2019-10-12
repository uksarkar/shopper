@extends('admin.layouts.app')

@section('title')
    Edit shop {{ $shop->name }}
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
                <li class="breadcrumb-item"><a href="{{ route("shops.index") }}">All Shops</a></li>
                <li class="breadcrumb-item active">Edit Shop</li>
                @include('admin.layouts.breadcrumbMenu')
            </ol>
            <div class="container-fluid">
                <div class="animated fadeIn">
                    @if(count($errors) > 0)
                        @foreach($errors as $error)
                            <div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Success!</strong> {{ $error }}
                                <button class="close" type="button" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                            </div>
                    @endforeach
                @endif
                <!-- /.row-->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header"><i class="fa fa-edit"></i>Edit Shop</div>
                                <div class="card-body">
                                    <form action="{{ route("shops.update", $shop->id) }}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        @method("PATCH")
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <!-- image-preview-filename input [CUT FROM HERE]-->
                                                <div class="avatar-upload">
                                                    <div class="avatar-edit">
                                                        <input name="image" type='file' id="imageUpload" accept=".png, .jpg, .jpeg" />
                                                        <label for="imageUpload"></label>
                                                    </div>
                                                    <div class="avatar-preview">
                                                        <div id="imagePreview" style="background-image: url('@if($shop->image){{ $shop->image->url }}@else https://via.placeholder.com/300x300.png?text=Image @endif');">
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- /input-group image-preview [TO HERE]-->
                                            </div>
                                            <div class="col-sm-9">
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend"><span class="input-group-text">Name</span></div>
                                                        <input class="form-control" id="name" type="text" name="shop_name" placeholder="Product Name" required value="{{ old('shop_name',$shop->name) }}">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend"><span class="input-group-text">Website</span></div>
                                                        <input class="form-control" id="url" type="text" name="shop_url" placeholder="url" required value="{{ old('shop_url',$shop->url) }}">
                                                    </div>
                                                </div>
                                                <div class="form-group form-actions">
                                                    <button class="btn btn-primary float-right" type="submit">Submit</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
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
