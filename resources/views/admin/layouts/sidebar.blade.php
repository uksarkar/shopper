<div class="sidebar">
    <nav class="sidebar-nav">
        <ul class="nav">
            <li class="nav-item"><a class="nav-link" href="{{ route("admin") }}"><i class="nav-icon icon-speedometer"></i> Dashboard</a></li>
            <li class="nav-title">Products</li>
                <li class="nav-item nav-dropdown"><a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon icon-briefcase"></i> Products</a>
                    <ul class="nav-dropdown-items">
                        <li class="nav-item"><a class="nav-link" href="{{ route("products.index") }}"><i class="nav-icon icon-layers"></i> All Products</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route("products.create") }}"><i class="nav-icon icon-plus"></i> Add Product</a></li>
                    </ul>
                </li>
                <li class="nav-item"><a class="nav-link" href="{{ route("config.category") }}"><i class="nav-icon icon-menu"></i> Categories</a></li>
            <li class="nav-title">Pages</li>
                <li class="nav-item"><a class="nav-link" href="{{ route("page.index") }}"><i class="nav-icon icon-layers"></i> All Pages</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route("page.create") }}"><i class="nav-icon icon-plus"></i> Add Page</a></li>
            <li class="nav-title">Media</li>
                <li class="nav-item"><a class="nav-link" href="{{ route("photos.index") }}"><i class="nav-icon icon-grid"></i> Photos</a></li>
            <li class="nav-title">Users</li>
                <li class="nav-item nav-dropdown"><a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon icon-user"></i> Users</a>
                    <ul class="nav-dropdown-items">
                        <li class="nav-item"><a class="nav-link" href="{{ route("users.index") }}"><i class="nav-icon icon-people"></i> All Users</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route("users.create") }}"><i class="nav-icon icon-user-follow"></i> Add User</a></li>
                    </ul>
                </li>
                <li class="nav-item nav-dropdown"><a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon icon-directions"></i> Memberships</a>
                    <ul class="nav-dropdown-items">
                        <li class="nav-item"><a class="nav-link" href="{{ route("admin.membership") }}"><i class="nav-icon icon-paper-clip"></i> Memberships</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route("admin.membership.request") }}"><i class="nav-icon icon-paper-plane"></i> Membership Requests</a></li>
                    </ul>
                </li>
            <li class="nav-title">Shops</li>
                <li class="nav-item"><a class="nav-link" href="{{ route("shops.index") }}"><i class="nav-icon icon-basket-loaded"></i> All Shops</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route("shops.create") }}"><i class="nav-icon icon-plus"></i> Add Shop</a></li>
            <li class="nav-title">Configaretions</li>
                <li class="nav-item"><a class="nav-link" href="{{ route('config') }}"><i class="nav-icon icon-settings"></i> Settings</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('config.homeCustomization') }}"><i class="nav-icon icon-note"></i> Home Page</a></li>
        </ul>
    </nav>
    <button class="sidebar-minimizer brand-minimizer" style="flex: 0 0 100px;" type="button"></button>
</div>
