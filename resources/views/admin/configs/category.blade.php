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
                <li class="breadcrumb-item"><a href="{{ route('products.index') }}">product</a></li>
                <li class="breadcrumb-item active">Categories</li>
                <!-- Breadcrumb Menu-->
                <li class="breadcrumb-menu d-md-down-none">
                    <div class="btn-group" role="group" aria-label="Button group"><a class="btn" href="/admin"><i class="icon-graph"></i>  Dashboard</a></div>
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
                                <div class="card-header">
                                    Categories
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <form action="{{ route('config.create.category') }}" method="post" enctype="multipart/form-data">
                                                @csrf
                                                <div class="form-group">
                                                    <!-- image-preview-filename input [CUT FROM HERE]-->
                                                    <div class="avatar-upload">
                                                        <div class="avatar-edit">
                                                            <input name="image" type='file' id="imageUpload" accept=".png, .jpg, .jpeg" />
                                                            <label for="imageUpload"></label>
                                                        </div>
                                                        <div class="avatar-preview">
                                                            <div id="imagePreview" style="background-image: url(https://via.placeholder.com/300x300.png?text=Image);">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- /input-group image-preview [TO HERE]-->
                                                </div>
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend"><span class="input-group-text">Category Name</span></div>
                                                        <input class="form-control" id="name" type="text" name="name" placeholder="Category Name" required="">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend"><span class="input-group-text">Category Slug</span></div>
                                                        <input class="form-control" id="slug" type="text" name="slug" placeholder="Category Slug">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <input type="hidden" name="parent_id" class="parent_id" value="0">
                                                    <label class="option-label" for="select">Parent</label>
                                                    <button class="btn btn-light dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                        <span class="dropdowntree-name">None</span><span class="caret"></span>
                                                    </button>
                                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                                        <li>
                                                            <a data-id="0" class="option-a" href="#">
                                                                <i class="fa fa-check-square-o" aria-hidden="true"></i>
                                                                None
                                                            </a>
                                                        </li>
                                                        @foreach ($categories as $category)
                                                        <li>
                                                            <a data-id="{{ $category->id }}" class="option-a" href="#">
                                                                <i class="fa fa-square-o" aria-hidden="true"></i>
                                                                {{ $category->name }}
                                                            </a>
                                                            <ul class="option-ul">
                                                            @foreach ($category->children as $k => $child)
                                                              @include('admin.helper.child_option', ['child_category' => $child])
                                                            @endforeach
                                                            </ul>
                                                        </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                                <div class="form-group">
                                                    <button class="btn btn-primary float-right"><i class="fa fa-save" aria-hidden="true"></i> Add</button>
                                                </div>
                                            </form>
                                        </div>
                                        {{-- End row --}}
                                        <div class="col-sm-8">
                                            <ul class="list-group">
                                            @foreach ($categories as $category)
                                            <li class="list-group-item">
                                                <a href="{{ route('config.edit.category',$category->id) }}">{{ $category->name }}</a>
                                                Slug: {{ $category->slug }}
                                                <button data-id="{{ $category->id }}" class="btn btn-link text-danger submitButton" type="button" data-toggle="tooltip" data-placement="top" title="" data-original-title="All sub-category will be deleted!">Delete</button>
                                            </li>
                                                @foreach ($category->children as $k => $child)
                                                    @include('admin.helper.child_category', ['child_category' => $child])
                                                @endforeach
                                            @endforeach
                                            </ul>
                                            <form id="deleteForm" action="" method="post">
                                                @csrf
                                                @method('DELETE')
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
