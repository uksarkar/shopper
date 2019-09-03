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
                <li class="breadcrumb-item"><a href="{{ route("users.index") }}">All Users</a></li>
                <li class="breadcrumb-item active">Memberships</li>
                <!-- Breadcrumb Menu-->
                <li class="breadcrumb-menu d-md-down-none">
                    <div class="btn-group" role="group" aria-label="Button group"><a class="btn" href="/"><i class="icon-graph"></i>  Dashboard</a></div>
                </li>
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
                                    @if(!blank($memberships))
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
                                            @foreach ($memberships as $membership)
                                                <tr>
                                                    <td>{{ $membership->user->name }}</td>
                                                    <td>{{ $membership->name }}</td>
                                                    <td>
                                                        @if($membership->status == 1)
                                                            <span class="badge badge-success">Active</span>
                                                        @elseif($membership->status == 2)
                                                            <span class="badge badge-danger">Rejected</span>
                                                        @else
                                                            <span class="badge badge-warning">Panding</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($membership->status == 1)
                                                            <button class="btn btn-sm btn-outline-danger">Reject</button>
                                                        @elseif($membership->status == 2)
                                                            <button class="btn btn-sm disabled">None</button>
                                                        @else
                                                            <button class="btn btn-sm btn-outline-success">Accept</button>
                                                        @endif
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
