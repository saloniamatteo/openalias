<div class="card u-border-1 bg-warning">
<div class="m-2">
    <x-tile>
        <div class="tile__icon">
            <i data-lucide="triangle-alert" class="w-4 u-align-text-bottom"></i>
            <strong>{{ __("glob.warning") }}</strong>
        </div>
    </x-tile>

    <p class="mt-0">
        {{ $slot }}
    </p>
</div>
</div>
