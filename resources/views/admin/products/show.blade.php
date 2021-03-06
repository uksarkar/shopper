@extends('admin.layouts.app')

@section('title')
    View {{ $product->name }}
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
                <li class="breadcrumb-item"><a href="{{ route("products.index") }}">All Products</a></li>
                <li class="breadcrumb-item active">View Product</li>
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
                                <div class="card-header"><i class="fa fa-view"></i>View Product</div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <img src="@if($product->image){{ $product->image->url }}@else https://via.placeholder.com/300x300.png?text=No+Image @endif" alt="Image" width="300" class="img img-thumbnail">
                                            <hr>
                                            <p class="bg-light p-1 rounded">
                                                Expected price: {{ $product->expected_price }}
                                            </p>
                                        </div>
                                        <div class="col-sm-9">
                                            <h4 class="card-title">{{ $product->name }}</h4>
                                            <div class="card-text">
                                                {!! $product->description !!}
                                            </div>
                                            <div class="card-accent-dark">
                                                <a href="{{ route("products.edit", $product->id) }}" class="btn btn-primary">Edit</a>
                                                <button class="btn btn-danger subbtn" data-sub="d{{ $product->id }}">Delete</button>
                                            </div>
                                            <form data-sub="d{{ $product->id }}" class="formsub" method="POST" action="{{ route("products.destroy", $product->id) }}">@csrf @method("DELETE")</form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.col-->
                    </div>
                    <!-- /.row-->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header"><i class="fa fa-view"></i>Available shop</div>
                                <div class="card-body">
                                    @if(!blank($product->prices))
                                    <table class="table table-responsive-sm table-hover table-outline mb-0">
                                        <thead class="thead-light">
                                        <tr>
                                            <th class="text-center"><i class="icon-picture"></i> Image</th>
                                            <th>Shop Name</th>
                                            <th>Price</th>
                                            <th>Location</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($product->prices as $price)
                                            <tr>
                                                <td class="text-center">
                                                    <div class="thumbnail"><img class="img img-thumbnail" src="@if($price->shop->image) {{ $price->shop->image->url }} @else https://via.placeholder.com/100x100.png?text=No+Image @endif" width="100" alt="image"></div>
                                                </td>
                                                <td>
                                                    <a href="{{ route('shops.show', $price->shop->id ) }}">{{ $price->shop->name }}</a>
                                                    <div class="small text-muted">
                                                        @if($price->shop->user)
                                                            By: {{ $price->shop->user->name }}
                                                        @else
                                                            The user was deleted.
                                                        @endif
                                                    </div>
                                                </td>
                                                <td>
                                                    <p class="bg-light p-1 rounded">{{ $price->amounts }}</p>
                                                </td>
                                                <td>
                                                    {{  $price->shop->url }}
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                        @else
                                        <div class="bg-secondary p-2 rounded">
                                            This product is not available at any shop yet.
                                        </div>
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
