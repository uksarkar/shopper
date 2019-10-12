<header class="app-header navbar">
    <button class="navbar-toggler sidebar-toggler d-lg-none mr-auto" type="button" data-toggle="sidebar-show"><span class="navbar-toggler-icon"></span></button><a class="navbar-brand" href="/admin"><img class="navbar-brand-full" src="{{ config('site.header.logo') }}" width="89" height="25" alt="App Logo"><img class="navbar-brand-minimized" src="https://via.placeholder.com/100x100.png?text=Logo" width="30" height="30" alt="Logo"></a>
    <button class="navbar-toggler sidebar-toggler d-md-down-none" type="button" data-toggle="sidebar-lg-show"><span class="navbar-toggler-icon"></span></button>
    <ul class="nav navbar-nav d-md-down-none">
        <li class="nav-item px-3"><a class="nav-link" href="{{ route("admin") }}">Dashboard</a></li>
        <li class="nav-item px-3"><a class="nav-link" href="{{ route("users.index") }}">Users</a></li>
        <li class="nav-item px-3"><a class="nav-link" href="{{ route("home") }}">View Site</a></li>
{{--        <li class="nav-item px-3"><a class="nav-link" href="#">Settings</a></li>--}}
    </ul>
    <ul class="nav navbar-nav ml-auto">
        <li class="nav-item d-md-down-none"><a class="nav-link" href="#"><i class="icon-bell"></i><span class="badge badge-pill badge-danger">0</span></a></li>
        <li class="nav-item dropdown"><a class="nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"><img class="img-avatar" src="@if(auth()->user()->image){{ auth()->user()->image->url }} @else {{ asset('img/avatars/none.png') }} @endif" alt="{{ auth()->user()->name }}"></a>
            <div class="dropdown-menu dropdown-menu-right">
                <div class="dropdown-header text-center"><strong>Account</strong></div>
                <a class="dropdown-item" href="{{ route('users.show', auth()->id()) }}"><i class="fa fa-user"></i> Profile</a>
                <a class="dropdown-item" href="{{ route('users.edit', auth()->id()) }}"><i class="fa fa-pencil"></i> Edit Profile</a>

                <div class="dropdown-header text-center"><strong>Settings</strong></div>
                <a class="dropdown-item" href="{{ route('config') }}"><i class="fa fa-wrench"></i> Settings</a>

                <div class="dropdown-divider"></div>
                <a onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="dropdown-item" href="#"><i class="fa fa-lock"></i> Logout</a>
            </div>
        </li>
    </ul>
</header>
<form id="logout-form" method="POST" action="{{ route("logout") }}">@csrf</form>
