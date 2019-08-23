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
                                                {!! $menu !!}
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
