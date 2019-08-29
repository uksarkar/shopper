<ul>
    <li class="list-group-item">
        <div class="row">
            <div class="col-sm-4">
                <div class="thumbnail"><img class="img img-thumbnail" src=" /images/1566705023_Dotlon-logo.png " alt="image" width="100"></div>
            </div>
            <div class="col-sm-4">
                <div>{{ $child->name }}</div>
                <div class="small text-muted">Slug: {{ $child->slug }}</div>
            </div>
            <div class="col-sm-4 text-right">
                <input data-id="{{ $child->id }}" type="checkbox" name="category" @if (!is_null($hasContent[$child->id]))
                        disabled
                    @endif>
            </div>
        </div>
    </li>
        @if(!blank($child->children))
            @foreach ($child->children as $child)
                @include('admin.helper.content_category_child',['child'=>$child])
            @endforeach
        @endif
</ul>