@push('styles')
<link
  rel="stylesheet"
  href="{{ asset('/styles/index.min.css') }}" />
  <link  rel="stylesheet" href="{{ asset('styles/bootstrap.min.css')}}">
   {{-- <link rel="stylesheet" href="{{ asset('styles/sortable.min.css') }}"> --}}


@endpush

<div wire:loading.class="disabled opacity-50" class="">
    <input type="hidden" id="flashedMessage" value="{{ session('success_message_signed') }}">
    @if ($accountStatus['status']=='Locked')

    <x-lockedaccount/>

    @elseif($current_subscribe->signpdf==false)

    <x-lockedaccount/>
    @endif
    <div wire:loading.class="opacity-50" wire:Target="refreshdata"  class="{{ $accountStatus['status']=='Locked'?"pointer-events-none opacity-50":"" }} grid grid-rows-12   mt-2 ">

        <div class=" w-full  mb-2 flex justify-between items-center p-2 pl-4 bg-white drop-shadow     rounded-[0.5rem] ">

            <div class="grid justify-start items-center  w-1/4 p-2  " >
                <a href="{{ route('signpdf.add') }}"  type="button" class="bg-secondary_blue rounded  hover:no-underline p-2 xs:p-1  h-16 xs:h-10 xs:w-[80px] w-[120px] hover:cursor-pointer ease-in delay-100  hover:-translate-z-1 hover:scale-[1.1]  duration-200 xs:my-2    xs:justify-center xs:items-center ">
                    <div  class="flex justify-center items-center">


                        <!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">
                        <svg  class="w-6 h-6 xs:h-3 xs:w-3" fill="#ffffff"   viewBox="0 -64 640 640" xmlns="http://www.w3.org/2000/svg" stroke="#ffffff">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"/>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>
                        <g id="SVGRepo_iconCarrier">
                        <path d="M623.2 192c-51.8 3.5-125.7 54.7-163.1 71.5-29.1 13.1-54.2 24.4-76.1 24.4-22.6 0-26-16.2-21.3-51.9 1.1-8 11.7-79.2-42.7-76.1-25.1 1.5-64.3 24.8-169.5 126L192 182.2c30.4-75.9-53.2-151.5-129.7-102.8L7.4 116.3C0 121-2.2 130.9 2.5 138.4l17.2 27c4.7 7.5 14.6 9.7 22.1 4.9l58-38.9c18.4-11.7 40.7 7.2 32.7 27.1L34.3 404.1C27.5 421 37 448 64 448c8.3 0 16.5-3.2 22.6-9.4 42.2-42.2 154.7-150.7 211.2-195.8-2.2 28.5-2.1 58.9 20.6 83.8 15.3 16.8 37.3 25.3 65.5 25.3 35.6 0 68-14.6 102.3-30 33-14.8 99-62.6 138.4-65.8 8.5-.7 15.2-7.3 15.2-15.8v-32.1c.2-9.1-7.5-16.8-16.6-16.2z"/>
                        </g>
                        </svg>
                    </div>
                   <div class="flex justify-center">
                    <span class="mt-1 text-white text-sm xs:text-xs">{{ __('main.newsignature') }}</span>
                   </div>
                </a>
            </div>
            {{-- <div class="flex  items-center xs:grid gap-1">

                <div class="bg-primary_blue ml-2 mr-2 p-2  h-[75px] w-42 border-[1px] border-gray-300 rounded-[0.5rem] xs:p-1 xs-ml-1 xs:mr-1">
                    <div class=" text-sm xs:text-xs flex justify-start  items-center text-left "><span class=" mr-[2px]  ">{{ __('TotalSignatures : ') }}</span><span class="text-secondary_blue">{{ $totalSignatures }}</span></div>


                </div>

               <div class=" rounded-lg ml-8 w-1/8   mr-2 p-2 xs:p-1 xs-ml-1 xs:mr-1">
                    <div class="flex justify-center items-center"><svg wire:click="refresh"
                        class="hover:cursor-pointer w-6 h-6 hover:text-blue-600 hover:z-[9999] hover:shadow-inner"
                        xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 40 40" >
                        <path fill="#8bb7f0" d="M4.207,35.5l2.573-2.574l-0.328-0.353C3.259,29.143,1.5,24.677,1.5,20C1.5,9.799,9.799,1.5,20,1.5 c0.776,0,1.598,0.062,2.5,0.19v4.032C21.661,5.575,20.823,5.5,20,5.5C12.005,5.5,5.5,12.005,5.5,20 c0,3.578,1.337,7.023,3.765,9.701l0.353,0.389l2.883-2.883V35.5H4.207z"/><path fill="#4e7ab5" d="M20,2c0.627,0,1.287,0.042,2,0.129v3.009C21.33,5.046,20.661,5,20,5C11.729,5,5,11.729,5,20 c0,3.702,1.383,7.267,3.894,10.037l0.705,0.778l0.743-0.743L12,28.414V35H5.414l1.379-1.379l0.682-0.682l-0.657-0.706 C3.711,28.895,2,24.551,2,20C2,10.075,10.075,2,20,2 M20,1C9.507,1,1,9.507,1,20c0,4.994,1.934,9.527,5.086,12.914L3,36h10V26 l-3.365,3.365C7.387,26.885,6,23.612,6,20c0-7.732,6.268-14,14-14c1.031,0,2.033,0.119,3,0.33V1.259C22.02,1.104,21.023,1,20,1 L20,1z"/><g><path fill="#8bb7f0" d="M20,38.5c-0.776,0-1.598-0.062-2.5-0.19v-4.032c0.839,0.147,1.677,0.222,2.5,0.222 c7.995,0,14.5-6.505,14.5-14.5c0-3.583-1.336-7.03-3.761-9.706l-0.353-0.389L27.5,12.793V4.5h8.293l-2.581,2.582l0.328,0.354 C36.738,10.872,38.5,15.334,38.5,20C38.5,30.201,30.201,38.5,20,38.5z"/><path fill="#4e7ab5" d="M34.586,5l-1.387,1.387l-0.682,0.682l0.657,0.706C36.286,11.119,38,15.461,38,20 c0,9.925-8.075,18-18,18c-0.627,0-1.287-0.042-2-0.129v-3.009C18.67,34.954,19.339,35,20,35c8.271,0,15-6.729,15-15 c0-3.708-1.381-7.274-3.89-10.041l-0.705-0.778l-0.743,0.743L28,11.586V5H34.586 M37,4H27v10l3.369-3.369 C32.618,13.111,34,16.388,34,20c0,7.732-6.268,14-14,14c-1.031,0-2.033-0.119-3-0.33v5.071C17.98,38.896,18.977,39,20,39 c10.493,0,19-8.507,19-19c0-4.993-1.942-9.519-5.094-12.906L37,4L37,4z"/></g>
                        </svg></div>
                        <h1 class="text-center   text-md xs:text-xs">Refresh</h1>
                </div>
            </div> --}}

        </div>

        {{-- form info --}}
        <div class="w-full grow  max-h-[1000px]     ">

            @if($signature!=null)
            <div id="FullAllSignatures" class="grid ">
                {{-- table responses section --}}
                  <div id="responsestable" class="max-h-[900px]   rounded-[0.5rem]  ">

                   <div class="grid grid-cols-12 max-h-[900px] h-[900px] ">
                    <!--<div class="col-span-12 h-full overflow-auto overflow-y-auto scrollbar scrollbar-thumb-secondary_blue scrollbar-track-gray-200">-->
                    <!--    <iframe src="{{ asset($signature->path_file) }}" height="100%" width="100%"  ></iframe>-->

                    <!--</div>-->
                          {{-- pdf view  --}}
                    <div wire:ignore target="signPdf"  class="col-span-12   px-2 pb-2 border-[1px] border-gray-400  rounded-[0.5rem] bg-white
                     min-h-[95vh] max-h-full    drop-shadow"  >

                        <div class="flex justify-center  items-center space-x-32 my-2 ">

                               <div class="flex justify-center  items-center space-x-12 my-2 ">
                                    <!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">
                                    <svg id="prev" class="w-6 h-6 text-secondary_blue hover:cursor-pointer" fill="currentColor"  viewBox="0 0 24 24" id="previous" data-name="Flat Color" xmlns="http://www.w3.org/2000/svg" class="icon flat-color" transform="rotate(0)">
                                    <g id="SVGRepo_bgCarrier" stroke-width="0"/>
                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>
                                    <g id="SVGRepo_iconCarrier">
                                    <path id="primary" d="M17.45,2.11a1,1,0,0,0-1.05.09l-12,9a1,1,0,0,0,0,1.6l12,9a1,1,0,0,0,1.05.09A1,1,0,0,0,18,21V3A1,1,0,0,0,17.45,2.11Z" style="fill: currentColor;"/>
                                    </g>
                                    </svg>

                                    <h1 >Page: <span id="page_num"></span> / <span id="page_count"></span></h1>

                                    <!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">
                                    <svg fill="currentColor" id="next" class="w-6 h-6 text-secondary_blue hover:cursor-pointer" viewBox="0 0 24 24" id="previous" data-name="Flat Color" xmlns="http://www.w3.org/2000/svg" class="icon flat-color" transform="rotate(180)">
                                    <g id="SVGRepo_bgCarrier" stroke-width="0"/>
                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>
                                    <g id="SVGRepo_iconCarrier">
                                    <path id="primary" d="M17.45,2.11a1,1,0,0,0-1.05.09l-12,9a1,1,0,0,0,0,1.6l12,9a1,1,0,0,0,1.05.09A1,1,0,0,0,18,21V3A1,1,0,0,0,17.45,2.11Z" style="fill: currentColor;"/>
                                    </g>
                                    </svg>
                                </div>
                                <div class="grid justify-center items-center">
                                    <a class="flex justify-center items-center" wire:click="download">
                                        <svg class="w-6 h-6 text-secondary_blue hover:cursor-pointer outline-none" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                          <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
                                        </svg>
                                    </a>
                                    <span class="text-xs">{{ __('main.download') }}</span>
                                </div>





                        </div>
                        <div class="relative flex justify-center items-center  min-h-[90vh] max-h-full overflow-auto ">
                            <canvas class="absolute top-0 left-1/3 xs:left-0 border border-gray-200" width="595" height="842"  id="canvasPdf"></canvas>
                        </div>

                    </div>



                   </div>
                  </div>
            </div>
            @else
                <div id="WaitingSection" class="h-[600px] flex  justify-center items-center">
                    <div class="grid items-center justify-center">
                        <div class="flex justify-center items-center">
                            <svg fill="#545454" class="w-14 h-14" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 297 297" xml:space="preserve" stroke="#545454">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"/>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>
                            <g id="SVGRepo_iconCarrier"> <path d="M251.01,277.015h-17.683l-0.002-31.559c0-31.639-17.358-60.726-48.876-81.901c-3.988-2.682-6.466-8.45-6.466-15.055 s2.478-12.373,6.464-15.053c31.52-21.178,48.878-50.264,48.88-81.904V19.985h17.683c5.518,0,9.992-4.475,9.992-9.993 c0-5.518-4.475-9.992-9.992-9.992H45.99c-5.518,0-9.992,4.475-9.992,9.992c0,5.519,4.475,9.993,9.992,9.993h17.683v31.558 c0,31.642,17.357,60.729,48.875,81.903c3.989,2.681,6.467,8.448,6.467,15.054c0,6.605-2.478,12.373-6.466,15.053 c-31.519,21.176-48.876,50.263-48.876,81.903v31.559H45.99c-5.518,0-9.992,4.475-9.992,9.993c0,5.519,4.475,9.992,9.992,9.992 h205.02c5.518,0,9.992-4.474,9.992-9.992C261.002,281.489,256.527,277.015,251.01,277.015z M138.508,110.362 c0-5.518,4.474-9.993,9.992-9.993s9.992,4.475,9.992,9.993v17.664c0,5.519-4.474,9.992-9.992,9.992s-9.992-4.474-9.992-9.992 V110.362z M141.433,173.956c1.858-1.857,4.436-2.927,7.064-2.927c2.628,0,5.206,1.069,7.064,2.927 c1.868,1.859,2.928,4.438,2.928,7.065s-1.06,5.206-2.928,7.064c-1.858,1.858-4.436,2.928-7.064,2.928 c-2.628,0-5.206-1.069-7.064-2.928c-1.859-1.858-2.928-4.437-2.928-7.064S139.573,175.816,141.433,173.956z M86.94,277.112 c8.152-30.906,50.161-64.536,55.405-68.635c3.614-2.826,8.692-2.828,12.309,0c5.244,4.1,47.252,37.729,55.404,68.635H86.94z"/> </g>
                            </svg>
                        </div>
                        <h1 class="text-sm">{{__('main.waitnewsigned')}}
                            <a wire:click="refreshsignature"  class=" hover:cursor-pointer text-secondary_blue hover:no-underline font-bold text-uppercase">{{__('main.recheck')}}</a>
                        </h1>
                    </div>

                </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script src="{{ asset('https://cdn.jsdelivr.net/npm/jquery.fancytable/dist/fancyTable.min.js') }}"></script>
<script src="{{ asset('https://cdn.jsdelivr.net/npm/sweetalert2@11')}}"></script>
<script src="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.6.347/pdf.min.js') }}"></script>
<script src="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.6.347/pdf.worker.min.js') }}"></script>

    <script>
  pdfjsLib.GlobalWorkerOptions.workerSrc = "https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.6.347/pdf.worker.min.js";
    var ctxPdf;
    var PdfSize;

    var url,filePath,pdfDoc = null;
    var pageNum = 1,pageRendering = false,pageNumPending = null,scale = 1;
        var translations = @json(__('main'));

        document.addEventListener('DOMContentLoaded', function() {
          Livewire.emit('getprevfile');

        });
            // previous file
    document.addEventListener('prevfile-uploaded', event =>  {
            var canvasPdf = document.getElementById('canvasPdf');

          console.log(event.detail);
        url = event.detail.uploadedFileInfo.path;
        pageNum=event.detail.uploadedFileInfo.pageNum;
        PdfSize= event.detail.uploadedFileInfo.size;
        canvasPdf.height = parseInt(PdfSize['height'], 10);
        canvasPdf.width = parseInt(PdfSize['width'], 10);

        filePath =`{{ asset('${url}') }}`;

        ctxPdf = canvasPdf.getContext('2d');

      // Replace 'drawButton' with the actual id of your draw button

        document.getElementById('prev').addEventListener('click', onPrevPage);
        document.getElementById('next').addEventListener('click', onNextPage);

        // initial pdf into canvas
        pdfjsLib.getDocument(filePath).promise.then(function(pdfDoc_) {
            pdfDoc = pdfDoc_;
            document.getElementById('page_count').textContent = pdfDoc.numPages;
                // Initial/first page rendering
            renderPage(pageNum);
        });






    });
     //    queue for render pages
    function queueRenderPage(num) {
        if (pageRendering) {
        pageNumPending = num;
        } else {
        renderPage(num);
        }
    }
       // render page
    function renderPage(num) {
        pageRendering = true;
       num= parseInt(num, 10);
        // Using promise to fetch the page
        pdfDoc.getPage(num).then(function(page) {
        var viewport = page.getViewport({scale: scale});


        // Render PDF page into canvas context
        var renderContext = {
            canvasContext: ctxPdf,
            viewport: viewport
        };
        var renderTask = page.render(renderContext);
            // Draw the initial rectangle
            renderTask.promise.then(function () {
            pageRendering = false;
            if (pageNumPending !== null) {
                renderPage(pageNumPending);
                pageNumPending = null;
            }
        });






        // Wait for rendering to finish
        renderTask.promise.then(function() {
            pageRendering = false;
            if (pageNumPending !== null) {
            // New page rendering is pending
            renderPage(pageNumPending);
            pageNumPending = null;
            }
        });
        });

        // Update page counters
        document.getElementById('page_num').textContent = num;
    }

        //when click on prev page button
    function onPrevPage() {
        if (pageNum <= 1) {
        return;
        }
        pageNum--;
        queueRenderPage(pageNum);
    }
    //when click on next page button
    function onNextPage() {
        if (pageNum >= pdfDoc.numPages) {
        return;
        }
        pageNum++;
        queueRenderPage(pageNum);
    }


    </script>
    {{-- @if(session('success_message_signed'))


           <script>
             document.getElementById('WaitingSection').innerHTML=`

            `;
           </script>

    @endif --}}
    <script>
         var flashedMessage = document.getElementById('flashedMessage').value;

         console.log(flashedMessage);
        if (flashedMessage) {


            Swal.fire({
                title: translations.formsentsuccessfully_title,
                html:translations.formsentsuccessfully,
                icon: 'success',
                showCancelButton: true,
                confirmButtonColor: '#1277D1',
                    showConfirmButton: false,
                    cancelButtonColor:'#f3f4f6',
                    cancelButtonText:"<h5 style='color:000000;border:0;box-shadow: none;'>OK</h5>",
                confirmButtonText: 'View Signed Forms'
                }).then((result) => {
                if (result.isConfirmed)
                {
                    window.location.href = '{{ route('signpdf.index') }}';
                }
                })
        }
    </script>
@endpush




