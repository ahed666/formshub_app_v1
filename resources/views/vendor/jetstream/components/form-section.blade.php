@props(['submit'])

<div {{ $attributes->merge(['class' => 'md:grid md:grid-cols-3 md:gap-6 ']) }}>
    <x-jet-section-title>
        <x-slot name="title">{{ $title }}</x-slot>
        <x-slot name="description">{{ $description }}</x-slot>
    </x-jet-section-title>

    <div class="mt-5 md:mt-0 md:col-span-2 shadow rounded-[0.5rem]  ">
        <form wire:submit.prevent="{{ $submit }}">
            <div class="px-4 py-5 bg-white sm:p-6  {{ isset($actions) ? 'rounded-tl-lg rounded-tr-lg' : 'rounded-lg' }}">
                <div class="grid grid-cols-6 gap-6">
                    {{ $form }}
                </div>
            </div>

            @if (isset($actions))
                <div class="flex items-center bg-white justify-start px-4 py-3 text-right sm:px-6  rounded-bl-lg rounded-br-lg">
                    {{ $actions }}
                </div>
            @endif
        </form>
    </div>
</div>
