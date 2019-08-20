<ul>
    @foreach($helper->sliderSection()->left_menu->take(5) as $menu)
            <li>{{ $menu->name }}</li>
    @endforeach
</ul>
