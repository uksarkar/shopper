
<ul>
    <li class="list-group-item">
        <a href="{{ route('config.edit.category',$child_category->id) }}">{{ $child_category->name }}</a>
        Slug: {{ $child_category->slug }}
        <button data-id="{{ $child_category->id }}" class="btn btn-link text-danger submitButton" type="button" data-toggle="tooltip" data-placement="top" title="" data-original-title="All sub-category will be deleted!">Delete</button>
    </li>
@if ($child_category->children)
    @foreach ($child_category->children as $h => $childCategory)
        @include('admin.helper.child_category', ['child_category' => $childCategory])
    @endforeach
@endif
</ul>