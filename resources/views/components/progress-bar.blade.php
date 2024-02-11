<div class=" flex justify-center items-center">
    <span class="text-sm xs:text-xs truncate text-left xs:hidden ">

        <div class=" bg-neutral-200  rounded-[0.5rem] w-[100px]">

            <div {{ $attributes->merge(['class' => ' p-1 text-center text-xs font-medium leading-none text-primary-100 rounded-[0.5rem]']) }}
            style="width: {{ $value }}px">

            </div>

        </div>
    </span>
    <span class="text-xs xs:text-center" >  {{ $value }}%</span>
</div>
