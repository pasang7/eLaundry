@php
$segments = [];
$l = count(Request::segments()) - 1;
@endphp

@switch(Request::segments()[$l])
    @case('edit')
        @php
            $l--;
            $segments = array_slice(Request::segments(), 0, $l);
            $segments[] = $model->slug; // Model that passed to this included blade file
        @endphp
    @break
    @default
        @php $segments=Request::segments() @endphp
@endswitch

@php
$link = '';
@endphp
@foreach ($segments as $sg)
    @php $link.='/'.$sg @endphp
    @if ($loop->index < $l)
        <li class="breadcrumb-item">
            <a href="{{ $link }}">{{ ucfirst($sg == 'admin' ? 'home' : $sg) }}</a>
        </li>
    @else
        <li class="breadcrumb-item active">
            {{ ucfirst($sg) }}
        </li>
    @endif
@endforeach
