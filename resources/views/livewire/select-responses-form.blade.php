<div>

    <div class=" grid justify-center items-center mt-6 ">
        <div class="grid justify-center items-center mb-10">
            <h1 class="font-bold text-lg text-center my-4">{{ __('main.getadditionalresponses') }}</h1>
            @if($validAddResponses)
            <h1 class="text-sm">{{ __('main.responsesvalid') }} <span class="text-secondary">{{ \Carbon\Carbon::parse($current_subscribe->expired_at)->subDays(1)->format('Y-m-d') }}</span></h1>
            @endif
        </div>
    <x-buy-responses :action="$action" :choosenCategory="$choosenCategory" :validAddResponses="$validAddResponses" :maxnumresponses="$maxnumresponses"  :responsesCategories="$responsesCategories" :currentsubscribe="$current_subscribe" />
    </div>

</div>
