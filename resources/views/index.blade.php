@use('App\Helpers\DNS')
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

		<form class="mt-4" method="GET" onsubmit="return submitForm()">
			<div class="input-control">
				<input id="domain" type="text" placeholder="example.com"
				class="input-contains-icon u-round-sm" class="w-64"
				@if (isset($data))
					value='{{ $data["domain"] }}'
				@endif
				>

				<span class="icon">
					<i data-lucide="text-search" class="text-black w-4"></i>
				</span>
			</div>

			<button style="letter-spacing: 0; text-transform: none"
			class="bg-blue-600 u-border-1 border-blue-700 text-white u-round-sm text-md">
				Submit
				<i data-lucide="arrow-right" class="text-white w-4 u-align-middle"></i>
			</button>
		</form>

		<!-- If we have data, show card -->
		@if (!empty($data))
			@php
				$records = $data["records"];
				$dnssec  = $data["dnssec"];

				// Based on record count, color the card appropriately
				$rcount = count($records);

				if ($rcount == 0) {
					$card_border = "red-400";
					$card_bg     = "red-200";
					$dtext_color = "black";
				} else {
					$card_border = "blue-400";
					$card_bg     = "blue-200";
					$dtext_color = "blue-600";
				}
			@endphp

			<div class="card u-border-2 border-{{ $card_border }} bg-{{ $card_bg }} p-2">
				@php
					// Check DNSSEC status
					if ($dnssec) {
						$dnssec_icon = "circle-check";
						$dnssec_color = "#31c48d";
						$dnssec = "OK";
					} else {
						$dnssec_icon = "circle-x";
						$dnssec_color = "#f05252";
						$dnssec = "FAIL";
					}
				@endphp

				<!-- DNSSEC status -->
				<div class="tile level">
				<div class="tile__icon">
					<i data-lucide="{{ $dnssec_icon }}"
					class="w-4 text-white text-lg"
					style="fill: {{ $dnssec_color }}"></i>
				</div>

				<div class="tile__container pl-0" style="margin-left: 0.2rem">
				<h5 class="mt-1 text-{{ $dtext_color }}">
					DNSSEC {{ $dnssec }}
				</h5>
				</div>
				</div>

				<!-- Record table -->
				@if (count($records) == 0)
					<p class="mb-0 text-lg">🇬🇧&nbsp;&nbsp;No records found.</p>
					<p class="mt-0 text-lg">🇮🇹&nbsp;&nbsp;Nessun dato trovato.</p>
				@else
					<div class="table-container">
					<table class="table striped bordered bg-white u-round-sm u-text-center">
						<thead>
						<tr>
							<th style="max-width: 4rem">OA1 Type</th>
							<th>Address</th>
							<th style="min-width: 9rem">Recipient Name</th>
							<th>TX Description</th>
							<th>TX Amount</th>
						</tr>
						</thead>

						<tbody>
						@php
						// Iterate over each record, and create table entry
						foreach ($records as $record) {
							// Get matches from DNS helper
							$data = DNS::getData($record);

							// Make table entry
							echo "<tr>";

							// Iterate over data
							foreach ($data as $entry)
								echo "<td>$entry</td>";

							// Finish table entry
							echo "</tr>";
						}
						@endphp
						</tbody>
					</table>
					</div>
				@endif
			</div>
		@endif
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
