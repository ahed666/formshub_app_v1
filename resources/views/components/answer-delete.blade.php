<div class="flex justify-center items-center w-[10%]">
<a
@if($deleteAction=='edit')
onclick="showConfirmDelete({{ $i }})"
@elseif ($deleteAction=='add')
wire:click="deleteAnswer({{ $i }})"
@endif

class="">
    <svg class="h-4 w-4 text-svg_primary hover:text-primary_red focus:text-primary_red hover:cursor-pointer "  viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
    <g  stroke-width="0"/>
    <g  stroke-linecap="round" stroke-linejoin="round"/>
    <g > <path d="M10 11V17" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/> <path d="M14 11V17" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/> <path d="M4 7H20" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/> <path d="M6 7H12H18V18C18 19.6569 16.6569 21 15 21H9C7.34315 21 6 19.6569 6 18V7Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/> <path d="M9 5C9 3.89543 9.89543 3 11 3H13C14.1046 3 15 3.89543 15 5V7H9V5Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/> </g>
    </svg>
</a>
</div>
