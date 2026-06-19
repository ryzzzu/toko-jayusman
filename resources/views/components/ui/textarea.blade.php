@props(['label' => null, 'name' => null, 'required' => false])

<div>
    @if ($label)
        <label @if($name) for="{{ $name }}" @endif class="ui-label">
            {{ $label }}
            @if ($required)<span class="text-red-500">*</span>@endif
        </label>
    @endif
    <textarea {{ $attributes->merge(['class' => 'ui-textarea'])->except('label', 'required') }}>{{ $slot }}</textarea>
    @if ($name)
        <x-input-error :messages="$errors->get($name)" class="mt-1.5" />
    @endif
</div>
