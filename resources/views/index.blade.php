@include('static/head')

<body>
@include('static/header')

<!-- Content -->
<div class="hero u-text-center mt-12">
<div class="hero-body pb-6">
<div class="content">
	<x-card>
		<img class="bg-black u-round-sm u-center w-64 p-2" alt="OpenAlias logo"
		src="{{ Vite::asset('resources/img/oa.png') }}">

		<p class="lead" style="line-height: 1.45rem">
			🇬🇧󠁧󠁢󠁥󠁮󠁧󠁿 Enter a domain in the textbox below to obtain all of its OpenAlias records.
		</p>

		<p class="lead" style="line-height: 1.45rem">
			🇮🇹 Inserisci un dominio nella casella di testo sottostante per ottenere tutti i suoi record OpenAlias.
		</p>

		<livewire:search lazy />
	</x-card>

	<div class="u-center mt-8">
		<a class="u u-LR font-bold u-flex text-gray-900 pb-0"
		href="https://github.com/saloniamatteo/openalias">
			<i data-lucide="github" class="w-3"></i>
			&nbsp;Github
		</a>
	</div>
</div>
</div>
</div>

@include('static/footer')
</body>
</html>
