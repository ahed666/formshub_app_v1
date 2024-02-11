<div>
    <div class="grid w-full   mt-2   items-center"  >

        <div class="align-center" >
            <a data-bs-toggle="tooltip"  data-bs-html="true" title="{{ __('This option allows you to switch form (Active) meaning people can submit responses to this form, whether from a shared link or from a connected kiosk, or (Inactive), meaning this form will not be visible to people and responses can not be submitted whether from a shared link or from a connected kiosk.') }}">
                <svg   class="inline-block text-secondary_blue w-[18px] h-[18px]" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"></path>
                </svg>
            </a>
        </div>

        <div class="" >
                <label class="ml-4 relative inline-flex items-center cursor-pointer">

                <input type="checkbox" wire:model="service"  value="$service"  class="sr-only peer"

                >{{ $current_id }}
                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none
                rounded-full peer  peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute
                after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all
                     peer-checked:bg-secondary_blue"></div>

                </label>
        </div>
    </div>
</div>
