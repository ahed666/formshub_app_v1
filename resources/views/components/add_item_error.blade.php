<div class="flex justify-center items-center p-10">
    <span>
        {{ $error }}
        @if($subscribe->type=="Free")
                <a   href="{{ route('subscribe','upgrade') }}" target="_blank" class="text-secondary_blue">
                {{ __('here') }}
                </a>

        @endif
    </span>
</div>
