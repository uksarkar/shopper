@if($child_category->id != $category->id)
<li>
    <a data-id="{{ $child_category->id }}" class="option-a child" href="#">
        <i class="fa @if($child_category->id == $category->parent_id)fa-check-square-o @else fa-square-o @endif" aria-hidden="true"></i>
        {{ $child_category->name }}
    </a>
    <ul class="option-ul">
    @foreach ($child_category->children as $child)
        @include('admin.helper.edit_child_option', ['child_category' => $child])
    @endforeach
    </ul>
</li>
@endif