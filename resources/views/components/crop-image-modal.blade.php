<div id="cropimage-{{ $type }}" class="fixed inset-0 z-50 flex items-center justify-center p-4 {{ $modal ? 'block' : 'hidden' }}">
    <div class="relative w-full max-w-lg bg-white rounded-lg shadow-lg xs:border-secondary_blue xs:p-1 max-h-[90vh] overflow-hidden">
        <div class="flex justify-end p-2 border-b border-gray-200">
            <a wire:click="closemodal" class="w-10 h-6 text-secondary_red hover:text-primary_red cursor-pointer flex justify-center">
                <span class="close">&times;</span>
            </a>
        </div>
        <!-- Modal content -->
        <div class="p-4 overflow-y-auto max-h-[80%]">
            <div class="result-upload-{{ $type }} flex justify-center"></div>
        </div>
        <!-- Footer -->
        <div class="flex items-center p-4 border-t border-gray-200">
            <x-jet-secondary-button wire:click="closemodal" type="button">
                {{ __('main.cancel') }}
            </x-jet-secondary-button>
            <x-jet-button wire:click="cropimage" class="ml-3" type="button">
                {{ __('main.crop') }}
            </x-jet-button>
        </div>
    </div>
</div>
