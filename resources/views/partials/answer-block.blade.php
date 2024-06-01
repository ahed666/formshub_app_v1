<div id="list{{ $index }}" class="p-1 col-span-3 border-[1px] border-gray-300 rounded-lg">
    <div class="flex justify-between items-center">
        <div><span class="whitespace-nowrap text-sm font-bold">{{ $Chars[$index] }}</span></div>
        <x-answer-delete :i="$index" :deleteAction="'deleteanswer'" />
    </div>
    <div class="mt-2 flex justify-center">
        <div class="border-[1px] border-gray-300 p-[2px] rounded-lg w-[100px] h-[100px]">
            <img id="image-{{ $index }}" name="image-{{ $index }}" class="w-full h-full object-contain block ml-auto mr-auto" src="{{ asset($question_image) }}" alt="">
            <label class="items-center w-4 relative flex bottom-[10px] right-[8px] bg-green-300 border-[1px] rounded-2xl" for="answers[{{ $index }}][image]">
                <svg onclick="updatecurrentimageindex({{ $index }})" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"></path>
                </svg>
                <input onchange="uploadimage(event, {{ $index }})" class="image opacity-0 absolute -z-10" type="file" name="answers[{{ $index }}][image]" id="answers[{{ $index }}][image]" accept="image/*">
            </label>
        </div>
    </div>
    <div class="mt-2 flex justify-center w-full">
        <div class="w-full">
            <textarea maxlength="80" rows="3" class="resize-none focus:shadow-none focus:border-b-2 focus:border-t-0 focus:border-l-0 focus:border-r-0 shadow-none border-t-0 border-r-0 border-l-0 border-b-2 outline-none w-full" name="answers[{{ $index }}][value]" id="answers[{{ $index }}][value]" required></textarea>
        </div>
    </div>
</div>
