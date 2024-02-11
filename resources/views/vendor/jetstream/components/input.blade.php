@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border-gray-300  focus:border-secondary mr-2
 focus:ring-secondary  rounded-md shadow-sm']) !!}
>
