<div class="w-full flex  items-center my-1">
   <div class="mx-1">
     {!! $svg !!}
   </div>
   <div class="mx-1 text-sm xs:text-xs whitespace-nowrap">
     <span>{{ $tag }}</span>
   </div>
   <div class="mx-1 text-sm xs:text-xs {{ $class }}">

    @if($type=="bar")
    <x-progress-bar :value="round($info, 1)" class="{{ $bgcolor }}" />
    @else
    <span class="whitespace-nowrap overflow-hidden" data-bs-toggle="tooltip"  data-bs-html="true" title="{{ $info }}">{{  $info  }}</span>
    @endif
   </div>
</div>
