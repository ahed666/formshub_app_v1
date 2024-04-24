<div class="flex justify-center xs:block mt-6">

    <aside class="w-1/2 xs:w-full">
        <article class="bg-white rounded-lg shadow-lg">
            <div class="p-5 ">




                <div class="grid grid-cols-12  border-2 rounded-lg   p-2 bg-gray-100 border-gray-200 min-h-[150px] mb-4">

                    <div class="col-span-8 xs:col-span-12 sm:col-span-12 md:col-span-12">
                        @if($action=="buyresponses")
                            <h1 class="mt-2 ">{{ __('main.buy_responses',['num'=>number_format($choosenCategory->num, 0, '.', ',')]) }}</h1>
                            <h1 class="mt-2">{{ __('main.valid',['start'=>\Carbon\Carbon::now()->format('Y-m-d'),'end'=>\Carbon\Carbon::parse($currentsubscribe->expired_at)->subDays(1)->format('Y-m-d')]) }}</h1>
                        @else
                           <h1 class="mt-2">{{ __('main.newplan',['num'=>number_format($choosenCategory->num, 0, '.', ',')]) }}</h1>
                            @if($choosenPlanInfo->id==$currentsubscribe->plan_id)
                            <h1 class="mt-2">{{ __('main.valid',['start'=>\Carbon\Carbon::parse($currentsubscribe->expired_at)->format('Y-m-d'),'end'=>\Carbon\Carbon::parse($currentsubscribe->expired_at)->format('Y-m-d')]) }}

                            @else
                            <h1 class="mt-2">{{ __('main.valid',['start'=>\Carbon\Carbon::now()->format('Y-m-d'),'end'=>\Carbon\Carbon::now()->addyear()->subDays(1)->format('Y-m-d')]) }}

                            @endif
                        @endif
                    </div>

                    <div class="col-span-4 xs:col-span-12 sm:col-span-12 md:col-span-12">
                        @php
                        $formattedPrice = number_format($totalprice, 2);
                        $formattedVat = number_format($totalprice*0.05, 2);
                        $formattedTotalPrice = number_format($totalprice+(($totalprice)*0.05), 2);
                        @endphp
                        <div class="grid grid-cols-12 items-center justify-center">
                            <span class="col-span-4">{{ __('main.price') }}</span>
                            <span class="col-span-4 text-secondary_blue  mx-1 text-right">{{  $formattedPrice }}</span>
                            <span class="col-span-1 text-xs">AED</span>
                        </div>
                        <div class="grid grid-cols-12 items-center justify-center">
                            <span class="col-span-4">{{ __('main.vat') }}</span>
                            <span class="col-span-4 text-secondary_blue  mx-1 text-right">{{  $formattedVat }}</span>
                            <span class="col-span-1 text-xs">AED</span>
                        </div>
                        <div class="grid grid-cols-12 items-center justify-center">
                            <span class="col-span-4 font-bold">{{ __('main.total') }}</span>
                            <span class="col-span-4 text-secondary_blue font-bold  mx-1 text-right">{{  $formattedTotalPrice }}</span>
                            <span class="col-span-1 text-xs">AED</span>
                        </div>

                    </div>
                </div>




                <div class="tab-content">
                    <div class="px-46 tab-pane fade show active" id="nav-tab-card">
                        @foreach (['danger', 'success'] as $status)
                            @if(Session::has($status))
                                <p class="alert alert-{{$status}}">{{ Session::get($status) }}</p>
                            @endif
                        @endforeach
                             {{-- onsubmit="return submitForm()" --}}
                        <form  role="form" method="get" id="payment-form" action="{{ route('payment.create')}}">
                            @csrf
                            <input type="hidden" name="subscription_id" id="subscription_id" value="{{ $choosenPlan }}">
                            <input type="hidden" name="price" id="price" value="{{ $totalprice }}">
                            <input type="hidden" name="action" id="action" value="{{ $action }}">
                            <input type="hidden" name="desc" id="desc" value="{{ $desc }}">

                            <input type="hidden" name="cateresponses" id="cateresponses" value="{{ $choosenCategory->id }}">

                            <div class="flex justify-between items-center border-t-[1px] p-2 mt-2 border-gray-200">
                                @if(!$renew)
                                <button wire:click="Back" class="justify-center  min-w-[100px] w-auto h-10 p-1  text-center
                                inline-flex items-center px-4 py-2 bg-primary_red text-white  border-gray-300
                                 rounded-md font-semibold text-xs   uppercase tracking-widest shadow-sm
                                   disabled:opacity-25 transition ease-in-out duration-150 ml-2
                                " type="button">{{ __('main.back') }} </button>
                                @endif


                                <button id="submitButton" class="justify-center min-w-[100px] w-auto h-10 p-1 text-center
                                inline-flex items-center px-4 py-2 bg-secondary
                                border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-secondary_1
                                active:bg-gray-900  disabled:opacity-25 transition
                                " type="submit"> {{ __('main.placeorder') }} </button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </article>
        <div class=" hidden  p-1 mt-4  justify-center items-center" id="TextAfterSubmit">
            <h1 class="text-center" >{{ __('main.pleasewait')}}</h1>
            <h1 class="text-center" >{{ __('main.pleasewait_message') }}</h1>
        </div>
    </aside>

</div>
