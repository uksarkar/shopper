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
                                    {{-- Start Collapsible --}}
                                    <div class="card-header">
                                        Primary Mneu 
                                        <label class="switch switch-label switch-success float-right">
                                            <input class="switch-input" type="checkbox" checked="0"><span class="switch-slider" data-checked="On" data-unchecked="Hide"></span>
                                        </label>
                                    </div>
                                    @if(\App\Helper::primaryMenu())
                                    <div id="accordion" role="tablist">
                                        @foreach (\App\Helper::primaryMenu() as $menu)
                                        @if(!blank($menu->metas))
                                        <div class="card mb-0">
                                            <div class="card-header" id="headingOne" role="tab">
                                            <h5 class="mb-0">
                                                <i class="icon-list icons mr-1"></i>
                                                <a data-toggle="collapse" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne" class="collapsed">{{ $menu->name }}</a>
                                                <button class="btn btn-danger btn-sm float-right"><i class="fa fa-trash"></i> Remove</button>
                                            </h5>
                                            </div>
                                            <div class="collapse" id="collapseOne" role="tabpanel" aria-labelledby="headingOne" data-parent="#accordion" style="">
                                            <div class="card-body">
                                                <div class="input-group mb-1">
                                                    <div class="input-group-prepend"><span class="input-group-text">Name:</span></div>
                                                    <input class="form-control" id="name" type="text" name="name" value="{{ $menu->name }}">
                                                    <div class="input-group-append"><button class="btn btn-primary">Update</button></div>
                                                </div>
                                                <hr>
                                                <ul class="list-group">
                                                    @foreach ($menu->metas as $item)
                                                        <li class="list-group-item">
                                                            <div class="row">
                                                                <div class="col-sm-4">
                                                                    <div class="input-group">
                                                                        <div class="input-group-prepend"><span class="input-group-text">Name:</span></div>
                                                                        <input class="form-control" id="name" type="text" name="name" value="{{ $item->text }}">
                                                                        <div class="input-group-append"><span class="input-group-text"><i class="fa fa-pencil"></i></span></div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-4">
                                                                    <div class="input-group">
                                                                        <div class="input-group-prepend"><span class="input-group-text">Link:</span></div>
                                                                        <input class="form-control" id="name" type="text" name="name" value="{{ $item->key_1 }}">
                                                                        <div class="input-group-append"><span class="input-group-text"><i class="fa fa-link"></i></span></div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-4">
                                                                    <button class="btn btn-success">Update</button>
                                                                    <button class="btn btn-danger">Remove</button>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                                <div class="row">
                                                    <div class="col-sm-12 text-right p-1">
                                                        <button class="btn btn-sm btn-primary">Add Link</button>
                                                    </div>
                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                        @else
                                        <div class="card mb-0">
                                            <div class="card-header bg-white">
                                                <div class="row">
                                                    <div class="col-sm-1"><i class="icon-link icons mr-1"></i></div>
                                                    <div class="col-sm-3">
                                                        <div class="input-group">
                                                            <div class="input-group-prepend"><span class="input-group-text">Name:</span></div>
                                                            <input class="form-control" id="name" type="text" name="name" value="{{ $menu->name }}">
                                                            <div class="input-group-append"><span class="input-group-text"><i class="fa fa-pencil"></i></span></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="input-group">
                                                            <div class="input-group-prepend"><span class="input-group-text">Link:</span></div>
                                                            <input class="form-control" id="name" type="text" name="name" value="{{ $menu->key_1 }}">
                                                            <div class="input-group-append"><span class="input-group-text"><i class="fa fa-link"></i></span></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <select class="selectpicker" multiple data-live-search="true">
                                                            <option value="all">All</option>
                                                            <option value="guest">Guest</option>
                                                            <option value="auth">Loggedin</option>
                                                            @foreach ($roles as $role)
                                                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-2 text-right">
                                                        <button class="btn btn-sm btn-primary"><i class="fa fa-retweet"></i> Update</button>
                                                        <button class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                        @endforeach
                                    </div>
                                    @endif
                                    {{-- End Collapsible --}}
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-12 text-right p-1">
                                            <button class="btn btn-primary">Add Link</button>
                                            <button class="btn btn-info">Add Dropdown</button>
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
