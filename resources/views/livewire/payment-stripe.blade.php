
@push('styles')
<script src="{{ asset('https://js.stripe.com/v3/') }}"></script>

@endpush
<div>
    <div class="flex justify-center xs:block mt-6">

    <aside class="w-1/2 xs:w-full">
        <article class="bg-white rounded-lg shadow-lg">
            <div class="p-5 ">

            <div class="grid grid-cols-12 gap-2  border-2 rounded-lg   p-2 bg-gray-100 border-gray-200 min-h-[150px] mb-12">

                <div class="col-span-8 xs:col-span-12 sm:col-span-12 md:col-span-12">
                    <div class="grid space-y-6">
                        <div>
                            {!! $desc!!}
                        </div>


                            @if($validCode)
                            <div class="flex justify-start items-center">
                                <span class="text-valid ">{{ __('main.codeappliedsuccessmessage',['ratio'=>$validCode->discount_value]) }}</span>

                            </div>
                            @else
                            <div class="w-[80%] xs:w-[80%] grid  items-center  ">
                                <div class="flex justify-start items-center">
                                    <x-input-label for="promocode" :value="__('main.promocode')" />

                                </div>
                                <div class="flex  items-center space-x-2">

                                    <x-text-input wire:model="codeText"  minlength="10"   maxlength="10"  id="promocode" name="promocode"   type="text" class="mt-1 block w-32 opacity-50 px-2 py-1"  required  />

                                    <button wire:loading.attr="disabled" wire:click="applyCode" id="button" class="justify-center min-w-[80px] w-auto h-8 p-1 text-center
                                     inline-flex items-center px-2 py-1 bg-secondary
                                     border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-secondary_1
                                     active:bg-gray-900  disabled:opacity-25 transition
                                     " type="submit">
                                         <span>{{ __('main.apply') }}</span>


                                     </button>

                                </div>
                                @if ($errorMessage) <span class="flex font-medium text-sm  mt-1 text-red-600 text-danger  error placeholder-gray-300">{{ $errorMessage }}</span> @endif



                            </div>

                            @endif



                    </div>

                </div>

                <div class="grid grid-rows-3 gap-2 col-span-4 xs:col-span-12 sm:col-span-12 md:col-span-12">
                    @php
                    $formattedPrice = number_format($price, 2);
                    $formattedDiscountValue=number_format($price*($discountRatio/100), 2);
                    $formattedSubTotal=number_format($formattedPrice-$formattedDiscountValue, 2);
                    $formattedVat = number_format($formattedSubTotal*0.05, 2);
                    $formattedTotalPrice = number_format($formattedSubTotal+(($formattedSubTotal)*0.05), 2);
                    @endphp
                    <div class="row-span-1 items-center">
                        <div class="grid grid-cols-12 items-center justify-center pl-1">
                            <span class="col-span-4">{{ __('main.price') }}</span>
                            <span class="col-span-6 text-secondary_blue  mx-1 text-right">{{  $formattedPrice }}</span>
                            <span class="col-span-2 text-xs">AED</span>
                        </div>
                        <div class="grid grid-cols-12 items-center justify-center pl-1">
                            <span class="col-span-4">{{ __('main.discount') }}</span>
                            <span class="col-span-6 text-secondary_blue  mx-1 text-right">{{  $formattedDiscountValue }}</span>
                            <span class="col-span-2 text-xs">AED</span>
                        </div>
                    </div>

                    <div class="row-span-1 grid items-center">

                    <div class="grid grid-cols-12 items-center justify-center pl-1">
                        <span class="col-span-4">{{ __('main.total') }}</span>
                        <span class="col-span-6 text-secondary_blue  mx-1 text-right">{{  $formattedSubTotal }}</span>
                        <span class="col-span-2 text-xs">AED</span>
                    </div>
                    <div class="grid grid-cols-12 items-center justify-center pl-1">
                        <span class="col-span-4">{{ __('main.tax') }}</span>
                        <span class="col-span-6 text-secondary_blue  mx-1 text-right">{{  $formattedVat }}</span>
                        <span class="col-span-2 text-xs">AED</span>
                    </div>

                    </div>
                    <div class="row-span-1 grid items-center  bg-white">
                    <div class="grid grid-cols-12 items-center justify-center pl-1">
                        <span class="col-span-4 font-bold">{{ __('main.dueamount') }}</span>
                        <span class="col-span-6 text-secondary_blue font-bold  mx-1 text-right">{{  $formattedTotalPrice }}</span>
                        <span class="col-span-2 text-xs">AED</span>
                    </div>
                    </div>

                </div>
            </div>
            <div wire:ignore target="codeText" class="px-14 xs:px-2">
                <div id="loading" class="flex justify-center items-center">
                    <h1 >
                        {{ __('main.loading') }}
                     </h1>
                </div>
                <div class="flex justify-center items-center text-primary_red" id="payment-message" style="display: none;">
                </div>
                <form action="" method="post" id="payment-form">
                <div   id="payment-element">

                </div>
                <div class="flex justify-between items-center border-t-[1px] p-2 mt-2 border-gray-200">

                    <a href="{{ route('subscriptions') }}" class="justify-center  min-w-[100px] w-auto h-10 p-1  text-center
                    inline-flex items-center px-4 py-2 bg-primary_red text-white  border-gray-300
                     rounded-md font-semibold text-xs   uppercase tracking-widest shadow-sm
                       disabled:opacity-25 transition ease-in-out duration-150 ml-2
                    " type="button">{{ __('main.back') }} </a>



                    <button id="submit" class="justify-center min-w-[100px] w-auto h-10 p-1 text-center
                    inline-flex items-center px-4 py-2 bg-secondary
                    border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-secondary_1
                    active:bg-gray-900  disabled:opacity-25 transition
                    " type="submit">
                        <span id="button-text">{{ __('main.paynow') }}</span>
                        <span id="spinner" style="display: none; ">{{ __('main.processing') }}</span>
                     </button>

                </div>


                </form>
            </div>
            </div>
        </article>
        <div class=" hidden  p-1 mt-4  justify-center items-center text-primary_red" id="TextAfterSubmit">
            <h1 class="text-center" >{{ __('main.pleasewait')}}</h1>
            <h1 class="text-center" >{{ __('main.pleasewait_message') }}</h1>
        </div>
    </aside>

</div>
</div>
@push('scripts')
<script src="{{ asset('js/sweetalert.min.js') }}"></script>

<script>
       var translations = @json(__('main'));

// This is your test publishable API key.
const stripe = Stripe("{{config('services.stripe.publishable_key')}}");

// The items the customer wants to buy


let elements;

initialize();
checkStatus();

document
  .querySelector("#payment-form")
  .addEventListener("submit", handleSubmit);

  document.addEventListener('promocode-applied', event =>  {
    initialize();
  });
// Fetches a payment intent and captures the client secret
async function initialize() {
    setLoadingForm(true);
    try {
    const response = await fetch("{{route('payment.paymentIntent.create', $order_id)}}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}" // Use X-CSRF-TOKEN header for CSRF protection
        },
        body: JSON.stringify({ /* your request body here */ }),
    });

    if (!response.ok) {
        const errorMessage = await response.text();
        throw new Error(`HTTP error! Status: ${response.status}, Message: ${errorMessage}`);
    }

    const { clientSecret } = await response.json();

  elements = stripe.elements({ clientSecret });

  const paymentElementOptions = {
    layout: "tabs",
  };

  const paymentElement = elements.create("payment", paymentElementOptions);
  paymentElement.mount("#payment-element");
      // Use clientSecret as needed
} catch (error) {
    console.error('Fetch error:', error);
    // Handle the error (e.g., display an error message to the user)
}
  setLoadingForm(false);
}

async function handleSubmit(e) {
  e.preventDefault();
  setLoading(true);

  const { error } = await stripe.confirmPayment({

    elements,
    confirmParams: {
      // Make sure to change this to your payment completion page
      return_url: "{{route('stripe.return',$order_id)}}",
    },
  });

  // This point will only be reached if there is an immediate error when
  // confirming the payment. Otherwise, your customer will be redirected to
  // your `return_url`. For some payment methods like iDEAL, your customer will
  // be redirected to an intermediate site first to authorize the payment, then
  // redirected to the `return_url`.
  if (error.type === "card_error" || error.type === "validation_error") {
    showMessage(error);
  } else {
    showMessage("An unexpected error occurred.");
  }

  setLoading(false);
}

// Fetches the payment intent status after payment submission
async function checkStatus() {
  const clientSecret = new URLSearchParams(window.location.search).get(
    "payment_intent_client_secret"
  );

  if (!clientSecret) {
    return;
  }

  const { paymentIntent } = await stripe.retrievePaymentIntent(clientSecret);

  switch (paymentIntent.status) {
    case "succeeded":
      showMessage("Payment succeeded!");
      break;
    case "processing":
      showMessage("Your payment is processing.");
      break;
    case "requires_payment_method":
      showMessage("Your payment was not successful, please try again.");
      break;
    default:
      showMessage("Something went wrong.");
      break;
  }
}

// ------- UI helpers -------

function showMessage(messageText) {
//     console.log(messageText);
//   const messageContainer = document.querySelector("#payment-message");

//   messageContainer.style.display="flex";
//   messageContainer.textContent = messageText;
//   console.log(messageContainer);
//   setTimeout(function () {
//     messageContainer.style.display="none";
//     messageContainer.textContent = "";

//   }, 10000);
console.log(messageText.code,messageText.decline_code);
Swal.fire({
            icon: 'error',
            title:messageText.message,
            confirmButtonColor:'#f3f4f6',
            confirmButtonText:`<h5 style='color:000000;border:0;box-shadow: none;'>${translations.ok}</h5>`,
            text:' ',

    })
}

// Show a spinner on payment submission
function setLoading(isLoading) {
  if (isLoading) {
    // Disable the button and show a spinner TextAfterSubmit
    document.querySelector("#submit").disabled = true;
    document.querySelector("#spinner").style.display="inline";
    document.querySelector("#TextAfterSubmit").classList.remove('hidden');
    document.querySelector("#button-text").style.display="none";
  } else {
    document.querySelector("#submit").disabled = false;
    document.querySelector("#spinner").style.display="none";
    document.querySelector("#TextAfterSubmit").classList.add('hidden');

    document.querySelector("#button-text").style.display="inline";
  }
}
// proccessing get form
function setLoadingForm(isLoading) {
  if (isLoading) {
    // Disable the button and show a spinner TextAfterSubmit
    document.querySelector("#submit").disabled = true;
    document.querySelector("#loading").style.display="flex";

  } else {
    document.querySelector("#submit").disabled = false;
    document.querySelector("#loading").style.display="none";
  }
}

</script>
@endpush
