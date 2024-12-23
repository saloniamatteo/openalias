<div class="content u-text-left w-90p-md">
<div class="card u-border-1 border-gray-500">
<div {{ $attributes->class(['m-2' => !$attributes->has('class')]) }}>
    {{ $slot }}
</div>
</div>
</div>
