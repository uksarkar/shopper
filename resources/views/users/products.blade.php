@extends('layouts.app')
@section('title')
    Your available products
@endsection
@section('content')
    @include('helpers.header')

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-3">
                @include('helpers.accountSidebar')
            </div>
            <div class="col-sm-9">
                <div class="card mt-3">
                    <div class="card-header">
                        My Products
                    </div>
                    <div class="card-body">
                        @if(!blank($prices))
                        
                        <table class="table table-responsive-sm table-hover table-outline mb-0">
                            <thead class="thead-light">
                            <tr>
                                <th class="text-center"><i class="icon-picture"></i> Image</th>
                                <th>Product Name</th>
                                <th>Actions</th>
                                <th>Your Price</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($prices as $price)
                                    <tr>
                                        <td class="text-center">
                                            <div class="thumbnail">
                                                <img class="img img-thumbnail" src="@if($price->product->image) {{ $price->product->image->url }} @else https://via.placeholder.com/100x100.png?text=No+Image @endif" width="100" alt="image">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="Name">{{ $price->product->name }}</div>
                                            <div class="small text-muted">Created: {{ $price->product->created_at->diffForHumans() }}</div>
                                        </td>
                                        <td>
                                            <a href="{{ $price->product->slug() }}" class="btn btn-sm btn-primary">View</a>
                                            <button class="btn btn-sm btn-info p-edit-button" type="button" data-toggle="modal" data-target="#addProductModel" data-id="{{ $price->product->id }}" data-shop="{{ $price->shop->name }}" data-shop-id="{{ $price->shop->id }}" data-amounts="{{ $price->amounts }}" data-price="{{ $price->id }}">Edit</button>
                                            <button data-sub="e{{ $price->product->id }}" class="btn btn-outline-danger btn-sm subbtn">Remove</button>
                                            <form data-sub="e{{ $price->product->id }}" class="formsub" method="POST" action="/">@csrf @method("DELETE")</form>
                                        </td>
                                        <td class="amt">
                                            {{-- {{  Str::limit($price->product->description, 70, ' (...)') }} --}}
                                            {{ $moneySign.$price->amounts }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @else
                        <p class="text-dark">
                            @if(auth()->user()->shops->count() > 0 && auth()->user()->can('create product'))
                                You doesn't have any product yet. <br> <br>
                                <p class="bg-light px-5 py-2 mt-3 my-auto">
                                    Search your product and click the plus button to add it.
                                </p>
                            @else 
                                You doesn't have any shop yet.
                            @endif
                        </p>
                        @endif
                    </div>
                    <div class="card-footer">
                        <div class="mx-auto flex-column">
                            {{ $prices->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <div class="modal fade show" id="addProductModel" tabindex="-1" role="dialog" aria-labelledby="addProductModel" aria-modal="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Price</h4>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-4" id="model-product-img">
                        {{-- jQuery Will add the image here --}}
                    </div>
                    <div class="col-sm-8">
                        <h4 id="model-product-name" class="mb-2"></h4>
                        <form method="POST" id="SubForm" action="{{ route('home.products.update') }}">
                            @csrf
                            @method("PATCH")
                            <input type="hidden" name="product" value="">
                            <input type="hidden" name="price">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text">Shop</span></div>
                                    <select class="form-control" name="shop" id="shop_options">
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text">Price</span></div>
                                    <input class="form-control" id="amounts" type="number" name="amounts" placeholder="00.000" required>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                <button id="subBtn" class="btn btn-primary" type="button">Save</button>
            </div>
            </div>
            <!-- /.modal-content-->
        </div>
        <!-- /.modal-dialog-->
    </div>

    @include('helpers.subscribe')
    @include('helpers.footer')

    <script>
        $(document).ready(function(){
            $(".p-edit-button").click(function(){
                let img = $(this).parent().parent().find("img").attr("src"),
                    name = $(this).parent().parent().find(".Name").text(),
                    id = $(this).data().id,
                    amounts = $(this).data().amounts,
                    shop_name = $(this).data().shop,
                    shop_id= $(this).data("shop-id"),
                    price = $(this).data().price;

                $("#SubForm").find("input[name=product]").val(id);
                $("#SubForm").find("input[name=price]").val(price);
                $("#shop_options").html(`
                    <option value="${shop_id}" selected>${shop_name}</option>
                `);
                $("#amounts").val(amounts);
                
                $("#model-product-img").html(`
                    <img src="${img}" style="max-height: 200px; max-width: 100%;">
                `);

                $("#model-product-name").html(name);
            });
        })
    </script>


@endsection
