<div>
    {{-- header --}}
    <div class="flex items-center justify-between p-4 border-b rounded-t ">
        <div class="flex items-center">
            <h3 class="text-xl font-semibold text-gray-900 ">
                {{ __('main.standbyimage') }}
            </h3>
        </div>
        <button wire:click="resetValue" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex
    items-center   close" data-dismiss="modal" aria-label="Close">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0
        011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
            </svg>
        </button>
    </div>
    {{-- end header --}}
    {{-- body --}}
    <div class=" 2xl:max-h-[700px] xs:max-h-[400px] flex justify-center items-center p-2">
        {{-- <img class="w-[640px] h-[390px] xs:w-[320px] xs:h-[195px] object-contain" src="" class="" id="imageModal" alt=""> --}}

        <div id="uploadBody" class="grid justify-center items-center  m-8" >







        </div>
    </div>

    {{-- end body --}}
    {{-- footer --}}
    <div class="flex justify-between items-center p-6 space-x-2 border-t border-gray-200 rounded-b ">
        <div class="flex justify-center space-x-2 items-center">
            <x-jet-secondary-button wire:click="resetValue" data-dismiss="modal" aria-label="Close" type="button" wire:loading.attr="disabled">
                {{ __('main.cancel') }}
            </x-jet-secondary-button>
            <x-jet-button wire:click="saveStandbyMediaKiosk" class="ml-3" type="button" wire:loading.attr="disabled" wire:target="currentFile">
                {{ __('main.save') }}
            </x-jet-button>
        </div>
        <div class="flex justify-between space-x-4 items-center"
        x-data="{ isUploading: false, progress: 0 }"
        x-on:livewire-upload-start="isUploading = true" x-on:livewire-upload-finish="isUploading = false"
        x-on:livewire-upload-error="isUploading = false" x-on:livewire-upload-progress="progress = $event.detail.progress">

            <label class="grid justify-center items-center mb-0" for="currentFile">
                <div class="flex justify-center items-center">

                        <svg x-show="isUploading" aria-hidden="true" class="inline w-8 h-8 text-gray-200 animate-spin dark:text-gray-600 fill-valid" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                            <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                        </svg>


                    <svg x-show="!isUploading" class="w-6 h-6  hover:cursor-pointer text-svg_primary hover:text-secondary_blue" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g id="SVGRepo_bgCarrier" stroke-width="0" />
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round" />
                        <g id="SVGRepo_iconCarrier">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M8 10C8 7.79086 9.79086 6 12 6C14.2091 6 16 7.79086 16 10V11H17C18.933 11 20.5 12.567 20.5 14.5C20.5 16.433 18.933 18 17 18H16C15.4477 18 15 18.4477 15 19C15 19.5523 15.4477 20 16 20H17C20.0376 20 22.5 17.5376 22.5 14.5C22.5 11.7793 20.5245 9.51997 17.9296 9.07824C17.4862 6.20213 15.0003 4 12 4C8.99974 4 6.51381 6.20213 6.07036 9.07824C3.47551 9.51997 1.5 11.7793 1.5 14.5C1.5 17.5376 3.96243 20 7 20H8C8.55228 20 9 19.5523 9 19C9 18.4477 8.55228 18 8 18H7C5.067 18 3.5 16.433 3.5 14.5C3.5 12.567 5.067 11 7 11H8V10ZM15.7071 13.2929L12.7071 10.2929C12.3166 9.90237 11.6834 9.90237 11.2929 10.2929L8.29289 13.2929C7.90237 13.6834 7.90237 14.3166 8.29289 14.7071C8.68342 15.0976 9.31658 15.0976 9.70711 14.7071L11 13.4142V19C11 19.5523 11.4477 20 12 20C12.5523 20 13 19.5523 13 19V13.4142L14.2929 14.7071C14.6834 15.0976 15.3166 15.0976 15.7071 14.7071C16.0976 14.3166 16.0976 13.6834 15.7071 13.2929Z" fill="CurrentColor" />
                        </g>
                    </svg>
                </div>
                <h1 x-show="!isUploading" class="text-xs">{{ __('main.upload') }}</h1>
                <h1 x-show="isUploading" class="text-xs">{{ __('uploading') }}</h1>
                <input wire:model="currentFile" class="image opacity-0 absolute -z-10" type="file" name="currentFile" id="currentFile" accept="image/*, video/*" />
            </label>

            <div class="grid justify-center items-center">
                <div class="flex justify-center items-center">

                    <!-- Uploaded to: SVG Repo, www.svgrepo.com, Generator: SVG Repo Mixer Tools -->
                    <svg wire:click="setDefultStandByImage" class="w-6 h-6  hover:cursor-pointer text-svg_primary hover:text-secondary_blue" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M17 5.5C17 4.11929 15.8807 3 14.5 3H5.5C4.11929 3 3 4.11929 3 5.5V14.5C3 15.8807 4.11929 17 5.5 17H9.59971C9.43777 16.6832 9.30564 16.3486 9.20703 16H5.5C4.67157 16 4 15.3284 4 14.5V7H16V9.20703C16.3486 9.30564 16.6832 9.43777 17 9.59971V5.5ZM5.5 4H14.5C15.3284 4 16 4.67157 16 5.5V6H4V5.5C4 4.67157 4.67157 4 5.5 4Z" fill="currentColor" />
                        <path d="M10.4175 15.9412C11.2352 15.1544 11.2352 13.8457 10.4175 13.0588L10.2695 12.9165C10.4392 12.4312 10.6847 11.9834 10.9912 11.5885L11.1901 11.6473C12.2875 11.9715 13.4327 11.3106 13.701 10.1981L13.7712 9.90699C14.0085 9.86699 14.252 9.84619 14.5001 9.84619C14.7483 9.84619 14.9918 9.86699 15.2291 9.907L15.2993 10.1981C15.5676 11.3106 16.7128 11.9715 17.8102 11.6473L18.0091 11.5885C18.3156 11.9834 18.5611 12.4312 18.7308 12.9165L18.5828 13.0588C17.7651 13.8457 17.7651 15.1544 18.5828 15.9412L18.7307 16.0836C18.5611 16.5689 18.3156 17.0167 18.0091 17.4116L17.8102 17.3528C16.7128 17.0286 15.5676 17.6895 15.2993 18.8019L15.2291 19.0931C14.9918 19.1331 14.7483 19.1539 14.5001 19.1539C14.252 19.1539 14.0085 19.1331 13.7712 19.0931L13.701 18.8019C13.4327 17.6895 12.2875 17.0286 11.1901 17.3528L10.9912 17.4116C10.6847 17.0167 10.4392 16.5689 10.2695 16.0836L10.4175 15.9412ZM13.2735 14.5C13.2735 15.201 13.8227 15.7693 14.5001 15.7693C15.1776 15.7693 15.7268 15.201 15.7268 14.5C15.7268 13.7991 15.1776 13.2308 14.5001 13.2308C13.8227 13.2308 13.2735 13.7991 13.2735 14.5Z" fill="currentColor" />
                    </svg>
                </div>
                <h1 class="text-xs">{{ __('main.setdefault') }}</h1>
            </div>


        </div>
    </div>


    {{-- end footer --}}


      {{-- crop modal --}}

      <x-crop-image-modal :modal="$modal" :type="'edit-standby'" />
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    var translations = @json(__('main'));
    var body=document.getElementById('uploadBody');
    document.addEventListener('media-edited', event => {
    const media = event.detail;

    if (media.type == "video") {
        const path = media.path;
        const videoElement = document.createElement('video');
        videoElement.className = 'w-[640px] h-[390px] xs:w-[320px] xs:h-[195px] object-contain';
        videoElement.autoplay = true;
        videoElement.muted = true;
        videoElement.controls = true;
        videoElement.innerHTML = `
            <source src="${path}" type="video/mp4">
            Your browser does not support the video tag.
        `;
        body.appendChild(videoElement);
    } else {
        const path = media.path;
        const imgElement = document.createElement('img');
        imgElement.className = 'w-[640px] h-[390px] xs:w-[320px] xs:h-[195px] object-contain';
        imgElement.id = 'imageModal';
        imgElement.src = path;
        imgElement.alt = '';
        body.appendChild(imgElement);
    }
});


    document.addEventListener('image-updated-edit', event => {
        console.log('edit');
        result = document.querySelector('.result-upload-edit-standby');
        // img_w = document.querySelector('.img-w'),
        // img_h = document.querySelector('.img-h'),
        // options = document.querySelector('.options'),
        save = document.querySelector('.save');

        // dwn = document.querySelector('.download'),
        upload = document.querySelector('.image');
        cropper = '';
        var finalCropWidth = 640;
        var finalCropHeight = 390;
        var finalAspectRatio = finalCropWidth / finalCropHeight;
        // on change show image with crop options

        // start file reader
        const reader = new FileReader();
        let img = document.createElement('img');
        img.id = 'image';
        img.src = @this.imagesrc;

        // clean result before
        result.innerHTML = '';
        // append new image
        result.appendChild(img);

        // show save btn and options
        // save.classList.remove('hide');
        // options.classList.remove('hide');
        // init cropper
        cropper = new Cropper(img, {
            dragMode: 'move'
            , aspectRatio: finalAspectRatio
            , autoCropArea: 0.9
            , restore: false
            , guides: false
            , center: false
            , highlight: false
            , cropBoxMovable: true
            , cropBoxResizable: true,

            toggleDragModeOnDblclick: false
        , });




        // save on click

    });

    function cropimage() {
        // get result to data uri
        let imgSrc = cropper.getCroppedCanvas({
            width: 1280
            , height: 780
        }).toDataURL();



        @this.saveImageTemp(imgSrc);
        @this.closemodalwithsave();
        // dwn.classList.remove('hide');
        // dwn.download = 'imagename.png';
        // dwn.setAttribute('href',imgSrc);
    }

    document.addEventListener('save', (e) => {
        e.preventDefault();
        // get result to data uri
        let imgSrc = cropper.getCroppedCanvas({
            width: 1280
            , height: 780
        }).toDataURL();



        @this.saveImageTemp(imgSrc);
        @this.closemodalwithsave();
        // dwn.classList.remove('hide');
        // dwn.download = 'imagename.png';
        // dwn.setAttribute('href',imgSrc);
    });

    // error message
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
