@props([
    'disabled' => false,
    'options' => [],
    'selected' => null,
    'placeholder' => null,
])

<select
    {{ $disabled ? 'disabled' : '' }}
    {{ $attributes->merge([
        'class' => 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full'
    ]) }}
>
    @if($placeholder)
        <option value="" disabled {{ is_null($selected) ? 'selected' : '' }}>
            {{ $placeholder }}
        </option>
    @endif

    @if($slot->isNotEmpty())
        {{ $slot }}
    @else
        @foreach($options ?? [] as $value => $label)
            <option value="{{ $value }}" {{ (string) $value === (string) $selected ? 'selected' : '' }}>
                {{ $label }}
            </option>
        @endforeach
    @endif
</select>
