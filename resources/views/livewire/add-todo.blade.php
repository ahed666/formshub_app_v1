<div wire:loading.class="disabled opacity-50" wire:target="submit">
    <div wire:loading.class.remove="invisible" wire:target="submit" role="status" class="z-[9999]  w-full h-full  absolute  invisible">
        <svg aria-hidden="true" class="w-8 h-8 top-1/2 left-1/2 mr-2 text-gray-200 animate-spin  fill-secondary_blue" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
            <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
        </svg>
        <span class="sr-only">Loading...</span>
    </div>
    {{-- modal header --}}
    <div class="flex items-center justify-between p-4 border-b rounded-t ">
        <div class="flex items-center">
            <h3 class="text-xl font-semibold text-gray-900 ">
            {{ $edit?__('main.update'): __('main.addtask') }}
            </h3>
            <svg class=" mx-2 w-8 h-8"  viewBox="0 0 48 48" version="1" xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 48 48" fill="#000000">
                <g id="SVGRepo_bgCarrier" stroke-width="0"/>
                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>
                <g id="SVGRepo_iconCarrier"> <path fill="#cfcfcf" d="M5,38V14h38v24c0,2.2-1.8,4-4,4H9C6.8,42,5,40.2,5,38z"/> <path fill="#1277d1" d="M43,10v6H5v-6c0-2.2,1.8-4,4-4h30C41.2,6,43,7.8,43,10z"/> <g fill="#454545"> <circle cx="33" cy="10" r="3"/> <circle cx="15" cy="10" r="3"/> </g> <g fill="#878787"> <path d="M33,3c-1.1,0-2,0.9-2,2v5c0,1.1,0.9,2,2,2s2-0.9,2-2V5C35,3.9,34.1,3,33,3z"/> <path d="M15,3c-1.1,0-2,0.9-2,2v5c0,1.1,0.9,2,2,2s2-0.9,2-2V5C17,3.9,16.1,3,15,3z"/> </g> <g fill="#878787"> <rect x="13" y="20" width="4" height="4"/> <rect x="19" y="20" width="4" height="4"/> <rect x="25" y="20" width="4" height="4"/> <rect x="31" y="20" width="4" height="4"/> <rect x="13" y="26" width="4" height="4"/> <rect x="19" y="26" width="4" height="4"/> <rect x="25" y="26" width="4" height="4"/> <rect x="31" y="26" width="4" height="4"/> <rect x="13" y="32" width="4" height="4"/> <rect x="19" y="32" width="4" height="4"/> <rect x="25" y="32" width="4" height="4"/> <rect x="31" y="32" width="4" height="4"/> </g> </g>
            </svg>
        </div>
        <button wire:click="resetvalue()" type="button"  class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex
            items-center  close" data-dismiss="modal" aria-label="Close">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0
            011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
        </button>
    </div>
     <!-- Modal body -->
    <div  class=" 2xl:max-h-[700px] xs:max-h-[500px]">
        {{-- allow to add =>who users can add this  --}}
    @if($allowaddtodo)
        {{-- allow subscribe =>if subscribe not free  --}}
        @if($accountStatus['status']!='Locked'&&$allowAddToDoSubscribe)
            @if($edit)
                <div class="relative m-4 p-2 xs:m-1 xs:p-1" >
                    <label for="info"
                    class="pointer-events-none  text-secondary_blue font-bold left-3 top-0 mb-0 max-w-[90%] origin-[0_0] truncate pt-[0.37rem] leading-[1.6] t transition-all duration-200 ease-out "
                    >{{ __('main.information') }}
                    </label>
                    <div wire:ignore class="grid grid-cols-12 bg-gray-50 border border-gray-300 text-gray-900 rounded-[0.5rem] p-2">
                        <div class="col-span-6 ">
                         
                            <h1 class=" text-md"  ><span>{{ __('main.createdat') }}</span><span class="text-secondary_blue">{{ \Carbon\Carbon::parse($todoInfo->created_at)->setTimezone('Asia/Dubai')->format('Y-m-d H:i')  }}</span></h1>
                            <h1 class="mt-1 text-md"  ><span>{{ __('main.formtitle') }}</span><span class="text-secondary_blue">{{ $todoInfo->form_title?$todoInfo->form_title:__('Not set') }}</span></h1>
                        </div>
                        <div class="col-span-6">
                            <h1 class="text-md"  ><span>{{ __('main.lastupdate') }}</span><span class="text-secondary_blue">{{\Carbon\Carbon::parse($todoInfo->updated_at)->setTimezone('Asia/Dubai')->format('Y-m-d H:i')  }}</span></h1>
                        </div>
                    </div>


                </div>
            @endif
            <form wire:submit.prevent="save">
                @csrf
                {{-- comments --}}
                <div class="relative m-4 p-2 xs:m-1 xs:p-1" >
                    <label
                    for="exampleFormControlInputText"
                    class="text-md pointer-events-none  text-secondary_blue font-bold left-3 top-0 mb-0 max-w-[90%] origin-[0_0] truncate pt-[0.37rem]
                    leading-[1.6] t transition-all duration-200 ease-out "
                    >{{ __('main.task') }}
                    </label>
                    <textarea wire:model="task"
                    type="text" id="task" maxlength="500"
                    class="w-full h-20   text-sm rounded-lg  block px-2 border-gray-300  focus:border-secondary mr-2
                     focus:ring-secondary "
                    id="exampleFormControlInputText"
                    placeholder="" ></textarea>
                    @error('task') <li class="text-red-400"><span class="text-sm text-red-400 error">{{ $message }}</span></li> @enderror

                </div>
                {{-- user sign --}}
                <div class="grid grid-cols-12 ">
                <div class="{{$edit?"col-span-4 xs:col-span-6":"col-span-6"  }} m-4 p-2 xs:m-1 xs:p-1">
                    <label for="user" class="text-md pointer-events-none   text-secondary_blue font-bold left-3 top-0 mb-0 max-w-[90%] origin-[0_0] truncate pt-[0.37rem]
                    leading-[1.6]  transition-all duration-200 ease-out">{{ __('main.assginedto') }}</label>
                    <select {{ $account_owner->id==Auth::user()->id||$accountRole=="admin"?"":"disabled" }} wire:model="userid"  id="user" name="user"
                         class=" w-full mr-2  h-10  border text-sm
                    rounded-lg  block  px-2 border-gray-300  focus:border-secondary mr-2
                     focus:ring-secondary "   required>
                                <option value="null"  disabled selected >{{ __('main.selectuser') }}</option>
                                <option value="{{ $account_owner->id }}"  >{{ $account_owner->name }}</option>
                                @foreach ($account->users->sortBy('name') as $user)
                                    <option value="{{ $user->id }}" wire:key="user-{{ $user->id}}" >{{ $user->name }}</option>
                                @endforeach
                    </select>
                    @error('userid') <li class="text-red-400"><span class="text-sm text-red-400 error">{{ $message }}</span></li> @enderror
                </div>
                {{-- response priority --}}
                <div class="{{$edit?"col-span-4 xs:col-span-6":"col-span-6"  }} m-4 p-2 xs:m-1 xs:p-1">
                    <label for="priority" class="text-md pointer-events-none   text-secondary_blue font-bold left-3 top-0 mb-0 max-w-[90%] origin-[0_0] truncate pt-[0.37rem]
                    leading-[1.6]  transition-all duration-200 ease-out">{{ __('main.priority') }}</label>
                    <select {{ $account_owner->id==Auth::user()->id||$accountRole=="admin"?"":"disabled" }} wire:model="priority"  id="priority" name="priority"
                        class=" w-full  h-10  border text-sm
                    rounded-lg  bloc  px-2 border-gray-300  focus:border-secondary mr-2
                     focus:ring-secondary "   required>
                                <option value="null"  disabled selected >{{ __('main.selectpriority') }}</option>
                                <option class="bg-green-200" value="Low" wire:key="priority-low"  >{{ __('main.low') }}</option>
                                <option class="bg-yellow-200" value="Medium" wire:key="priority-medium" >{{ __('main.medium') }}</option>
                                <option class="bg-red-200" value="High" wire:key="priority-high" >{{ __('main.high') }}</option>
                    </select>
                    @error('priority') <li class="text-red-400"><span class="text-sm text-red-400 error">{{ $message }}</span></li> @enderror
                </div>
                {{-- response status --}}
                @if($edit)
                <div class="col-span-4 xs:col-span-6 m-4 p-2 xs:m-1 xs:p-1">
                    <label for="status" class="text-md pointer-events-none   text-secondary_blue font-bold left-3 top-0 mb-0 max-w-[90%] origin-[0_0] truncate pt-[0.37rem]
                    leading-[1.6]  transition-all duration-200 ease-out">{{ __('main.status') }}</label>
                    <select  wire:model="status"  id="status" name="status" class=" w-full  h-10   text-sm
                    rounded-lg  block  px-2 border-gray-300  focus:border-secondary mr-2
                     focus:ring-secondary "   required>

                                <option class="bg-red-100" value="Open" wire:key="status-Open"  >{{ __('main.open') }}</option>
                                <option class="bg-yellow-50" value="Pending" wire:key="status-Pending" >{{ __('main.pending') }}</option>
                                <option class="bg-[#d2e8fc]" value="In Progress" wire:key="status-InProgress" >{{ __('main.inprogress') }}</option>
                                <option class="bg-green-100" value="Closed" wire:key="status-Closed" >{{ __('main.closed') }}</option>

                    </select>
                </div>
                @endif
                </div>
                <!-- Modal footer -->
                    <div class="flex justify-between items-center p-6 space-x-2 border-t border-gray-200 rounded-b ">


                        <div  class="flex  items-center ">

                            {{-- <button data-dismiss="modal" aria-label="Close"  type="button"
                            class="ml-1 mr-1 text-white bg-red-400 hover:bg-red-500  font-medium rounded-lg
                            text-sm px-5 py-2.5 text-center   cancel">cancel</button> --}}
                            <x-jet-secondary-button wire:click="resetvalue()" data-dismiss="modal" aria-label="Close"  type="button"  wire:loading.attr="disabled">
                                {{ __('main.cancel') }}
                            </x-jet-secondary-button>
                            <x-jet-button class="ml-3" type="submit"   wire:loading.attr="disabled">
                                {{ __('main.save') }}
                            </x-jet-button>
                            {{-- <button    type="submit"  class="ml-1 mr-1 text-white bg-secondary_blue   hover:bg-secondary_1 font-medium rounded-lg
                            text-sm px-5 py-2.5 text-center ">save</button> --}}
                        </div>
                        @error('response_id') <li class="text-red-400"><span class="text-sm text-red-400 error">{{ $message }}</span></li> @enderror
                    </div>

            </form>
        {{-- if account locked --}}
        @elseif($accountStatus['status']=='Locked')
            <div class="  flex items-center justify-center">
                <div class="w-auto max-w-lg h-auto p-14 bg-white text-center rounded-lg">
                <h1 class="">{{ ('This service has been locked due to subscription expiry
                    To continue using this feature please manage your subscription
                    ') }}
                    <a   href="{{ route('subscribe','upgrade') }}" target="_blank" class="text-secondary_blue rounded-xl    hover:cursor-pointer  p-2">
                        {{ __(' here') }}
                    </a>
                </h1>
                <div class="flex justify-center items-center">
                    <!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">
                    <svg class="w-14 h-14" fill="#545454" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="800px" height="800px" viewBox="0 0 100 100" enable-background="new 0 0 100 100" xml:space="preserve" stroke="#545454">
                    <g id="SVGRepo_bgCarrier" stroke-width="0"/>
                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>
                    <g id="SVGRepo_iconCarrier"> <g> <path d="M33,85h34c5.514,0,10-4.605,10-10.119v-22c0-5.514-4.486-10-10-10v-8.167C67,25.432,59.545,18,50.382,18h-0.334 C40.647,18,33,25.432,33,34.714v8.167c-5.514,0-10,4.486-10,10v22C23,80.395,27.486,85,33,85z M37,34.714 C37,27.638,42.854,22,50.048,22h0.334C57.457,22,63,27.518,63,34.714V43H37V34.714z M73,75c0,3.313-2.687,6-6,6H33 c-3.313,0-6-2.687-6-6V53c0-3.313,2.687-6,6-6h34c3.313,0,6,2.687,6,6V75z"/> <path d="M47,66.785v4.221C47,72.594,48.287,74,49.875,74h0.25C51.713,74,53,72.594,53,71.006v-4.359 c1.798-1.068,3.007-3.023,3.007-5.266c0-3.383-2.742-6.125-6.125-6.125s-6.125,2.742-6.125,6.125 C43.757,63.722,45.07,65.754,47,66.785z"/> </g> </g>
                    </svg>
                </div>
                <h1 class="text-red-500 text-sm">{{ __('Avoid your account being permanently suspended') }} <a href="" class="text-secondary_blue hover:text-secondary_1 underline">{{ __('read more') }}</a></h1>
                </div>
            </div>
        {{-- if account have free plan --}}
        @elseif(!$allowAddToDoSubscribe)
            <div class="flex justify-center items-center p-10 ">
                <h1 class="">{{ ('This feature is not available on this subscription
                    To access this feature, Upgrade your account
                    ') }}
                    <a   href="{{ route('subscribe','upgrade') }}" target="_blank" class=" text-secondary_blue rounded-xl    hover:cursor-pointer  p-2">
                        {{ __(' here') }}
                    </a>
                </h1>
            </div>


        @endif
    @else
            {{-- body --}}
            <div class="mt-4 mb-4 flex justify-center items-center">
                <span>{{ __('You do not have permission to do this action') }}</span>
            </div>
            {{-- footer --}}
            <x-jet-secondary-button wire:click="resetvalue()" data-dismiss="modal" aria-label="Close"  type="button"  wire:loading.attr="disabled">
                {{ __('main.cancel') }}
            </x-jet-secondary-button>
    @endif


    </div>
</div>
