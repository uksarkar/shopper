<!-- ========================= SECTION MAIN ========================= -->
<section class="section-main bg padding-y-sm">
    <div class="container">
        <div class="card">
            <div class="card-body">
                <div class="row row-sm">
                    <aside class="col-md-3">
                        <h5 class="text-uppercase">{{ \App\Helper::sliderSection()->leftName }}</h5>
                        <ul class="menu-category">
                            @foreach(\App\Helper::sliderSection()->left_menu->take(6) as $slider)
                                <li> <a href="{{ $slider->key_1 }}">{{ $slider->name }} </a></li>
                            @endforeach
                            @if(count(\App\Helper::sliderSection()->left_menu) > 6)
                                <li class="has-submenu"> <a href="#">More .....  <i class="icon-arrow-right pull-right"></i></a>
                                    <ul class="submenu">
                                        @foreach(\App\Helper::sliderSection()->left_menu->slice(6,count(\App\Helper::sliderSection()->left_menu)) as $more)
                                            <li> <a href="{{ $more->key_1 }}">{{ $more->name }} </a></li>
                                        @endforeach
                                    </ul>
                                </li>
                            @endif
                        </ul>

                    </aside> <!-- col.// -->
                    <div class="col-md-6">

                        <!-- ================= main slide ================= -->
                        <div class="owl-init slider-main owl-carousel" data-items="1" data-nav="true" data-dots="false">
                            @foreach(\App\Helper::sliderSection()->images as $image)
                                <div class="item-slide">
                                    <img src="{{ $image->name }}">
                                </div>
                            @endforeach
                        </div>
                        <!-- ============== main slideshow .end // ============= -->

                    </div> <!-- col.// -->
                    <aside class="col-md-3">

                        <h6 class="title-bg bg-secondary"> {{ \App\Helper::sliderSection()->rightName }}</h6>
                        <div style="height:280px;">
                            @foreach(\App\Helper::sliderSection()->right_menu as $menu)
                            <figure class="itemside has-bg border-bottom" style="height: 33%;">
                                <img class="img-bg" src="images/items/item-sm.png">
                                <figcaption class="p-2">
                                    <h6 class="title">{{ $menu->name }} </h6>
                                    <a href="{{ $menu->key_1 }}">{{ $menu->key_2 }}</a>
                                </figcaption>
                            </figure>
                            @endforeach
                        </div>

                    </aside>
                </div> <!-- row.// -->
            </div> <!-- card-body .// -->
        </div> <!-- card.// -->
        @if(!blank(\App\Helper::sliderSection()->banner))
            <figure class="mt-3 banner p-3">
                <img src="{{ \App\Helper::sliderSection()->banner->key_1 }}" alt="{{ \App\Helper::sliderSection()->banner->key_2 }}">
            </figure>
        @endif

    </div> <!-- container .//  -->
</section>
<!-- ========================= SECTION MAIN END// ========================= -->
