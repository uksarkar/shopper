<div class="card" style="margin-left:-15px">
    <article class="card-group-item">
        <header class="card-header"><h6 class="title">{{ auth()->user()->name }} </h6></header>
        <div class="filter-content">
            <div class="list-group">
                <a class="list-group-item rounded-0 @if(Route::is('home.account.index'))active @else list-group-item-action @endif" href="{{ route('home.account.index') }}">Account Dashboard</a>
                <a class="list-group-item rounded-0 @if(Route::is('home.account.shops'))active @else list-group-item-action @endif" href="{{ route('home.account.shops') }}">Shops</a>
                <a class="list-group-item rounded-0 @if(Route::is('home.account.products'))active @else list-group-item-action @endif" href="{{ route('home.account.products') }}">Products</a>
                <a class="list-group-item rounded-0 list-group-item-action" href="#">Favorites</a>
                <a class="list-group-item rounded-0 list-group-item-action" href="#">Account Information</a>
                <a class="list-group-item rounded-0 list-group-item-action" href="#">Address Book</a>
                <a class="list-group-item rounded-0 list-group-item-action" href="#">Membership</a>
                <a class="list-group-item rounded-0 list-group-item-action" href="#">Newsletter Subscriptions</a>
                <a class="list-group-item rounded-0 list-group-item-action" href="#">My Reward Points</a>
                <a class="list-group-item rounded-0 list-group-item-action" href="#">My Questions</a>
            </div>
        </div>
    </article> <!-- card-group-item.// -->
</div> <!-- card.// -->