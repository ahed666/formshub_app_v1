<div  class="modal fade fixed top-0 left-0 z-[1055]  h-full w-full  " id="publishform" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered  min-h-[calc(100%-1rem)] w-full max-w-[500px] translate-y-[-50px] items-center  transition-all duration-10 ease-out-in min-[576px]:mx-auto min-[576px]:mt-7 min-[576px]:min-h-[calc(100%-3.5rem)]" role="document">
                    <div class="modal-content  w-full flex-col rounded-md border-none  bg-clip-padding text-current shadow-lg
                    outline-none ">
                        {{-- header --}}
                        <div class="flex items-start justify-between p-4 border-b rounded-t ">
                            <h3 class="text-xl font-semibold text-gray-900 ">
                            {{ __(' Publish your Form ') }}
                            </h3>
                            <button  type="button"  class="close text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex
                                items-center "  data-dismiss="modal" aria-label="Close">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0
                                011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                            </button>
                        </div>
                        {{-- body --}}
                        <div class="p-4">
                           <div class="flex justify-center space-x-6 items-center">
                                <input readonly class="w-[80%] border-[1px] border-black rounded-[0.5rem]" id="box_link" type="text">
                                <button id="copyLinkButton" class="p-1 w-[20%] rounded-[0.5rem] bg-secondary_blue hover:bg-secondary_1 text-white">{{ __('Copy link') }}</button>
                           </div>
                           <div class="mt-2 flex justify-center items-center">
                                <span class="text-sm">
                                  {{ __('Use this link to get responses by sharing it with your audience, for example, by email, SMS, or any other ways. You can also add this link to your website, or web page as (href). ') }}
                                  <a href="" class=" text-secondary_blue ">{{ __('learn more') }}</a>
                                </span>
                           </div>
                           {{-- or div --}}
                           <div class="flex justify-center items-center my-8">
                               <div class="flex-1 border-t"></div>
                               <div class="px-3"><span class="text-lg">{{ __('Or') }}</span></div>
                               <div class="flex-1 border-t"></div>
                           </div>
                           {{-- link form --}}
                           <div class="flex justify-center space-x-6 items-center">
                                <span class="text-sm w-[70%] text-left">{{ __('Link this form to a form point kiosk.') }}</span>
                                <a href="{{ route('kiosks') }}" class="text-center hover:no-underline p-1 w-[30%] rounded-[0.5rem] bg-secondary_blue hover:bg-secondary_1 text-white">{{ __('Go to my kiosk ') }}</a>
                           </div>

                        </div>

                    </div>
                    </div>
                </div>
<script>
 // copy link function
 document.addEventListener("DOMContentLoaded", function () {
        var copyButton = document.getElementById("copyLinkButton");
        var inputElement = document.getElementById("box_link");

        copyButton.addEventListener("click", function () {
            // Select the text in the input field
            inputElement.select();

            // Copy the selected text to the clipboard
            document.execCommand("copy");

            // Deselect the input field
            window.getSelection().removeAllRanges();

            // Change the button text temporarily
            copyButton.textContent = "Copied!";
            setTimeout(function () {
            copyButton.textContent = "Copy Link";
            }, 2000); // Change back after 2 seconds
        });
    });
</script>
