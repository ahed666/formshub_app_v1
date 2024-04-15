<div class="p-4  w-full h-[160px] max-h-[160px] min-h-[160px]  grid justify-center " >
<div  class="flex justify-between items-center  text-sm mb-1 w-full h-[10px] max-h-[10px] min-h-[10px] ">
     <div>
        <span class="text-sm text-secondary_red font-bold">{{ __('main.question') }}</span>
        <span class="text-sm">{{ __('main.hintAddQuestion') }} </span>
     </div>
    <span><span id="question_counter">{{ Str::length($text) }}</span>{{ __('/255') }}</span>
</div>
<div class="border-[1px] w-full  overflow-y-none  p-[1px] rounded-lg border-gray-200" >
<textarea  maxlength="255" value="{{ $text }}"  rows="3" cols="90" class="text-2xl xs:text-sm resize-none text-center shadow-none	focus:shadow-none	 border-none outline-none  w-full focus:outline-none focus:border-none
" required autofocus min="10" minlength="10" wire:model.defer="question_text" name="" id="questionText" ></textarea>
</div>
</div>
<script>

    var QuestionText = document.getElementById('questionText');
    var CounterText = document.getElementById('question_counter');

    // Function to update character count
    function updateCounter(element,counter) {
        const maxLength = element.getAttribute('maxlength');
        const currentLength = element.value.length;
        counter.innerText = `${currentLength}`;
    }



    // Add event listener for input
    QuestionText.addEventListener('input', function(e) {
        updateCounter(QuestionText,CounterText);
    });
    var questionText = document.getElementById("questionText");

    questionText.addEventListener("keydown", function(event) {
    if (event.key === "Enter") {
        event.preventDefault(); // Prevent the Enter key's default action
    }
});
</script>
