@extends('admin.layouts.app')

@section('title')
    Edit profile of {{ $user->name }}
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
                <li class="breadcrumb-item"><a href="{{ route("users.index") }}">All Users</a></li>
                <li class="breadcrumb-item active">Edit User</li>
                @include('admin.layouts.breadcrumbMenu')
            </ol>
            <div class="container-fluid">
                <div class="animated fadeIn">
                    @if(count($errors) > 0)
                        @foreach($errors->all() as $error)
                            <div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Caution!</strong> {{ $error }}
                                <button class="close" type="button" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                            </div>
                    @endforeach
                @endif
                <!-- /.row-->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header"><i class="fa fa-edit"></i>Edit User</div>
                                <div class="card-body">
                                    <form action="{{ route("users.update", $user->id) }}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        @method("PATCH")
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <!-- image-preview-filename input [CUT FROM HERE]-->
                                                <div class="avatar-upload">
                                                    <div class="avatar-edit">
                                                        <input name="image" type='file' id="imageUpload" accept=".png, .jpg, .jpeg" />
                                                        <label for="imageUpload"></label>
                                                    </div>
                                                    <div class="avatar-preview">
                                                        <div id="imagePreview" style="background-image: url('@if($user->image){{ $user->image->url }}@else {{ asset('img/avatars/none.png') }} @endif');">
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- /input-group image-preview [TO HERE]-->
                                            </div>
                                            <div class="col-sm-8">
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend"><span class="input-group-text">Name</span></div>
                                                        <input class="form-control" id="name" type="text" name="name" placeholder="Full Name" required value="{{old('name', $user->name)}}">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend"><span class="input-group-text">Location</span></div>
                                                        <input class="form-control" id="location" type="text" name="location" placeholder="#Street" required value="{{ old("location", $user->location) }}">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend"><span class="input-group-text">Phone</span></div>
                                                        <input class="form-control" id="phone" type="text" name="phone" placeholder="01xxxxxxxxx" required value="{{ old("phone",$user->phone) }}">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend"><span class="input-group-text">Email</span></div>
                                                        <input class="form-control" id="email" type="email" name="email" placeholder="email@example.com" required value="{{ old('email',$user->email) }}">
                                                    </div>
                                                </div>
                                                <div class="form-group form-inline bg-secondary p-3 rounded">
                                                        @foreach($roles as $role)
                                                        <div class="custom-control custom-checkbox custom-control-inline">
                                                            <input id="in{{ $role->id }}" type="checkbox" name="roles[]" value="{{ $role->id }}" @if($user->hasRole($role->name)) checked @endif class="custom-control-input">
                                                            <label class="custom-control-label" for="in{{ $role->id }}">{{ $role->name }}</label>
                                                        </div>
                                                        @endforeach
                                                </div>
                                                <div class="form-group form-actions">
                                                    <button class="btn btn-sm btn-primary float-right" type="submit">Submit</button>
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
