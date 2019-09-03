<!-- ========================= SECTION MAIN ========================= -->
<section class="section-main bg padding-y-sm">
    <div class="container">
        <div class="card">
            <div class="card-body">
                <div class="row row-sm">
                    <aside class="col-md-3">
                        <h5 class="text-uppercase">My markets</h5>
                        <ul class="menu-category">
                            @foreach($categories->take(6) as $category)
                                <li> <a href="{{ $category->slug() }}">{{ $category->name }} </a></li>
                            @endforeach
                            @if(count($categories) > 6)
                                <li class="has-submenu"> <a href="#">More .....  <i class="icon-arrow-right pull-right"></i></a>
                                    <ul class="submenu">
                                        @foreach($categories->slice(6,count($categories)) as $category)
                                            <li> <a href="{{ $category->slug() }}">{{ $category->name }} </a></li>
                                        @endforeach
                                    </ul>
                                </li>
                            @endif
                        </ul>

                    </aside> <!-- col.// -->
                    <div class="col-md-6">

                        <!-- ================= main slide ================= -->
                        <div class="owl-init slider-main owl-carousel" data-items="1" data-nav="true" data-dots="false">
                            <div class="item-slide">
                                <img src="/images/banners/slide1.jpg">
                            </div>
                            <div class="item-slide">
                                <img src="/images/banners/slide2.jpg">
                            </div>
                            <div class="item-slide">
                                <img src="/images/banners/slide3.jpg">
                            </div>
                        </div>
                        <!-- ============== main slideshow .end // ============= -->

                    </div> <!-- col.// -->
                    <aside class="col-md-3">

                        <h6 class="title-bg bg-secondary">Recommended</h6>
                        <div style="height:280px;">
                            @foreach($items->products->take(3) as $product)
                            <figure class="itemside has-bg border-bottom" style="height: 33%;">
                                <img class="img-bg" src="images/items/item-sm.png">
                                <figcaption class="p-2">
                                    <h6 class="title">{{ $product->name }} </h6>
                                    <a href="{{ $product->slug() }}">{{ $product->name }}</a>
                                </figcaption>
                            </figure>
                            @endforeach
                        </div>

                    </aside>
                </div> <!-- row.// -->
            </div> <!-- card-body .// -->
        </div> <!-- card.// -->
        <figure class="mt-3 banner p-3">
            banner goes here
            {{-- <img src="/images/banners/bg-cpu.jpg" alt="image"> --}}
        </figure>

    </div> <!-- container .//  -->
</section>
<!-- ========================= SECTION MAIN END// ========================= -->
