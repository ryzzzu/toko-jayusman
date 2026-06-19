@props(['label' => null, 'name' => null, 'required' => false])

<div>
    @if ($label)
        <label @if($name) for="{{ $name }}" @endif class="ui-label">
            {{ $label }}
            @if ($required)<span class="text-red-500">*</span>@endif
        </label>
    @endif
    <select
        @if($name) name="{{ $name }}" @endif
        @if($required) required @endif
        {{ $attributes->merge(['class' => 'ui-select']) }}
    >
        {{ $slot }}
    </select>
    @if ($name)
        <x-input-error :messages="$errors->get($name)" class="mt-1.5" />
    @endif
</div>
