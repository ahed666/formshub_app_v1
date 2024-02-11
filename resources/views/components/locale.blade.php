<div   class="items-center	 flex flex-warp  justify-end ">

    <!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">
    <svg class="w-8 h-8" fill="#000000"  viewBox="0 0 24 24" id="translate" data-name="Flat Line" xmlns="http://www.w3.org/2000/svg" class="icon flat-line">
    <g id="SVGRepo_bgCarrier" stroke-width="0"/>
    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>
    <g id="SVGRepo_iconCarrier">
    <path id="secondary" d="M21,4V16a1,1,0,0,1-1,1H16l-4,4L8,17H4a1,1,0,0,1-1-1V4A1,1,0,0,1,4,3H20A1,1,0,0,1,21,4Z" style="fill: #7a7a7a; stroke-width: 2;"/>
    <path id="primary" d="M10,11a8.14,8.14,0,0,0,4,3" style="fill: none; stroke: #f5f5f5; stroke-linecap: round; stroke-linejoin: round; stroke-width: 2;"/>
    <path id="primary-2" data-name="primary" d="M10,14c4-1,4-6,4-6" style="fill: none; stroke: #f5f5f5; stroke-linecap: round; stroke-linejoin: round; stroke-width: 2;"/>
    <path id="primary-3" data-name="primary" d="M8,8h8M12,7V8m8-5H4A1,1,0,0,0,3,4V16a1,1,0,0,0,1,1H8l4,4,4-4h4a1,1,0,0,0,1-1V4A1,1,0,0,0,20,3Z" style="fill: none; stroke: #f5f5f5; stroke-linecap: round; stroke-linejoin: round; stroke-width: 2;"/>
    </g>
    </svg>

    @if (App::getLocale()=="ar")
        <a class=" mr-1  ml-1 text-lg text-black-600 hover:text-gray-900" href="{{ route('setLocale','en') }}">
            {{ __('EN') }}
        </a>

    @elseif (App::getLocale()=="en")
        <a class=" mr-1  ml-1 text-lg text-black-600 hover:text-gray-900" href="{{ route('setLocale','ar') }}">
            {{ __('AR') }}
        </a>

  @endif

</div>
