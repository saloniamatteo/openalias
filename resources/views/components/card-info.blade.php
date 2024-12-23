<div class="card u-border-1 border-black bg-info text-white">
<div class="m-2">
    <x-tile>
        <div class="tile__icon">
            <i data-lucide="info" class="w-4 text-white u-align-text-bottom"></i>
            <strong>{{ __("glob.info") }}</strong>
        </div>
    </x-tile>

    <p class="mt-0">
        {{ $slot }}
    </p>
</div>
</div>
