@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-medium text-sm text-gray-700 dark:text-gray-300']) }}>
    {{ $value ?? $slot }}
    @if ($attributes->has('required'))
        <span class="text-red-500" style="color: #ef4444 !important;">*</span>
    @endif
</label>
