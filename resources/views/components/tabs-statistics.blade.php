
<ul class=" flex list-none flex-row flex-wrap  bg-transparent h-8" id="tabs-tablist">
    <li role="presentation">
        <a href="{{ route('statisticform', $id ) }}" class=" block  px-7  text-md xs:text-xs
        text-neutral-500 hover:isolate   focus:isolate hover:no-underline {{ $type=="overview" ? 'active rounded-t-[0.5rem]   font-bold  flex justify-center items-center   my-0  text-secondary_blue' : 'border-0 border-transparent' }}">{{ __('main.overview') }}</a>
    </li>
    <li role="presentation">
        <a href="{{ route('questions-statistics', $id ) }}" class=" block  px-7   text-md xs:text-xs
        text-neutral-500 hover:isolate   focus:isolate hover:no-underline {{ $type=="questions-statistics" ? 'active rounded-t-[0.5rem]   font-bold   flex justify-center items-center   my-0 text-secondary_blue' : 'border-0 border-transparent' }}">{{ __('main.questions_Statistics') }}</a>
    </li>
    <li role="presentation">
        <a href="{{ route('all-responses', $id ) }}" class=" block  px-7   text-md xs:text-xs
        text-neutral-500 hover:isolate   focus:isolate hover:no-underline {{$type=="all-responses"  ? 'active  rounded-t-[0.5rem]  font-bold  flex justify-center items-center   my-0  text-secondary_blue' : 'border-0 border-transparent' }}">{{ __('main.allresponses') }}</a>
    </li>
</ul>

