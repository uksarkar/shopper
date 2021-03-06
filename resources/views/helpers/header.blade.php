<header class="section-header">
    <nav class="navbar navbar-expand-lg navbar-light @if(Route::is('login'))shadow-sm @endif">
{{--        <div class="container">--}}
            <a class="navbar-brand" href="/"><img class="logo" src="{{ config('site.header.logo') }}" alt="{{ config('site.header.name') }}" title="{{ config('site.header.name') }}"></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTop" aria-controls="navbarTop" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarTop">
                {!! $menu->outputMenu() !!}
                    <ul class="navbar-nav">
                        @guest
                            <li class="nav-item"><a href="/register" class="nav-link" ><i class="fa fa-user-plus"></i> Register </a></li>
                        @else
                            <li class="nav-item"><a href="#" class="nav-link" onclick="document.getElementById('logout').submit()"><i class="fa fa-lock"></i> Logout </a></li>
                            <form id="logout" action="{{ route('logout') }}" method="POST">@csrf</form>
                        @endguest
                    </ul> <!-- navbar-nav.// -->
            </div> <!-- collapse.// -->
        </div>
    </nav>
    @if(!Route::is('login'))
    <section class="header-main shadow-sm">
        <div class="container">
            <div class="row-sm align-items-center">
                <div class="col-lg-4-24 col-sm-3">
                        <div class="category-wrap dropdown py-1">
                        <button type="button" class="btn btn-light  dropdown-toggle" data-toggle="dropdown" ><i class="fa fa-bars"></i> Categories</button>
                        <div class="dropdown-menu">
                            @foreach($categories as $category)
                                <a class="dropdown-item" href="{{ $category->slug() }}">{{ $category->name }} </a>
                            @endforeach 
                        </div>
                    </div>
                </div>
                <div class="col-lg-11-24 col-sm-8">
                    <form action="{{ route('search') }}" method="GET" class="py-1">
                        <div class="input-group w-100">
                            <select class="custom-select" name="type">
                                <option value="0">All type</option>
                                <option value="latest" @if (old('type') === 'latest')
                                    selected
                                @endif>Latest</option>
                            </select>
                            <input name="name" type="text" class="form-control" style="width:50%;" placeholder="Search" value="{{ old('name') }}">
                            <div class="input-group-append">
                                <button class="btn btn-warning" type="submit">
                                    <i class="fa fa-search"></i> Search
                                </button>
                            </div>
                        </div>
                    </form> <!-- search-wrap .end// -->
                </div> <!-- col.// -->
                <div class="col-lg-9-24 col-sm-12">
                    <div class="widgets-wrap float-right row no-gutters py-1">
                        <div class="col-auto">
                            @guest
                                <div class="widget-header dropdown">
                                    <a href="#" data-toggle="dropdown" data-offset="20,10">
                                        <div class="icontext">
                                            <div class="icon-wrap"><i class="text-warning icon-sm fa fa-user"></i></div>
                                                <div class="text-wrap text-dark">
                                                    Sign in <br>
                                                    My account <i class="fa fa-caret-down"></i>
                                                </div>
                                        </div>
                                    </a>
                                    <div class="dropdown-menu">
                                        <form class="px-4 py-3" action="{{ route('login') }}" method="POST">
                                            @csrf
                                            <div class="form-group">
                                                <label>Email address</label>
                                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="email@example.com">
                                                @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label>Password</label>
                                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="******">
                                                @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="remember" id="remember">
                                                <label class="form-check-label" for="remember">
                                                    Remember Me
                                                </label>
                                            </div>
                                            <button type="submit" class="btn btn-primary">Sign in</button>
                                        </form>
                                        <hr class="dropdown-divider">
                                        <a class="dropdown-item" href="{{ route('register') }}">Have account? Sign up</a>
                                        <a class="dropdown-item" href="{{ route('password.request') }}">Forgot password?</a>
                                    </div> <!--  dropdown-menu .// -->
                                </div>  <!-- widget-header .// -->
                                @else
                                <div class="widget-header dropdown">
                                    <a href="{{ route('home.account.index') }}">
                                        <div class="icontext">
                                            <div class="icon-wrap"><i class="text-warning icon-sm fa fa-user"></i></div>
                                            <div class="text-wrap text-dark">
                                                {{ auth()->user()->name }} <br>
                                                My account <i class="fa fa-caret-right"></i>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endguest
                            
                            <a href="#" data-toggle="dropdown" data-offset="20,10">
                                <div class="icontext">
                                    <div class="icon-wrap">&nbsp;         &nbsp;</div>
                                        <div class="text-wrap text-dark">
                                            &nbsp;&nbsp;
                                            &nbsp;&nbsp;
                                            &nbsp;&nbsp;
                                            &nbsp;&nbsp;
                                        </div>
                                </div>
                            </a>
                        </div> <!-- col.// -->
                    </div> <!-- widgets-wrap.// row.// -->
                </div> <!-- col.// -->
            </div> <!-- row.// -->
        </div> <!-- container.// -->
    </section> <!-- header-main .// -->
    @endif
</header> <!-- section-header.// -->
