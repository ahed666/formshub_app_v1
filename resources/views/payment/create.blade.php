
    <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800  leading-tight">
                {{ __('payment') }}
            </h2>
        </x-slot>
    <!-- Your other HTML content -->

    {{-- <form id="payment-form">
        @csrf
        <div id="payment-element">
            <!-- The payment element will be injected here by Stripe.js -->
        </div>
        <button id="submit-payment">Submit Payment</button>
    </form> --}}

    <!-- Your other HTML content -->
    @livewire('payment-stripe',['order_id'=>$order_id])


</x-app-layout>
