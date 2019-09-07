<!-- ========================= SECTION ITEMS ========================= -->
<section class="section-request bg padding-y-sm">
    <div class="container">
        <header class="section-heading heading-line">
            <h4 class="title-section bg text-uppercase">Recommended items</h4>
        </header>

        <div class="row-sm">
            @foreach ($items->products as $product)
            <div class="col-md-2">
                <figure class="card card-product">
                    <div class="img-wrap"> <img src="@isset($product->image){{ $product->image->url }}@endisset "></div>
                    <figcaption class="info-wrap">
                        <h6 class="title "><a href="{{ $product->slug() }}">{{ $product->name }}</a></h6>

                        <div class="price-wrap">
                            <span class="price-new">
                                Starting at <span class="text-success">{{ $product->monySign() }}{{ $product->lowestPrice()['price'] }}</span> in {{ $product->lowestPrice()['count'] }} shops.
                            </span>
                        </div> <!-- price-wrap.// -->

                    </figcaption>
                </figure> <!-- card // -->
            </div> <!-- col // -->
            @endforeach
        </div> <!-- row.// -->


    </div><!-- container // -->
</section>
<!-- ========================= SECTION ITEMS .END// ========================= -->
