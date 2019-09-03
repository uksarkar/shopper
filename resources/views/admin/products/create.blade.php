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
                <li class="breadcrumb-item"><a href="{{ route("products.index") }}">All Products</a></li>
                <li class="breadcrumb-item active">Add Product</li>
                <!-- Breadcrumb Menu-->
                <li class="breadcrumb-menu d-md-down-none">
                    <div class="btn-group" role="group" aria-label="Button group"><a class="btn" href="/"><i class="icon-graph"></i>  Dashboard</a></div>
                </li>
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
                                <div class="card-header"><i class="fa fa-edit"></i>Add Product</div>
                                <div class="card-body">
                                    <form id="create-product" action="{{ route("products.store") }}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            <div class="col-sm-9">
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend"><span class="input-group-text">Name</span></div>
                                                        <input class="form-control" id="name" type="text" name="name" placeholder="Product Name" required value="{{ old("name") }}">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend"><span class="input-group-text">Expected price</span></div>
                                                        <input class="form-control" id="price" type="number" name="expected_price" placeholder="00.000" required value="{{ old("expected_price") }}">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <textarea class="textarea" id="textarea-input" name="description" rows="9" placeholder="Content.." required>{{ old("description") }}</textarea>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="plusItem">
                                                        <div class="list-group-item" data-status="create" data-id="new-1">
                                                            <button class="close meta_close" type="button" aria-label="Close"><span aria-hidden="true">×</span></button>
                                                            <input class="form-control plusName" type="text" name="meta_name"  placeholder="Meta Name">
                                                            <input class="form-control plusData" type="text" name="meta_data"  placeholder="Meta Text">
                                                        </div>
                                                    </div>

                                                    <button id="plus" class="btn btn-secondary mt-3 btn-sm" type="button"><i class="fa fa-plus"></i> one</button>
                                                </div>

                                            </div>
                                            <div class="col-sm-3">
                                                <!-- image-preview-filename input [CUT FROM HERE]-->
                                                <div class="avatar-upload mx-auto flex-column">
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
                                                {{-- Starting tree view --}}

                                                <div class="tree">
                                                    <div class="tree-header border-tree rounded mt-2 p-1">Category</div>
                                                    {!! $category_output !!}
                                                </div>
                                                {{-- End tree view --}}
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="form-group form-actions">
                                            <button class="btn btn-primary float-right" id="sub" type="submit">Submit</button>
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
