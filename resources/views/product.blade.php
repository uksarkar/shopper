@extends('layouts.app')
@section('title')
    Ditails of {{ $product->name }}
@endsection
@section('content')
    @include('helpers.header')
<!-- ========================= SECTION TOPBAR ========================= -->
<section class="section-topbar border-top padding-y-sm">
        <div class="container">
            <span>Ditails of {{ $product->name }}</span>
        </div> <!-- container.// -->
        </section>
        <!-- ========================= SECTION TOPBAR .// ========================= -->
        
        <!-- ========================= SECTION CONTENT ========================= -->
        <section class="section-content bg padding-y-sm">
        <div class="container">
        <nav class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            @foreach (explode('/', $product->cat_slug) as $k => $slug)
                @if($k > 0)
                    <li class="breadcrumb-item"><a href="{{ $product->category->getNameSlugOfCategory($slug)['slug'] }}">{{ $product->category->getNameSlugOfCategory($slug)['name'] }}</a></li>
                @endif
            @endforeach
            <li class="breadcrumb-item active"><a href="{{ $product->slug }}">{{ $product->name }}</a></li>
        </ol>  
        </nav>
        
        <div class="row">
        <div class="col-xl-10 col-md-9 col-sm-12">
        
        
        <main class="card">
            <div class="row no-gutters">
                <aside class="col-sm-6 border-right">
        <article class="gallery-wrap"> 
        <div class="img-big-wrap">
          <div> <a href="@isset($product->image){{ $product->image->url }}@endisset" data-fancybox=""><img src="@isset($product->image){{ $product->image->url }}@endisset"></a></div>
        </div> <!-- slider-product.// -->
        <div class="img-small-wrap">
          <div class="item-gallery"> <img src="images/items/1.jpg"></div>
          <div class="item-gallery"> <img src="images/items/2.jpg"></div>
          <div class="item-gallery"> <img src="images/items/3.jpg"></div>
          <div class="item-gallery"> <img src="images/items/4.jpg"></div>
        </div> <!-- slider-nav.// -->
        </article> <!-- gallery-wrap .end// -->
                </aside>
                <aside class="col-sm-6">
        <article class="card-body">
        <!-- short-info-wrap -->
            <h3 class="title mb-3">{{ $product->name }}</h3>
        
        <div class="mb-3"> 
            <var class="price h3 text-warning"> 
                <span class="currency">{{ $product->monySing() }}</span><span class="num">{{ $product->lowestPrice()['price'] }}</span>
            </var>
        </div> <!-- price-detail-wrap .// -->
        {{-- <dl>
          <dt>Description</dt>
          <dd><p></p></dd>
        </dl> --}}
        <dl class="row">
        @if(!blank($product->metas))
            @foreach ($product->metas as $meta)
                <dt class="col-sm-3">{{ $meta->name }}</dt>
                <dd class="col-sm-9">{{ $meta->data }}</dd>
            @endforeach
        @endif
        </dl>
        <hr>
            <div class="row">
                <div class="col-sm-12">
                    @if(!blank($product->prices))
                        {{ $product->prices()->orderBy('amounts')->first()->shop->name }}
                    @else
                        This product is not available in any shop yet!
                    @endif
                </div> <!-- col.// -->
            </div> <!-- row.// -->
            <hr>
            @if(!blank($product->prices))
                <a href="/shop/{{ $product->prices()->orderBy('amounts')->first()->shop->id }}" class="btn  btn-warning"> <i class="fa fa-envelope"></i> Contact Supplier </a>
            @endif
            
            @auth
                @if($product->hasShop() && auth()->user()->can('create product'))
                    <button data-id="{{ $product->id }}" class="btn btn-outline-success addProductBtn" type="button" data-toggle="modal" data-target="#addProductModel">
                        <i class="fa fa-plus"></i> Add to your shop
                    </button>
                @endif
            @endauth
        <!-- short-info-wrap .// -->
        </article> <!-- card-body.// -->
        </aside> <!-- col.// -->
    </div> <!-- row.// -->
</main> <!-- card.// -->
        
        <!-- PRODUCT DETAIL -->
        <article class="card mt-3">
            <div class="card-body">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#description">Detail overview</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#All_shops">Shops</a>
                    </li>
                </ul>
                
                <div class="tab-content">
                <div id="description" class="tab-pane fade in active show">
                    {!! $product->description !!}
                </div>
                <div id="All_shops" class="tab-pane fade">
                @if(!blank($prices))
                    <table class="table table-responsive-sm table-bordered table-striped table-sm">
                        <thead>
                            <tr>
                                <th>Shop Name</th>
                                <th>Price</th>
                                <th>Location</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($prices as $price)
                                <tr>
                                    <td><a href="/shop/{{ $price->shop->id }}" class="btn btn-link">{{ $price->shop->name }}</a></td>
                                    <td>{{$product->monySing(). $price->amounts }}</td>
                                    <td>{{ $price->shop->location }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mx-auto flex-column">
                        {!! $prices->links() !!}
                    </div>
                @else
                    <p>
                        There are no shop yet!
                    </p>
                @endif
                </div>
                </div>
            </div> <!-- card-body.// -->
        </article> <!-- card.// -->
        
        <!-- PRODUCT DETAIL .// -->
        
        </div> <!-- col // -->
        <aside class="col-xl-2 col-md-3 col-sm-12">
        <div class="card">
            <div class="card-header">
                You may like
            </div>
            <div class="card-body row">
                @foreach ($similar_products as $like_product)
                <div class="col-md-12 col-sm-3">
                    <figure class="item border-bottom mb-3">
                            <a href="#" class="img-wrap"> <img src="@isset($like_product->image){{ $like_product->image->url }}@endisset" class="img-md"></a>
                            <figcaption class="info-wrap">
                                <a href="{{ $like_product->slug() }}" class="title">{{ $like_product->name }}</a>
                                <div class="price-wrap mb-3">
                                    <span class="price-new">{{ $product->monySing().$like_product->lowestPrice()['price'] }}</span>
                                </div> <!-- price-wrap.// -->
                            </figcaption>
                    </figure> <!-- card-product // -->
                </div> <!-- col.// -->
                @endforeach
            </div> <!-- card-body.// -->
        </div> <!-- card.// -->
        </aside> <!-- col // -->
        </div> <!-- row.// -->
        
        
        
        </div><!-- container // -->
        </section>
        <!-- ========================= SECTION CONTENT .END// ========================= -->

        
@auth
    @if(auth()->user()->can('create product'))
        <div class="modal fade show" id="addProductModel" tabindex="-1" role="dialog" aria-labelledby="addProductModel" aria-modal="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add product to your shop</h4>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <div class="modal-body">
                        <form method="POST" id="SubForm" action="{{ route('home.products.store') }}">
                            @csrf
                            <input type="hidden" name="product" value="">
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
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text">Description</span></div>
                                    <textarea class="form-control" id="textarea-input" name="description" rows="9" placeholder="Content.."></textarea>
                                </div>
                            </div>
                        </form>
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
    @endif
@endauth
        
    @include('helpers.subscribe')
    @include('helpers.footer')
@endsection