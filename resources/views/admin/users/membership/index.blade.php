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
                <li class="breadcrumb-item"><a href="{{ route("products.index") }}">All Products</a></li>
                <li class="breadcrumb-item active">View Product</li>
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
                                <div class="card-header"><i class="fa fa-view"></i>View Product</div>
                                <div class="card-body">
                                    @if(!blank($memberships))
                                    <table class="table table-responsive-sm table-sm">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Price</th>
                                                <th>Shop limit</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($memberships as $membership)
                                                <tr>
                                                    <td>{{ $membership->name }}</td>
                                                    <td>{{ $membership->price }}</td>
                                                    <td>{{ $membership->shop_limit }}</td>
                                                    <td>
                                                        <a href="#" type="button" data-toggle="modal" data-target="#successModal" data-id="{{ $membership->id }}" data-name="{{ $membership->name }}" data-price="{{ $membership->price }}" data-shop_limit="{{ $membership->shop_limit }}" class="text-dark membership_edit"><i class="fa fa-pencil"></i></a>
                                                        <a href="#" data-id="{{ $membership->id }}" class="text-danger ml-3 membership_delete"><i class="fa fa-trash"></i></a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <form id="membership_deletion_form" action="/" method="post">@csrf @method("DELETE")</form>
                                    @else 
                                    <p>
                                        There are no membership yet!
                                    </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <!-- /.col-->
                    </div>
                    <!-- /.row-->
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-header">Add membership</div>
                                <div class="card-body">
                                    <form action="{{ route('admin.membership.store') }}" method="post" enctype="multipart/form-data">
                                        @csrf

                                        <input type="text" name="name" class="form-control" placeholder="Membership Name" required>
                                        <input type="number" name="price" class="form-control" placeholder="Price" required>
                                        <input type="number" name="shop_limit" class="form-control" placeholder="Shop limit" required>
                                        <input type="file" name="image" class="form-control" accept=".jpg, .png, .jpeg">

                                        <button class="btn btn-block btn-info">Submit</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-success modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Edit Membership</h4>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
          </div>
          <div class="modal-body">
            <form action="" method="post" id="membership_model_form" enctype="multipart/form-data">
                @csrf
                @method("PATCH")
                <input type="text" name="name" class="form-control" placeholder="Membership Name" required>
                <input type="number" name="price" class="form-control" placeholder="Price" required>
                <input type="number" name="shop_limit" class="form-control" placeholder="Shop limit" required>
                <input type="file" name="image" class="form-control" accept=".jpg, .png, .jpeg">
            </form>
          </div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
            <button id="membership_model_form_sub" class="btn btn-success" type="button">Save</button>
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
    <script>
        $(document).ready(function(){
            $(".membership_edit").click(function(){
                let form = $("#membership_model_form"),
                    name = $(this).data().name,
                    price = $(this).data().price,
                    shop_limit = $(this).data().shop_limit,
                    id = $(this).data().id;

                form.attr('action','/admin/memberships/'+id);
                form.children('input[name=name]').val(name);
                form.children('input[name=price]').val(price);
                form.children('input[name=shop_limit]').val(shop_limit);

            })
            $("#membership_model_form_sub").click(function(){
                $(this).html(`
                    <i class="fa fa-refresh fa-spin"></i> Saving...
                `).attr('disabled', true);
                $("#membership_model_form").submit();
            })
            $(".membership_delete").click(function(){
                let id = $(this).data().id;
                $("#membership_deletion_form").attr('action','/admin/memberships/'+id).submit();

            })
        })
    </script>
    </body>
@endsection
