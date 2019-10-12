@extends('admin.layouts.app')

@section('title')
    All membership request
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
                <li class="breadcrumb-item active">Memberships</li>
                @include('admin.layouts.breadcrumbMenu')
            </ol>
            <div class="container-fluid">
                <div class="animated fadeIn">
                    @if(!blank($errors->all()))
                        @foreach($errors->all() as $error)
                        <div class="alert alert-warning">
                            {{ $error }}
                        </div>
                        @endforeach
                        @endif
                    @if(session()->has('successMassage'))
                        <div class="alert alert-success">
                            {{ session()->get('successMassage') }}
                        </div>
                    @endif
                <!-- /.row-->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <i class="fa fa-view"></i>Memberships
                                </div>
                                <div class="card-header bg-secondary">
                                    <form method="get" class="form-group form-inline">
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" id="q1" name="q" value="all" class="custom-control-input" @if(old('all') || !old('panding') && !old('approved')) checked @endif>
                                            <label class="custom-control-label" for="q1">All</label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" id="q2" name="q" value="panding" class="custom-control-input" @if(old('panding')) checked @endif>
                                            <label class="custom-control-label" for="q2">Panding</label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" id="q3" name="q" value="approved" class="custom-control-input" @if(old('approved')) checked @endif>
                                            <label class="custom-control-label" for="q3">Approved</label>
                                        </div>
                                        <button class="btn btn-primary btn-sm">Get</button>
                                    </form>
                                </div>
                                <div class="card-body">
                                    @if(!blank($requests))
                                    <table class="table table-responsive-sm table-sm">
                                        <thead>
                                            <tr>
                                            <th>Username</th>
                                            <th>Plan</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($requests as $request)
                                                <tr>
                                                    <td>{{ $request->requester }}</td>
                                                    <td>{{ $request->name }}</td>
                                                    <td>
                                                        @switch($request->status)
                                                            @case(1)
                                                                <span class="badge badge-success">Active</span>
                                                                @break
                                                            @case(2)
                                                                <span class="badge badge-danger">Rejected</span>
                                                                @break
                                                            @default
                                                                <span class="badge badge-warning">Panding</span>
                                                                
                                                        @endswitch
                                                    </td>
                                                    <td>
                                                        @switch($request->status)
                                                            @case(1)
                                                                <form action="{{ route('admin.membership.membershipRequestAction') }}" method="post">
                                                                    @csrf
                                                                    <input type="hidden" name="id" value="{{ $request->id }}">
                                                                    <input type="hidden" name="user_id" value="{{ $request->user_id }}">
                                                                    <input type="hidden" name="status" value="2">
                                                                    <button class="btn btn-sm btn-outline-danger">Reject</button>
                                                                </form>
                                                                @break
                                                            @default
                                                                <form action="{{ route('admin.membership.membershipRequestAction') }}" method="post">
                                                                    @csrf
                                                                    <input type="hidden" name="id" value="{{ $request->id }}">
                                                                    <input type="hidden" name="user_id" value="{{ $request->user_id }}">
                                                                    <input type="hidden" name="status" value="1">
                                                                    <button class="btn btn-sm btn-outline-success">Accept</button>
                                                                </form>
                                                                
                                                        @endswitch
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    @else 
                                    <p>
                                        No Data...!
                                    </p>
                                    @endif
                                    <div class="mx-auto flex-column">
                                        {{ $requests->links() }}
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
