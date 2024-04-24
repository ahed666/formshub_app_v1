<div class="bg-white  overflow-hidden h-[100vh]  ">
    <audio class="hidden" id="SuccessAudio" >
        <source src="{{ asset('/sounds/Success.mp3') }}" type="audio/mpeg">

    </audio>
    @if($formPdfFile)
    {{-- sign_section --}}
     <div id="sign_section" class="grid grid-cols-12 gap-2">
        <div class="col-span-6   xs:col-span-12   bg-white
          min-h-[95vh] max-h-full     ">
            <div class="flex justify-center items-center space-x-2 my-2">
                <!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">
                <svg id="prev" class="w-8 h-8 text-secondary_blue hover:cursor-pointer" fill="currentColor"  viewBox="0 0 24 24" id="previous" data-name="Flat Color" xmlns="http://www.w3.org/2000/svg" class="icon flat-color" transform="rotate(0)">
                <g id="SVGRepo_bgCarrier" stroke-width="0"/>
                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>
                <g id="SVGRepo_iconCarrier">
                <path id="primary" d="M17.45,2.11a1,1,0,0,0-1.05.09l-12,9a1,1,0,0,0,0,1.6l12,9a1,1,0,0,0,1.05.09A1,1,0,0,0,18,21V3A1,1,0,0,0,17.45,2.11Z" style="fill: currentColor;"/>
                </g>
                </svg>

                <h1 >Page: <span id="page_num"></span> / <span id="page_count"></span></h1>

                <!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">
                <svg fill="currentColor" id="next" class="w-8 h-8 text-secondary_blue hover:cursor-pointer" viewBox="0 0 24 24" id="previous" data-name="Flat Color" xmlns="http://www.w3.org/2000/svg" class="icon flat-color" transform="rotate(180)">
                <g id="SVGRepo_bgCarrier" stroke-width="0"/>
                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>
                <g id="SVGRepo_iconCarrier">
                <path id="primary" d="M17.45,2.11a1,1,0,0,0-1.05.09l-12,9a1,1,0,0,0,0,1.6l12,9a1,1,0,0,0,1.05.09A1,1,0,0,0,18,21V3A1,1,0,0,0,17.45,2.11Z" style="fill: currentColor;"/>
                </g>
                </svg>

            </div>


            <div class="relative flex justify-center items-center min-h-[90vh] max-h-full overflow-auto">
                <canvas class="absolute top-4 left-auto border border-gray-200" width="595" height="842" id="canvasPdf"></canvas>
                <canvas class="absolute top-4 left-auto border border-gray-200" width="595" height="842" id="canvasSignaturePdf"></canvas>
            </div>
        </div>
        <div class="col-span-6  xs:col-span-12   ">
                <div id="drawing-pad" class="h-full grid grid-rows-4  gap-4 p-4">

                    <div class="row-span-1 text-center flex justify-center items-center min-h-32 h-32 text-xl font-bold pt-4">{{ $current_message->message }}</div>
                    <div class="row-span-2 grid justify-center items-center">
                        <div class="flex justify-end items-center mb-2">
                            <button id="clearButton" onclick="clearDrawing()" class="px-2 py-4 flex bg-gray-300 rounded-[0.5rem] " type="button"  >
                                {{ $buttonsText['clear'] }}
                                <svg fill="#000000" class="w-6 h-6" viewBox="0 0 1024 1024" t="1569683368540" class="icon" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="9723" xmlns:xlink="http://www.w3.org/1999/xlink"><defs><style type="text/css"></style></defs><path d="M899.1 869.6l-53-305.6H864c14.4 0 26-11.6 26-26V346c0-14.4-11.6-26-26-26H618V138c0-14.4-11.6-26-26-26H432c-14.4 0-26 11.6-26 26v182H160c-14.4 0-26 11.6-26 26v192c0 14.4 11.6 26 26 26h17.9l-53 305.6c-0.3 1.5-0.4 3-0.4 4.4 0 14.4 11.6 26 26 26h723c1.5 0 3-0.1 4.4-0.4 14.2-2.4 23.7-15.9 21.2-30zM204 390h272V182h72v208h272v104H204V390z m468 440V674c0-4.4-3.6-8-8-8h-48c-4.4 0-8 3.6-8 8v156H416V674c0-4.4-3.6-8-8-8h-48c-4.4 0-8 3.6-8 8v156H202.8l45.1-260H776l45.1 260H672z" p-id="9724"></path></svg>

                            </button>
                        </div>

                        <canvas id="canvasSignture" class="shadow-inner border-secondary_blue  bg-primary_blue border-2 rounded-[0.5rem]" width="600" height="300"></canvas>
                    </div>

                    <div class="row-span-1 flex items-end w-full mb-1 bottom-0">

                        <button disabled id="signButton" class="text-center flex w-full  justify-center items-center  text-3xl uppercase  justify-self-end font-bold disabled:bg-blue-200 bg-secondary_blue col-span-2 h-28  text-white select-none " type="button"  >
                            {{ $buttonsText['finish'] }}<span id="SignArrow" class="ml-8   text-4xl">{{ __(' ➝') }}</span>
                        </button>
                    </div>
                </div>


        </div>
    </div>

    @endif
    <div id="saving" class="hidden w-full h-full  justify-center items-center">


         <!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">
         <!-- Uploaded to: SVG Repo, www.svgrepo.com, Transformed by: SVG Repo Mixer Tools -->
         <svg class="animate-ping  h-20 w-20 mr-3 " viewBox="0 0 24 24" id="upload-double-arrow-3" data-name="Line Color" xmlns="http://www.w3.org/2000/svg" class="icon line-color">
             <g id="SVGRepo_bgCarrier" stroke-width="0"/>
             <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>
             <g id="SVGRepo_iconCarrier">
             <polyline id="secondary" points="9 6 12 3 15 6" style="fill: none; stroke: #1277d1; stroke-linecap: round; stroke-linejoin: round; stroke-width: 2;"/>
             <polyline id="secondary-2" data-name="secondary" points="9 11 12 8 15 11" style="fill: none; stroke: #1277d1; stroke-linecap: round; stroke-linejoin: round; stroke-width: 2;"/>
             <line id="secondary-3" data-name="secondary" x1="12" y1="8" x2="12" y2="17" style="fill: none; stroke: #1277d1; stroke-linecap: round; stroke-linejoin: round; stroke-width: 2;"/>
             <path id="primary" d="M4,17v3a1,1,0,0,0,1,1H19a1,1,0,0,0,1-1V17" style="fill: none; stroke: #878787; stroke-linecap: round; stroke-linejoin: round; stroke-width: 2;"/>
             </g>
         </svg>
    </div>
    <div  id="thanks_section" class="hidden justify_center items-center  text-center  h-full  " >

    </div>
     {{-- error reload  --}}
     <div id="errorReload" class="hidden grid-rows-4 h-full justify-center items-center bg-white  ">

        <div class="row-span-2 grid ">



            <div class="flex justify-center items-center">
                <img class="w-28 h-28 object-contain" src="{{ asset('images/exclamation_mark.gif') }}" alt="">
            </div>
             {{-- error --}}
             <div class="flex justify-center items-center"><span class="text-xl text-black text-center ">{{ __('Failed to connect to the server') }}</span></div>

        </div>


        {{-- error message --}}
        <div class="grid row-span-2 justify-center items-center">
            <span class="text-md text-black">{{ __('Check network connectivity, and try again.') }}</span>
            <div class="row-span-1 flex justify-center items-center hover:cursor-pointer">
                <a onclick="reload()"  class="text-secondary_blue font-bold ">

                  <span id="recheckText" >
                    {{ __('Retry') }}
                </span>
                </a>
              </div>
        </div>

    </div>
 </div>

 @push('scripts')
  <script src="{{ asset('js/config.js')}}"></script>
 <script src="{{ asset('js/index.min.js')}}"></script>
 <script src="{{ asset('https://cdn.jsdelivr.net/gh/livewire/sortable@v0.x.x/dist/livewire-sortable.js')}}"></script>
 <script defer src="{{ asset('https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.js')}}" defer></script>
 <script src="{{ asset('https://cdn.jsdelivr.net/npm/sweetalert2@11')}}"></script>
 <script src="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.6.347/pdf.min.js') }}"></script>
 <script src="{{ asset('https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js') }}"></script>

 {{-- detect the start date of expiry  --}}
 <script>


         pdfjsLib.GlobalWorkerOptions.workerSrc = "https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.6.347/pdf.worker.min.js";
         var alarmtext={
             "en":{"warning":"Do you need more time?","button":"Yes"},
             "ar":{"warning":"هل تريد المزيد من الوقت؟",
                     "button":"نعم"},
             "tl":{"warning":"Kailangan mo ba ng mas maraming oras?","button":"Oo"},
             "ur":{"warning":"کیا آپ کو مزید وقت کی ضرورت ہے؟",
             "button":"جی ہاں"}
         };
         var language="en";
         createDrawing();
         var start_x;
         var start_y;
         var end_x;
         var end_y;
         var drawingPad;
         var blob;
         var dataURL;
         var filePath;
         var pdfDoc = null;
         var idleTime=0;
         var ConnectionError=false;
         var finished=false;
         var savingdiv;
         var sign_section=document.getElementById('sign_section');

          var canvasPdf = document.getElementById('canvasPdf');
          var canvasSignaturePdf=document.getElementById('canvasSignaturePdf');
          var  ctx = canvasPdf.getContext('2d');
          var  ctxSignaturePdf = canvasSignaturePdf.getContext('2d');
            // sounds
        var successAudio = document.getElementById('SuccessAudio');
     document.addEventListener('livewire:load', function () {
         start();
         var formPdfFile = @json($formPdfFile);
         if(formPdfFile){
              filePath =`{{ asset('${formPdfFile.path_file}') }}`;
              start_x = parseFloat(formPdfFile.start_cx);
             start_y = parseFloat(formPdfFile.start_cy);
             end_x = parseFloat(formPdfFile.end_cx);
             end_y = parseFloat(formPdfFile.end_cy);
             var pageNum = parseInt(formPdfFile.page_num, 10);
         pageRendering = false,
         pageNumPending = null,
         scale = 1;


         let start = null;
         let end=null;
         let image = new Image();
         const signButton = document.getElementById("signButton"); // Replace 'drawButton' with the actual id of your draw button

         function queueRenderPage(num) {
             if (pageRendering) {
             pageNumPending = num;
             } else {
             renderPage(num);
             }
         }
         function renderPage(num) {
             pageRendering = true;
             // Using promise to fetch the page
             pdfDoc.getPage(num).then(function(page) {
             var viewport = page.getViewport({scale: scale});
             canvasPdf.height = viewport.height;
             canvasPdf.width = viewport.width;
             canvasSignaturePdf.height = viewport.height;
             canvasSignaturePdf.width = viewport.width;
             // Render PDF page into canvas context
             var renderContext = {
                 canvasContext: ctx,
                 viewport: viewport
             };
             var renderTask = page.render(renderContext);



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
         function onPrevPage() {
             if (pageNum <= 1) {
             return;
             }
             pageNum--;
             queueRenderPage(pageNum);
         }
         document.getElementById('prev').addEventListener('click', onPrevPage);

         /**
          * Displays next page.
          */
         function onNextPage() {
             if (pageNum >= pdfDoc.numPages) {
             return;
             }
             pageNum++;
             queueRenderPage(pageNum);
         }
         document.getElementById('next').addEventListener('click', onNextPage);


         try {
             pdfjsLib.getDocument(filePath).promise.then(function(pdfDoc_) {

                 pdfDoc = pdfDoc_;

                 document.getElementById('page_count').textContent = pdfDoc.numPages;

                     // Initial/first page rendering
                     renderPage(pageNum);

             });
         }
         catch (error)
         {
                 console.log(error);
         }

     //  make signature show on pdf

         function savesign(){

             // save sign
             console.log(dataURL);
             // Livewire.emit('saveAsPDF', dataURL);
             console.log('saveAsPDF');
             finishform();
         }


         document.getElementById('signButton').addEventListener('click', savesign);


     }

     });

        function dataURLToBlob(dataURL)
        {
             var parts = dataURL.split(';base64,');
             var contentType = parts[0].split(":")[1];
             var raw = window.atob(parts[1]);
             var rawLength = raw.length;
             var uInt8Array = new Uint8Array(rawLength);

             for (var i = 0; i < rawLength; ++i) {
                 uInt8Array[i] = raw.charCodeAt(i);
             }
             return new Blob([uInt8Array], { type: contentType });
        }

        function createDrawing()
        {
             var wrapper = document.getElementById("drawing-pad");
             var canvas =document.getElementById("canvasSignture");
             drawingPad = new SignaturePad(canvas,{ minWidth: 1,maxWidth: 2, backgroundColor: 'rgb(255, 255, 255,0)'});
             canvas.addEventListener('touchstart', handleTouch);
             canvas.addEventListener('touchmove', handleTouch);
             canvas.addEventListener('click', handleTouch);

             canvas.width = canvas.scrollWidth;
             canvas.height = canvas.scrollHeight;
             window.addEventListener('resize', function() {canvas.width = canvas.scrollWidth;canvas.height = canvas.scrollHeight;});

        }
     function handleTouch()
        {
            document.getElementById('signButton').removeAttribute('disabled');
            document.getElementById('SignArrow').classList.add('animate-ping');
            // document.getElementById('canvasSignture').classList.remove('bg-gray-200', 'border-gray-300');
            // document.getElementById('canvasSignture').classList.add('border-secondary_blue', 'bg-primary_blue');

            console.log(document.getElementById('signButton'));
             idleTime = 0;
             dataURL = drawingPad.toDataURL("image/png");
            blob= dataURLToBlob(dataURL);
             let image = new Image();
             image.src = dataURL;
             image.classList.add("object-contain");
             image.onload = function() {
              // Now the image is loaded, and you can draw it on the canvas
             ctxSignaturePdf.drawImage(image, Math.min(start_x, end_x), Math.min(start_y, end_y), Math.abs(start_x - end_x), Math.abs(start_y - end_y));};
        }
     function clearDrawing()
     {
             drawingPad.clear();
             ctxSignaturePdf.clearRect(0, 0, canvasSignaturePdf.width, canvasSignaturePdf.height);
             document.getElementById('signButton').setAttribute('disabled');
             document.getElementById('SignArrow').classList.remove('animate-ping');
            //  document.getElementById('canvasSignture').classList.remove('border-secondary_blue', 'bg-primary_blue');
            //  document.getElementById('canvasSignture').classList.add('bg-gray-200', 'border-gray-300');

     }

 </script>
 {{-- timer  --}}
 <script>
     function start(){

         var start=true;
         if(start==true){
         $(document).ready(function () {
             // Increment the idle time counter every minute.
             var idleInterval = setInterval(timerIncrementStart, 15000); // 1 minute

             // Zero the idle timer on mouse movement.

             $('#signButton').click(function (e) {

             idleTime = 0;
             console.log('signButton');
             });
             $('#clearButton').click(function (e) {

                 idleTime = 0;
                 console.log('clearButton');
                 });

             // if(current_question.type=="drawing"){
             // $(this).touchstart(function (e) {
             //     console.log('touchstart');
             //     idleTime = 0;
             // });
             // $(this).touchmove(function (e) {
             //     console.log('touchmove');
             //     idleTime = 0;
             // });
             // }

         });
         }

        function timerIncrementStart() {
             idleTime = idleTime + 1;
             console.log(idleTime);
             if (idleTime == 3&&ConnectionError==false)
            {// 1 minutes
                console.log('idleTime=3');
                 var text = JSON.parse(JSON.stringify(alarmtext));

                 let timerInterval
                 Swal.fire({

                 html:`<div class="pointer-events-none grid">
                         <h1>${ text[language]['warning']}</h1>
                         <h1><b></b></h1>
                     </div>`,
                 icon: 'warning',
                 showConfirmButton:true,
                 confirmButtonColor: '#3085d6',
                 confirmButtonText: text[language]['button'],
                 timer: 30000,
                 allowOutsideClick: false,
                 timerProgressBar: true,
                 didOpen: () => {
                     // Swal.showLoading()
                     const b = Swal.getHtmlContainer().querySelector('b')
                     timerInterval = setInterval(() => {
                         b.textContent =parseInt(Swal.getTimerLeft()/1000)
                     }, 100)
                 },
                 willClose: () => {
                     clearInterval(timerInterval)
                 }
                 }).then((result) => {
                    console.log(result);
                 if (result.isConfirmed)
                 {
                     idleTime=0;
                     start=true;
                     console.log('result.isConfirmed');

                 }
                 else
                {

                    Livewire.emit('timeout');

                }

                 })


            }

        }
     }


     // function finishform(){
     //    Livewire.emit('timeout');
     // }
     // if successed dsigned and saved
     document.addEventListener('submitted',(e)=>{

             savingdiv=document.getElementById('saving');
             sign_section.classList.remove('grid');
             sign_section.classList.add('hidden');
             // playSound()

             successAudio.play();// Play the audio


             savingdiv.classList.remove('flex');
             savingdiv.classList.add('hidden');
             thanks_section=document.getElementById('thanks_section');
             thanks_section.classList.remove('hidden');
             thanks_section.classList.add('grid');
             thanks_section.innerHTML=`
                 <div class=" flex justify-center items-center ">
                     <img class="animate-pulse" src="{{ asset('images/checked1.png') }}" width="100px" height="100px">
                 </div>


             `;


             // start timer of thanks page
             finish();
     });
     function submit(){
         console.log('submit');
             savingdiv=document.getElementById('saving');
             savingdiv.classList.remove('hidden');
             savingdiv.classList.add('flex');

             //set timeout for fetch about 8 seconds
             const timeout=8000;
             const signal = AbortSignal.timeout(timeout);
             fetch(app_url,{
             method: "GET",
             signal,
             }).then(response => response)
             .then(data => { //if connection




                 emitLivewireEventWithTimeout('saveAsPDF',dataURL, 15000)
                 .then((message) => {

                     // Handle a successful Livewire event
                 })
                 .catch((error) => {
                     savingdiv.classList.remove('flex');
                     savingdiv.classList.add('hidden');
                     reload();
                 });

             })
             .catch((error) => { // if catch error
             savingdiv.classList.remove('flex');
             savingdiv.classList.add('hidden');
             // errordiv.classList.remove('hidden');
             reload();
             });
     }
     function emitLivewireEventWithTimeout(eventName, eventData, timeout) {
             return new Promise((resolve, reject) => {
                 // Emit the Livewire event
                 Livewire.emit(eventName,eventData);

                 // Set a timeout for the response
                 const timeoutId = setTimeout(() => {

                     reject(new Error('no connection'));

                 }, timeout);

                 // Listen for the Livewire response
                 Livewire.hook('message.processed', () => {
                     clearTimeout(timeoutId); // Clear the timeout if the response is received
                     resolve('Livewire event successful'); // Resolve with a success message
                 });
           });
     }
     // to finish form
     function finishform()
     {
         console.log('finishform');
         finished=true;

         if(sign_section!=null)
         {
             sign_section.classList.remove('grid');
             sign_section.classList.add('hidden');
            console.log(sign_section);
          }

         submit();



     }
     function finish()
     {   console.log('finish');
             var idleTime = 0;
             var start=true;
             if(start==true){
             $(document).ready(function () {
                 // Increment the idle time counter every minute.
                 var idleInterval = setInterval(timerIncrementFinish, 2000);

                 // Zero the idle timer on mouse movement.
                 $(this).mousemove(function (e) {

                     idleTime = 0;

                 });
                 $(this).keypress(function (e) {
                     idleTime = 0;
                 });

             });
             }
             function timerIncrementFinish() {
                 idleTime = idleTime + 1;

                 if (idleTime == 1) {// 10 seconds
                     reload();
                 }

             }
     }

     function reload()
     {
        console.log('reload');
             const timeout=3000;
             const signal = AbortSignal.timeout(timeout);
             fetch(app_url, {
                 method: "GET",
                 signal,
                 }).then(response => response)
                 .then(data => {
                 window.location.reload();
                // console.log('updatekioskstatus');
                // Livewire.emit('updatekioskstatus');
                 })
                 .catch((error) => {
                    ConnectionError=true;
                     formSection=document.getElementById('form_section');
                 errorreload=document.getElementById('errorReload');

                 sign_section.classList.add('hidden');
                 errorreload.classList.remove('hidden');
                 errorreload.classList.add('grid');
                 waiterror();
                 });
     }
     // wait error connection to refresh
     function waiterror()
     {
             $(document).ready(function () {
                 // Increment the idle time counter every minute.
                 var idleInterval = setInterval(timerIncrementFinish, 10000); // 10 seconds
             });
             function timerIncrementFinish()
             {reload();}
     }
     document.addEventListener('refreshkiosknow',(e)=>{
      window.location.reload();

     });

 </script>

 @endpush
