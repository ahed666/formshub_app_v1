<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800  leading-tight">
            {{ __('Subscribe') }}
        </h2>
    </x-slot>
@livewire('subscribe',['action' => $type,'id'=>$id])
</x-app-layout>
@push('scripts')
<script src="{{ asset('https://js.stripe.com/v3/') }}"></script>

@endpush
