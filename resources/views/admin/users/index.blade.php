@extends('admin.layouts.app')

@section('title')
    All users
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
                <li class="breadcrumb-item active">All Users</li>
                @include('admin.layouts.breadcrumbMenu')
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
                                <div class="card-header">All Users</div>
                                <div class="card-body">
                                    <table class="table table-responsive-sm table-hover table-outline mb-0">
                                        <thead class="thead-light">
                                        <tr>
                                            <th class="text-center"><i class="icon-people"></i></th>
                                            <th>User</th>
                                            <th>Usage</th>
                                            <th class="text-center">Shops</th>
                                            <th>Activity</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($users as $user)
                                            <tr>
                                                <td class="text-center">
                                                    <div class="avatar"><img class="img-avatar" src="@if($user->image){{ $user->image->url }}@else {{ asset('img/avatars/none.png') }} @endif">@if($user->isOnline())<span class="avatar-status badge-success"></span>@else <span class="avatar-status badge-secondary"></span>@endif</div>
                                                </td>
                                                <td>
                                                    <div>{{ $user->name }}</div>
                                                    <div class="small text-muted">Registered: {{ $user->created_at->format('M d Y') }}</div>
                                                </td>
                                                <td>
                                                    <a href="{{ route("users.show", $user->id) }}" class="btn btn-primary">View Profile</a>
                                                    <a href="{{ route("users.edit", $user->id) }}" class="btn btn-secondary">Edit Profile</a>
                                                </td>
                                                <td class="text-center">@if(count($user->shops) > 0)<span class="badge badge-pill badge-info">{{ count($user->shops) }}</span>@else <span class="badge badge-pill badge-light">0</span>@endif</td>
                                                <td>
                                                    @if($user->hasRole('banned'))
                                                        <strong class="text-danger">Banned!</strong>
                                                    @else
                                                        <div class="small text-muted">Last Active</div><strong>@if($user->lastActive() && !$user->isOnline()){{ $user->lastActive()->diffForHumans() }}@elseif($user->isOnline())<span class="text-success">Online Now </span>@else Not Available @endif</strong>
                                                    @endif
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="mx-auto flex-column">{{ $users->links() }}</div>
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
