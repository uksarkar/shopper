<!-- ========================= SECTION CONTENT ========================= -->
<section class="section-content padding-y-sm bg">
    <div class="container">

        <header class="section-heading heading-line">
            <h4 class="title-section bg text-uppercase">{{ $content->header }}</h4>
        </header>

        <div class="card">
            <div class="row no-gutters">
                <div class="col-md-3">

                    <article href="#" class="card-banner h-100 bg2">
                        <div class="card-body zoom-wrap">
                            <h5 class="title">{{ $content->title }}</h5>
                            <p>{{ $content->content }}</p>
                            <a href="{{ $content->url }}" class="btn btn-warning">Explore</a>
                            <img src="@isset($content->image){{ $content->image->url }}@else images/items/item-sm.png @endisset" height="200" class="img-bg zoom-in">
                        </div>
                    </article>

                </div> <!-- col.// -->
                <div class="col-md-9">
                    @isset($content->categories)
                    <ul class="row no-gutters border-cols">
                        @foreach ($content->categories as $category)
                        <li class="col-6 col-md-3">
                            <a href="{{ $category->getRoute($category->id) }}" class="itembox">
                                <div class="card-body">
                                    <p class="word-limit">{{ $category->name }}</p>
                                    <img class="img-sm" src="@isset($category->image){{ $category->image->url }}@else images/items/1.jpg @endisset">
                                </div>
                            </a>
                        </li>
                        @endforeach
                    </ul>
                    @endisset
                </div> <!-- col.// -->
            </div> <!-- row.// -->

        </div> <!-- card.// -->

    </div> <!-- container .//  -->
</section>
<!-- ========================= SECTION CONTENT END// ========================= -->
