@use('App\Helpers\DNS')
<div>
	<!-- Search box -->
    <div class="mt-2">
		<form wire:submit.prevent="search">
			<div class="input-control">
				<input wire:model="text" type="text"
				class="input-contains-icon u-round-sm"
				maxlength="255" placeholder="salonia.it">

				<span class="icon">
					<i data-lucide="text-search" class="text-black w-4"></i>
				</span>
			</div>

			<button style="letter-spacing: 0; text-transform: none"
			class="bg-blue-600 u-border-1 border-blue-700 text-white u-round-sm text-md">
				Search
				<i data-lucide="arrow-right" class="text-white w-4 u-align-middle"></i>
			</button>
		</form>
	</div>

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
</div>
