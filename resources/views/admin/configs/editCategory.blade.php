@extends('admin.layouts.app')
@section('title')Edit Category {{ $category->name }} @endsection
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
                <li class="breadcrumb-item"><a href="{{ route('config.category') }}">Categories</a></li>
                <li class="breadcrumb-item active">Edit Category</li>
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
                                    <form action="{{ route('config.update.category',$category->id) }}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div class="form-group">
                                            <!-- image-preview-filename input [CUT FROM HERE]-->
                                            <div class="avatar-upload">
                                                <div class="avatar-edit">
                                                    <input name="image" type='file' id="imageUpload" accept=".png, .jpg, .jpeg" />
                                                    <label for="imageUpload"></label>
                                                </div>
                                                <div class="avatar-preview">
                                                    <div id="imagePreview" style="background-image: url(@isset($category->image){{ $category->image->url }}@else https://via.placeholder.com/300x300.png?text=Image @endisset);">
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- /input-group image-preview [TO HERE]-->
                                        </div>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-prepend"><span class="input-group-text">Category Name</span></div>
                                                <input class="form-control" id="name" type="text" name="name" placeholder="Category Name" required="" value="{{ $category->name }}">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-prepend"><span class="input-group-text">Category Slug</span></div>
                                                <input class="form-control" id="slug" type="text" name="slug" placeholder="Category Slug" value="{{ $category->slug }}">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <input type="hidden" name="parent_id" class="parent_id" value="{{ $category->parent_id }}">
                                            <label class="option-label" for="select">Parent</label>
                                            <button class="btn btn-light dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                <span class="dropdowntree-name">@if($category->parent){{ $category->parent->name }}@else None @endif</span><span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                                <li>
                                                    <a data-id="0" class="option-a" href="#">
                                                        <i class="fa @if($category->parent_id == 0)fa-check-square-o @else fa-square-o @endif" aria-hidden="true"></i>
                                                        None
                                                    </a>
                                                </li>
                                                @foreach ($categories as $item)
                                                @if($item->id != $category->id)
                                                <li>
                                                    <a data-id="{{ $item->id }}" class="option-a" href="#">
                                                        <i class="fa @if($item->id == $category->parent_id)fa-check-square-o @else fa-square-o @endif" aria-hidden="true"></i>
                                                        {{ $item->name }}
                                                    </a>
                                                    <ul class="option-ul">
                                                    @foreach ($item->children as $k => $child)
                                                      @include('admin.helper.edit_child_option', ['child_category' => $child])
                                                    @endforeach
                                                    </ul>
                                                </li>
                                                @endif
                                                @endforeach
                                            </ul>
                                        </div>
                                        <div class="form-group">
                                            <button class="btn btn-primary float-right"><i class="fa fa-save" aria-hidden="true"></i> Save</button>
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
