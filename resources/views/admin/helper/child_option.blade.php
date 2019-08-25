<li>
    <a data-id="{{ $child_category->id }}" class="option-a child" href="#">
        <i class="fa fa-square-o" aria-hidden="true"></i>
        {{ $child_category->name }}
    </a>
    <ul class="option-ul">
    @foreach ($child_category->children as $child)
        @include('admin.helper.child_option', ['child_category' => $child])
    @endforeach
    </ul>
</li>