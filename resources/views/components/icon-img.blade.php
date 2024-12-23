@if ($attributes->has('href'))
    <a href="{{ $href }}" class="u-flex">
@endif
    <div class="tile__icon mt-1">
        <figure class="w-6">
            <img alt="{{ $alt ?? '' }}" loading="lazy" src="{{ $src ?? '' }}">
        </figure>
    </div>

{{ $slot }}
@if ($attributes->has('href'))
    </a>
@endif
