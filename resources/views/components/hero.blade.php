<div class="hero u-text-center {{ $class ?? '' }}" id="{{ $id ?? '' }}">
<div class="hero-body pb-0">
<div class="content">
	<h2 class="headline-4">
		<a class="text-black" href="#{{ $id ?? '' }}">
			{{ $title }}
		</a>
	</h2>

	<p class="lead">
        {{ $desc }}
	</p>

    {{ $slot }}
</div>
</div>
</div>
