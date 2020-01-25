@extends('admin.layouts.app')

@section('title')
    Customize the home page
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
                <li class="breadcrumb-item"><a href="{{ route('config') }}">Settings</a></li>
                <li class="breadcrumb-item active">Home Customizer</li>
                @include('admin.layouts.breadcrumbMenu')
            </ol>
            <div class="container-fluid">
                <div class="animated fadeIn">
                    @if(session()->has("successMassage"))
                        <div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Success!</strong> {{ session()->get("successMassage") }}
                            <button class="close" type="button" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                        </div>
                    @endif
                    @if(session()->has("failedMassage"))
                        <div class="alert alert-warning alert-dismissible fade show" role="alert"><strong>Error!</strong> {{ session()->get("failedMassage") }}
                            <button class="close" type="button" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                        </div>
                    @endif
                    {{-- <div class="row">
                        <div class="col-sm-12">
                            <div class="card border-primary">
                                <div class="card-header">
                                    Content
                                </div>
                                <div class="card-body">
                                    @if(!blank($contents))
                                    @foreach ($contents as $content)
                                    <div class="card">
                                        <div class="card-header">
                                            {{ $content->header }}
                                            <button data-sub="d{{ $content->id }}" class="btn btn-danger btn-sm float-right subbtn">
                                                <i class="fa fa-trash"></i>
                                                Delete
                                            </button>
                                            <button data-id="{{ $content->id }}" data-header="{{ $content->header }}" data-title="{{ $content->title }}" data-content="{{ $content->content }}" data-image="@isset($content->image){{ $content->image->url }}@else https://via.placeholder.com/300x300.png?text=Image @endisset" data-url="{{ $content->url }}" class="btn btn-success btn-sm float-right editContentButton" type="button" data-toggle="modal" data-target="#infoModal"><i class="fa fa-pencil"></i> Edit</button>
                                        </div>
                                        <form class="formsub" data-sub="d{{ $content->id }}" action="{{ route('config.deleteContent', $content->id) }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                        <div class="form-group p-2">
                                            <div class="row">
                                                <div class="col-sm-9">
                                                    <p class="text-ligth rounded p-1">
                                                        <b class="text-dark">Header : </b>
                                                        {{ $content->header }}
                                                    </p>
                                                    <p class="text-ligth rounded p-1">
                                                        <b class="text-dark">Title : </b>
                                                        {{ $content->title }}
                                                    </p>
                                                    <p class="text-ligth rounded p-1">
                                                        <b class="text-dark">Content : </b> <br>
                                                        {{ $content->content }}
                                                    </p>
                                                    <p class="text-ligth rounded p-1">
                                                        <b class="text-dark">URL : </b> <br>
                                                        {{ $content->url }}
                                                    </p>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="avatar-upload">
                                                        <div class="avatar-preview">
                                                            <div style="background-image: url(@isset($content->image){{ $content->image->url }}@else https://via.placeholder.com/300x300.png?text=Image @endisset);">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @if(!blank($content->categories))
                                            <table class="table table-responsive-sm table-hover table-outline mb-0">
                                                    <thead class="thead-light">
                                                    <tr>
                                                        <th>ID</th>
                                                        <th class="text-center"><i class="icon-picture"></i> Image</th>
                                                        <th>Category Name</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($content->categories as $category)
                                                        <tr>
                                                            <td>{{ $category->id }}</td>
                                                            <td class="text-center">
                                                                <div class="thumbnail"><img class="img img-thumbnail" src="@isset($category->image){{ $category->image->url }}@endisset" alt="image" width="100"></div>
                                                            </td>
                                                            <td>
                                                                <div>{{ $category->name }}</div>
                                                                <div class="small text-muted">Created: {{ $category->created_at->diffForHumans() }}</div>
                                                            </td>
                                                            <td>
                                                                <button data-sub="c{{ $category->id }}" class="btn btn-outline-danger btn-sm subbtn">Remove</button>
                                                                <form class="formsub" data-sub="c{{ $category->id }}" method="POST" action="{{ route('config.removeCategory',$content->id) }}">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <input type="hidden" name="category_id" value="{{ $category->id }}">
                                                                </form>
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            @endif
                                        <form class="pt-2" action="{{ route('config.addCategory') }}" method="post">
                                            @csrf
                                            <input type="hidden" name="content_id" value="{{ $content->id }}">
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <div class="input-group-prepend"><span class="input-group-text">Category id's</span></div>
                                                    <input class="form-control" type="text" name="content_ids" placeholder="1,2,3,4,5,6......." required="" value="">
                                                    <span class="input-group-append">
                                                        <button class="btn btn-primary" type="submit"><i class="fa fa-plus"></i> Add</button>
                                                    </span>
                                                </div>
                                                <span class="text-muted">
                                                    Array of the category id's.
                                                </span>
                                            </div>
                                        </form>
                                        </div>
                                    </div>
                                    @endforeach
                                    @endif
                                    <button id="createButton" class="btn btn-success mb-1" type="button" data-toggle="modal" data-target="#infoModal"><i class="fa fa-plus"></i> New content</button>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                    <!-- /.row-->
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-header bg-info">
                                    Home Recommended Items
                                </div>
                                <div class="card-body">
                                    <div class="p-2">
                                        @if(!blank($recommendedContent->products))
                                        <table class="table table-responsive-sm table-hover table-outline mb-0">
                                                <thead class="thead-light">
                                                <tr>
                                                    <th>ID</th>
                                                    <th class="text-center"><i class="icon-picture"></i> Image</th>
                                                    <th>Product Name</th>
                                                    <th>Actions</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($recommendedContent->products as $product)
                                                    <tr>
                                                        <td>{{ $product->id }}</td>
                                                        <td class="text-center">
                                                            <div class="thumbnail"><img class="img img-thumbnail" src="@isset($product->image){{ $product->image->url }}@endisset" alt="image" width="100"></div>
                                                        </td>
                                                        <td>
                                                            <div>{{ $product->name }}</div>
                                                            <div class="small text-muted">Created: {{ $product->created_at->diffForHumans() }}</div>
                                                        </td>
                                                        <td>
                                                            <button data-sub="p{{ $product->id }}" class="btn btn-outline-danger btn-sm subbtn">Remove</button>
                                                            <form class="formsub" data-sub="p{{ $product->id }}" method="POST" action="{{ route('config.removeProduct',$product->id) }}">
                                                                @csrf
                                                                @method('DELETE')
                                                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                            </form>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        @else
                                            <p>No items are added yet!</p>
                                        @endif
                                        <form class="pt-2" action="{{ route('config.addProduct') }}" method="post">
                                            @csrf
                                            <div class="form-group">
                                                <input type="hidden" name="recommended_content_id" value="{{ $recommendedContent->id }}">
                                                <div class="input-group">
                                                    <div class="input-group-prepend"><span class="input-group-text">Products id's</span></div>
                                                    <input class="form-control" type="text" name="product_ids" placeholder="1,2,3,4,5,6......." required="" value="">
                                                    <span class="input-group-append">
                                                        <button class="btn btn-primary" type="submit"><i class="fa fa-plus"></i> Add</button>
                                                    </span>
                                                </div>
                                                <span class="text-muted">
                                                    Array of the product id's.
                                                </span>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.row-->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header bg-secondary">
                                    Footer Menu
                                    <button id="savePM" class="btn btn-success btn-sm float-right"><i class="fa fa-save" aria-hidden="true"></i> Save</button>
                                </div>
                                <div class="card-body">
                                    <p id="animiLine"></p>
                                    <p id="resText"></p>
                                    {{-- Start nestable --}}
                                    <div class="row">
                                        <div class="col-md-6">
                                        <div id="overlay"></div> 
                                        <h4>Menu Items</h4>
                                        <div class="dd nestable">
                                            @if(!is_null($menu))
                                                {!! $menu !!}
                                            @else
                                            <ol class="dd-list"></ol>
                                            @endif
                                        </div>
                                        </div>
                                        <div class="col-md-6">
                                        <form class="form-group" id="menu-add">
                                            <h3>Add new menu item</h3>
                                            <div class="form-group">
                                            <label for="addInputName">Name</label>
                                            <input type="text" class="form-control" id="addInputName" placeholder="Item name" required>
                                            </div>
                                            <div class="form-group">
                                            <label for="addInputSlug">Slug</label>
                                            <input type="text" class="form-control" id="addInputSlug" placeholder="item-slug" required>
                                            </div>
                                            <button class="btn btn-info" id="addButton">Add</button>
                                        </form>

                                        <form class="form-group" id="menu-editor" style="display: none;">
                                            <h3>Editing <span id="currentEditName" class="text-warning"></span></h3>
                                            <div class="form-group">
                                            <label for="addInputName">Name</label>
                                            <input type="text" class="form-control" id="editInputName" placeholder="Item name" required>
                                            </div>
                                            <div class="form-group">
                                            <label for="addInputSlug">Slug</label>
                                            <input type="text" class="form-control" id="editInputSlug" placeholder="item-slug">
                                            </div>
                                            <button class="btn btn-info" id="editButton">Edit</button>
                                        </form>
                                        </div>
                                    </div>
                                    {{-- End nastable --}}
                                </div>
                            </div>
                        </div>
                        <!-- /.col-->
                    </div>
                    <!-- /.row-->
                    <!-- /.row-->
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card border-t-primary">
                                <div class="card-header bg-primary">
                                    Footer &copy; Copyrights
                                </div>
                                <div class="card-body">
                                    <form action="{{ route('footer-copyright') }}" method="post">
                                        @csrf
                                        <input class="form-control" value="@if(!blank($copyright)) {{ $copyright->content }} @endif" type="text" placeholder="&copy; all right reserved." name="content">
                                        <p class="mt-2">
                                            <button class="btn btn-primary float-right">Update</button>
                                        </p>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.row-->
                </div>
            </div>
        </main>
    </div>
    {{-- The model for adding content --}}
    <div class="modal fade" id="infoModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-info modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="model_SbTn4MoDeL">Select Categories</h4>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
          </div>
          <div class="modal-body">
                <form data-sub="SbTn4MoDeL" action="" method="post" class="formsub" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div class="row">
                        <div class="col-sm-8">
                            <div class="form-group">
                                <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text">Header</span></div>
                                <input class="form-control" id="header" type="text" name="header" placeholder="Header" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text">Title</span></div>
                                <input class="form-control" id="title" type="text" name="title" placeholder="Title..." required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text">URL</span></div>
                                <input class="form-control" type="text" name="url" placeholder="/something/another" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text">Content</span></div>
                                <textarea class="form-control" name="content" id="" cols="30" rows="10"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="avatar-upload">
                                <div class="avatar-edit">
                                    <input name="image" type="file" id="imageUpload" accept=".png, .jpg, .jpeg">
                                    <label for="imageUpload"></label>
                                </div>
                                <div class="avatar-preview">
                                    <div id="imagePreview">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
          </div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
            <button data-sub="SbTn4MoDeL" class="btn btn-info subbtn" type="button"></button>
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
