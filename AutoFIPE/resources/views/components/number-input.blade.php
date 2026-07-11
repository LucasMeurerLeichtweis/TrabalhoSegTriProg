@props(['disabled' => false])

@php
    $defaultClasses = 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none';
@endphp

<input
    type="number"
    maxlength="6"
    max="999999"
    @disabled($disabled)
    onkeydown="if(['+', '-', 'e', 'E', ',', '.'].includes(event.key)) event.preventDefault();"
    oninput="if(this.value.length > 6) this.value = this.value.slice(0, 6);"
    class="{{ trim(($attributes->get('class') ? $attributes->get('class').' ' : '').$defaultClasses) }}"
    {{ $attributes->except('class')->merge([
        'step' => '1',
        'min' => '0'
    ]) }}
>

