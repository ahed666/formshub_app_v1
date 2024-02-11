<div class="fixed inset-0 flex items-center justify-center z-50  " >
    <div class="bg-black opacity-50 absolute inset-0"></div>
        <div class=" p-8 rounded shadow-lg z-10 flex items-center justify-center h-screen w-screen">
        <div class="w-auto max-w-lg h-auto p-14 bg-white text-center rounded-[0.5rem]">
            <h1 class="">{{ __('main.lockedaccount_title') }}
                <a   href="{{ route('subscribe','upgrade') }}" target="_blank" class=" text-secondary_blue rounded-xl    hover:cursor-pointer  p-2">
                    {{ __('main.here') }}
                </a>
            </h1>
            <div class="flex justify-center items-center">

                <svg class="w-14 h-14" fill="#545454" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="800px" height="800px" viewBox="0 0 100 100" enable-background="new 0 0 100 100" xml:space="preserve" stroke="#545454">
                <g id="SVGRepo_bgCarrier" stroke-width="0"/>
                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>
                <g id="SVGRepo_iconCarrier"> <g> <path d="M33,85h34c5.514,0,10-4.605,10-10.119v-22c0-5.514-4.486-10-10-10v-8.167C67,25.432,59.545,18,50.382,18h-0.334 C40.647,18,33,25.432,33,34.714v8.167c-5.514,0-10,4.486-10,10v22C23,80.395,27.486,85,33,85z M37,34.714 C37,27.638,42.854,22,50.048,22h0.334C57.457,22,63,27.518,63,34.714V43H37V34.714z M73,75c0,3.313-2.687,6-6,6H33 c-3.313,0-6-2.687-6-6V53c0-3.313,2.687-6,6-6h34c3.313,0,6,2.687,6,6V75z"/> <path d="M47,66.785v4.221C47,72.594,48.287,74,49.875,74h0.25C51.713,74,53,72.594,53,71.006v-4.359 c1.798-1.068,3.007-3.023,3.007-5.266c0-3.383-2.742-6.125-6.125-6.125s-6.125,2.742-6.125,6.125 C43.757,63.722,45.07,65.754,47,66.785z"/> </g> </g>
                </svg>
            </div>
            <h1 class="text-red-500 text-sm">{{ __('main.lockedaccount_text') }} <a href="" class=" text-secondary_blue hover:text-secondary_1 underline">{{ __('main.readmore') }}</a></h1>
        </div>
    </div>
</div>
