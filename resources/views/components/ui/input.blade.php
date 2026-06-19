@props(['label' => null, 'name' => null, 'required' => false])

@php
    $hasError = $name && $errors->has($name);
    $inputClass = 'ui-input' . ($hasError ? ' border-red-300 focus:border-red-500 focus:ring-red-500' : '');
@endphp

<div {{ $attributes->only('class')->merge(['class' => '']) }}>
    @if ($label)
        <label @if($name) for="{{ $attributes->get('id', $name) }}" @endif class="ui-label">
            {{ $label }}
            @if ($required)<span class="text-red-500">*</span>@endif
        </label>
    @endif
    <input
        @if($name) name="{{ $name }}" @endif
        @if($required) required @endif
        {{ $attributes->merge(['class' => $inputClass]) }}
    />
    @if ($name)
        <x-input-error :messages="$errors->get($name)" class="mt-1.5" />
    @endif
</div>
