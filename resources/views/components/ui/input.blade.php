@props(['label' => null, 'name' => null, 'required' => false])

<div {{ $attributes->only('class')->merge(['class' => '']) }}>
    @if ($label)
        <label @if($name) for="{{ $name }}" @endif class="ui-label">
            {{ $label }}
            @if ($required)<span class="text-red-500">*</span>@endif
        </label>
    @endif
    <input {{ $attributes->merge(['class' => 'ui-input'])->except('label', 'required') }} />
    @if ($name)
        <x-input-error :messages="$errors->get($name)" class="mt-1.5" />
    @endif
</div>
