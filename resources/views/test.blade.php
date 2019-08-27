@isset($record)
    @foreach($zipreturns as $zipreturn)
    <div>
    {!!$zipreturn->returns!!}
    </div>
    @endforeach
@else
    nothing here
    {{-- This is comment --}}
@endisset
