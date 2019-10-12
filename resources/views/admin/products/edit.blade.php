@extends('admin.layouts.app')

@section('title')
    Edit {{ $product->name }}
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
                <li class="breadcrumb-item"><a href="{{ route("products.index") }}">All Products</a></li>
                <li class="breadcrumb-item active">Edit Product</li>
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
                                <div class="card-header"><i class="fa fa-edit"></i>Edit Product</div>
                                <div class="card-body">
                                    <form id="create-product" action="{{ route("products.update", $product->id) }}" method="post" enctype="multipart/form-data">
                                        @method('PATCH')
                                        @csrf
                                        <div class="row">
                                            <div class="col-sm-9">
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend"><span class="input-group-text">Name</span></div>
                                                        <input class="form-control" id="name" type="text" name="name" placeholder="Product Name" required value="{{ $product->name }}">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend"><span class="input-group-text">Expected price</span></div>
                                                        <input class="form-control" id="price" type="text" name="expected_price" placeholder="00.000" required value="{{ old("expected_price",$product->expected_price) }}">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <textarea class="textarea" id="textarea-input" name="description" rows="9" placeholder="Content.." required>{{ $product->description }}</textarea>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="plusItem">
                                                        @if(blank($product->metas))
                                                        <div class="list-group-item" data-status="create" data-id="new-1">
                                                            <button class="close meta_close" type="button" aria-label="Close"><span aria-hidden="true">×</span></button>
                                                            <input class="form-control plusName" type="text" name="meta_name"  placeholder="Meta Name">
                                                            <input class="form-control plusData" type="text" name="meta_data"  placeholder="Meta Text">
                                                        </div>
                                                        @else
                                                            @foreach ($product->metas as $meta)
                                                            <div class="list-group-item" data-status="0" data-id="{{ $meta->id }}">
                                                                <button class="close meta_close" type="button" aria-label="Close"><span aria-hidden="true">×</span></button>
                                                                <input class="form-control plusName" type="text" name="meta_name" value="{{ $meta->name }}"  placeholder="Meta Name">
                                                                <input class="form-control plusData" type="text" name="meta_data" value="{{ $meta->data }}"  placeholder="Meta Text">
                                                            </div>
                                                            @endforeach
                                                        @endif
                                                    </div>

                                                    <button id="plus" class="btn btn-secondary mt-3 btn-sm" type="button"><i class="fa fa-plus"></i> one</button>
                                                </div>
                                                {{-- Creating image  --}}
                                                <div class="form-group">
                                                    <div class="photo_preview" id="photo_preview">
                                                        @if(!blank($product->photos))
                                                            @foreach ($product->photos as $photo)
                                                            <div class="image-prev" data-id="{{ $photo->id }}" style="background-image:url({{ $photo->path }})">
                                                                <button type="button" class="image-prev-remove"></button>
                                                                &nbsp;
                                                            </div>
                                                            @endforeach
                                                        @endif
                                                        <div class="image-plus-btn" data-toggle="modal" data-target="#successModal">
                                                            <i class="fa fa-plus fa-3x"></i>
                                                        </div>
                                                    </div>
                                                    <small class="text-muted">Select multiple images.</small>
                                                    <input type="hidden" name="photos">
                                                </div>

                                            </div>
                                            <div class="col-sm-3">
                                                <!-- image-preview-filename input [CUT FROM HERE]-->
                                                <div class="avatar-upload">
                                                    <div class="avatar-edit">
                                                        <input name="image" type='file' id="imageUpload" accept=".png, .jpg, .jpeg" />
                                                        <label for="imageUpload"></label>
                                                    </div>
                                                    <div class="avatar-preview">
                                                        <div id="imagePreview" style="background-image: url('@if($product->image){{ $product->image->url }}@else https://via.placeholder.com/300x300.png?text=Image @endif');">
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
                                            <button id="sub" class="btn btn-primary float-right" type="submit">Submit</button>
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


    <div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-success modal-lg" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Photos</h4>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
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
                        <div class="loading text-center m-5">
                            <i class="fa fa-refresh fa-spin fa-5x"></i>
                            <br>
                            Loading photos...
                        </div>
                        <div class="row">
                        </div>
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
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                <button id="photo_add_btn" class="btn btn-success" type="button" data-dismiss="modal">Save</button>
            </div>
            </div>
            <!-- /.modal-content-->
        </div>
        <!-- /.modal-dialog-->
    </div>
    <!-- /.modal-->


    <footer class="app-footer">
        <div><a href="https://github.com/utpalongit">Utpal Sarkar</a><span>&copy; 2019.</span></div>
        <div class="ml-auto"><span>Powered by</span> Utpal Sarkar</div>
    </footer>
    @include('admin.layouts.footer')
    </body>
@endsection
