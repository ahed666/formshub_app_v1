<div wire:loading.delay.longest>
     {{-- header --}}
     <div class="flex items-start justify-between p-4 border-b rounded-t ">
        <h3 class="text-xl font-semibold text-gray-900 ">
            {{ __('main.uploadfile') }}
        </h3>
        <button  wire:click="resetvalues()" type="button"  class="close text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex
            items-center "  data-dismiss="modal" aria-label="Close">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0
            011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
        </button>
    </div>
    {{-- end header --}}
    @if(!$valid)
    <x-add_item_error  :error="$error" :subscribe="$current_subscribe" />
    @else
    {{-- body --}}
    <div class="grid px-2 ">
        <h1 class="mt-1 text-sm text-primary_red">{{ __('main.recommandedvideoresolution') }}</h1>
        <h1 class="mt-1 text-sm text-primary_red">{{ __('main.recommandedvideosize') }}</h1>

    </div>
    <form wire:submit.prevent="saveFile">

        @csrf
        @if($currentFilePath)
          {{-- video or image view div --}}
        <div id="uploadBody" class="grid justify-center items-center  m-8">

            @if($currentMediaType=="video"&&$validVideo)

                <video id="mediavideo-video0" class="w-[200px] h-[200px]" autoplay muted  controls >
                    <source
                    @if(str_contains($currentFilePath, 'blob:'))
                    src="{{ $currentFilePath}}"
                    @else
                    src="{{ asset($currentFilePath)}}"
                    @endif
                     type="video/mp4">
                    Your browser does not support the video tag.
                </video>
                <h1 class="mt-2 font-bold">{{ __('main.duration') }}<span class="text-secondary_blue font-normal">{{ $this->duration }}</span>{{ __('main.secondsymobl') }}</h1>
            @else
                <img class="w-[640px] h-[390px] xs:w-[320px] xs:h-[195px] object-contain" id="mediaimage-image0"

                 @if(str_contains($currentFilePath, 'data:image'))
                 src="{{ $currentFilePath}}"
                 @else
                 src="{{ asset($currentFilePath)}}"
                 @endif
                  alt="">
                <div class="flex justify-center items-center">
                     <h1 class="text-center">{{ __('main.duration') }} <input type="number" min="1" max="180" wire:model="duration" class="rounded-[0.5rem] w-28 mt-1"> {{ __('main.secondsymobl') }}</h1>
                </div>
            @endif


        </div>
        @else
        {{-- upload div --}}
        <div
        x-data="{ isUploading: false, progress: 0 }"
        x-on:livewire-upload-start="isUploading = true"
        x-on:livewire-upload-finish="isUploading = false"
        x-on:livewire-upload-error="isUploading = false"
        x-on:livewire-upload-progress="progress = $event.detail.progress"
         id="uploadBody" class="flex justify-center items-center  m-8">
            <label class="h-48  flex  justify-center items-center relative hover:cursor-pointer cursor-pointer   rounded-[0.5rem] w-1/2 border-[1px] border-gray-200 border-dashed  mb-0" for="image">
                <input  onchange="uploadImagenewmedia(event,'0','newmedia')" wire:model="currentFile" class="   h-48 opacity-0 absolute  hover:cursor-pointer cursor-pointer w-full" type="file" name="file" id="file" accept="image/*, video/*"  />
                <div class="grid justify-center items-center">
                    <div  class="pl-2 pr-2 pt-2 hover:cursor-pointer cursor-pointer flex justify-center items-center">


                        <!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">
                        <svg   wire:loading.class="animate-bounce " wire:target="currentFile"
                        class=" w-4 h-4 hover:cursor-pointer cursor-pointer" fill="#000000" width="800px" height="800px" viewBox="0 0 24 24" id="upload-double-arrow-3" data-name="Line Color" xmlns="http://www.w3.org/2000/svg" class="icon line-color">
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
                    <div class="pl-2 pr-2 pb-2 hover:cursor-pointer cursor-pointer   flex justify-center">

                       <h1  wire:loading.class="hidden" wire:target="currentFile" class="mt-1  text-sm ">{{ __('main.upload') }}</h1>
                       <h1   wire:loading.class.remove="hidden" wire:target="currentFile" class="hidden mt-1  text-sm "><span class="animate-pulse ">{{ __('main.uploading') }}</span> {{ __('main.pleasewait') }}</h1>

                    </div>

                    <div class="w-full justify-center items-center " x-show="isUploading">

                        <progress class="" max="100" x-bind:value="progress"></progress>

                    </div>
                </div>
            </label>


        </div>
        @endif




    {{-- end body --}}

    {{-- footer --}}
    <div class="flex justify-between items-center border-t border-gray-200 rounded-b">
        <div class="flex space-x-4">
            <div class="flex items-center p-6 space-x-2  ">
                <!-- save btn -->
                <x-jet-secondary-button   wire:click="resetvalues   ()" data-dismiss="modal" aria-label="Close"   type="button" >
                    {{ __('main.cancel') }}
                </x-jet-secondary-button>
                <x-jet-button    class="ml-3" type="submit" wire:loading.attr="disabled"    >
                    {{ __('main.save') }}
                </x-jet-button>

            </div>


        </div>
        {{-- error of validation --}}
        <div class="flex items-center p-6 space-x-2 ">
            <ol class="list-decimal" >
            @error('video.*') <li class="text-red-400"><span class="text-sm text-red-400 error">{{ $message }}</span></li> @enderror
            @error('currentFilePath') <li class="text-red-400"><span class="text-sm text-red-400 error">{{ $message }}</span></li> @enderror
            @error('duration') <li class="text-red-400"><span class="text-sm text-red-400 error">{{ $message }}</span></li> @enderror

        </ol>
        </div>
    </div>
    </form>
     {{-- end footer --}}
    @endif



    {{-- crop modal --}}

    <x-crop-image-modal :modal="$modal" :type="'newmedia'" />

</div>
@push('scripts')
<script>
    var translations = @json(__('main'));
</script>
<script  src="{{ asset('js/validationmediafile.js') }}"></script>

    <script>
 var base64Video;
 let indexImage;
 var translations = @json(__('main'));
 function closemodal(){
        modal.classList.add('hidden');
    }
//  on uploading file
 function uploadImagenewmedia(event,index,type){
    imageInput=event.target;
//    extract file
    file = imageInput.files[0];
    // deteect type of file
      const fileType = file.type;
    const isImage = fileType.startsWith('image/');
    const isVideo = fileType.startsWith('video/');
    indexImage=index;


    //   if image open modal of cropping
    if (isImage) {
        modal=document.getElementById(`cropimage-${type}`);
        const  result = document.querySelector(`.result-upload-${type}`);


        const reader = new FileReader();
        modal.classList.remove('hidden');
        reader.onload = (event) => {
        const img = new Image();
        img.src = event.target.result;
        img.onload = () => {

                result.innerHTML = '';
                const canvas = document.createElement('canvas');
                const context = canvas.getContext('2d');
                canvas.width = 700;
                canvas.height = 400;
                context.drawImage(img, 0, 0, 700, 400);
                result.appendChild(canvas);
                var finalCropWidth = 640;
                var finalCropHeight = 390;
                var finalAspectRatio = finalCropWidth / finalCropHeight;
                cropper = new Cropper(canvas, {
                    dragMode: 'move',
                    aspectRatio: finalAspectRatio,
                    autoCropArea: 0.9,
                    restore: false,
                    guides: false,
                    center: false,
                    highlight: false,
                    cropBoxMovable: true,
                    cropBoxResizable: true,

                    toggleDragModeOnDblclick: false,
                });

        };
        };

        reader.readAsDataURL(file);
   }
    //   if video set it to livewire
   else
   {
        const videoUrl = URL.createObjectURL(file);
        const videoSize = file.size; // size in bytes
            const videoSizeMB = (videoSize / (1024 * 1024)).toFixed(2);
        const tempVideoElement = document.createElement('video');
            tempVideoElement.src = videoUrl;
            tempVideoElement.addEventListener('loadedmetadata', () => {
                const duration =Math.round(tempVideoElement.duration) ;

                if(duration > @this.maxVideoDuration)
                {
                    errorUpload(translations.maxvideodurationwarning.replace(':duration', @this.maxVideoDuration));
                }
                else if(videoSizeMB > @this.maxFileSize)
                {
                    errorUpload(translations.maxfilesizewarning.replace(':size', @this.maxFileSize));
                }
                else
                // Do something with the duration if needed
                // For example, you can save it to your Livewire component
               {
                    // console.log(file);
                    // const reader = new FileReader();
                    // reader.onload = function(e) {
                    // const base64String = e.target.result.split(',')[1]; // Get the base64 part

                    // @this.saveVideo(videoUrl,base64String, duration);
                    // };
                    // reader.readAsDataURL(file);
                    fetch(videoUrl)
                    .then(res => res.blob())
                    .then(blob => {
                        let newFile = new File([blob], file.name, { type: blob.type });
                        // Use Livewire to upload the file
                        // @this.upload('video', newFile);
                        @this.saveVideo(videoUrl, duration);
                    });
                }
            });
   }

}
function cropimagenewmedia(){

// image=document.getElementById(`mediaimage-image${indexImage}`);

const canvas = cropper.getCroppedCanvas({
                width:1280,
                height:780
                });
const croppedImage = canvas.toDataURL('image/jpeg');

console.log(croppedImage);
@this.saveImage(croppedImage,indexImage);

modal.classList.add('hidden');

}



function errorUpload(message){
    Swal.fire({
            icon: 'error',
            title: 'Error',
            text: message,
            confirmButtonColor:'#1277D1',
            })
}
    document.addEventListener('error', event =>  {
        const errorMessage=event.detail.message;
        const title=event.detail.title;


        Swal.fire({
            icon: 'error',
            title: title,
            text: errorMessage,
            confirmButtonColor:'#1277D1',
            })
    });


    </script>
@endpush
