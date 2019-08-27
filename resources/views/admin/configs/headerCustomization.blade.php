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
                <li class="breadcrumb-item"><a href="{{ route('config') }}">Settings</a></li>
                <li class="breadcrumb-item active">Header Customizer</li>
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
                                <div class="card-header">Customize Header</div>
                                <div class="card-body">
                                    <div class="card-header">
                                        Primary Mneu 
                                        <button id="savePM" class="btn btn-success btn-sm float-right"><i class="fa fa-save" aria-hidden="true"></i> Save</button>
                                    </div>

                                    <div class="card-body">
                                        <p id="animiLine"></p>
                                        <p id="resText"></p>
                                        {{-- Start nestable --}}
                                        <div class="row">
                                            <div class="col-md-6">
                                            <div id="overlay"></div> 
                                            <h3>Menu</h3>
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
                        </div>
                        <!-- /.col-->
                    </div>
                    <!-- /.row-->
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-header">
                                    Content
                                </div>
                                <div class="card-body">
                                    @if(!blank($contents))
                                    <div class="card">
                                        @foreach ($contents as $content)
                                        <div class="card-header">{{ $content->header }}</div>
                                        <div class="form-group p-2">
                                            <div class="row">
                                                <div class="col-sm-9">
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <div class="input-group-prepend"><span class="input-group-text">Content Header</span></div>
                                                            <input class="form-control" type="text" name="header" placeholder="Content Header" required="" value="{{ $content->header }}">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <div class="input-group-prepend"><span class="input-group-text">Content Title</span></div>
                                                            <input class="form-control" type="text" name="title" placeholder="Content Title" required="" value="{{ $content->title }}">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <div class="input-group-prepend"><span class="input-group-text">Contents</span></div>
                                                            <textarea class="form-control" name="content">{{ $content->content }}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="avatar-upload">
                                                        <div class="avatar-edit">
                                                            <input name="image" type="file" id="imageUpload" accept=".png, .jpg, .jpeg">
                                                            <label for="imageUpload"></label>
                                                        </div>
                                                        <div class="avatar-preview">
                                                            <div id="imagePreview" style="background-image: url(https://via.placeholder.com/300x300.png?text=Image);">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @if(!blank($content->categories))
                                            <table class="table table-responsive-sm table-hover table-outline mb-0">
                                                    <thead class="thead-light">
                                                    <tr>
                                                        <th class="text-center"><i class="icon-picture"></i> Image</th>
                                                        <th>Category Name</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($content->categories as $category)
                                                        <tr>
                                                            <td class="text-center">
                                                                <div class="thumbnail"><img class="img img-thumbnail" src=" /images/1566705023_Dotlon-logo.png " alt="image" width="100"></div>
                                                            </td>
                                                            <td>
                                                                <div>{{ $category->name }}</div>
                                                                <div class="small text-muted">Created: {{ $category->created_at->diffForHumans() }}</div>
                                                            </td>
                                                            <td>
                                                                <button class="btn btn-outline-danger btn-sm subbtn">Remove</button>
                                                                <form class="formsub" method="POST" action="http://localhost:8000/admin/products/4">
                                                                </form>
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            @endif
                                            <button class="btn btn-block btn-success" data-toggle="modal" data-target="#infoModal"><i class="fa fa-plus"></i> Add Category</button>
                                        </div>
                                        @endforeach
                                    @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <div class="modal fade" id="infoModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-info modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Select Categories</h4>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
          </div>
          <div class="modal-body">
                <table class="table table-responsive-sm table-hover table-outline mb-0">
                    <tbody>
                        @foreach ($categories as $category)
                        <tr>
                            <td class="text-center">
                                <div class="thumbnail"><img class="img img-thumbnail" src=" /images/1566705023_Dotlon-logo.png " alt="image" width="100"></div>
                            </td>
                            <td>
                                <div>{{ $category->name }}</div>
                                <div class="small text-muted">Slug: {{ $category->slug }}</div>
                            </td>
                            <td>
                                <input data-id="{{ $category->id }}" type="checkbox" name="category" @if (array_search())
                                    
                                @endif>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
          </div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
            <button class="btn btn-info" type="button"><i class="fa fa-plus"></i> Add</button>
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
