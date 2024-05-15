


<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link  rel="stylesheet" href="{{ asset('styles/bootstrap.min.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">

    @include('admin.includes.head')

</head>
<body class="font-sans antialiased">
    <input type="hidden" id="message" value="{{ session('message') }}">

    <div class="min-h-screen max-h-fit bg-gray-100 ">
        <div class=" grid 2xl:grid-cols-8 xl:grid-cols-8 lg:grid-cols-8 md:grid-cols-1 sm:grid-cols-1 xs:grid-cols-1  gap-1 xs:gap-0 md:gap-0 sm:gap-0">
            <div class="z-[100]  2xl:col-span-1 xl:col-span-1 lg:col-span-1 md:col-span-1 sm:col-span-1 xs:col-span-1 lg:mr-2 xl:mr-2 sm:mb-2 md:row-span-2 ">
                @include('admin.layouts.navigation')
            </div>

            <div class="2xl:col-span-7 xl:col-span-7 lg:col-span-7 md:col-span-7 sm:col-span-7 xs:col-span-7    pt-2 pl-[14px] pr-[14px] pb-2  xs:px-0   ">
                  {{-- admins info --}}
                  <div class="flex justify-center items-center bg-white text-md rounded-[0.5rem] p-4">
                          <h1>{{ __('Admins Settings') }}</h1>
                  </div>
                <table class="admins_table table-fixed w-full  rounded-lg mt-4  " >
                    {{-- head of table --}}
                    <thead class="h-14">
                    <tr class="border-b-[1px] border-t-[1px] p-1  bg-gray-600 text-white ">

                        <th   class="sticky top-0 px-4 py-2 z-50 bg-gray-600 ml-1 mr-1 w-1/5 xs:text-xs text-sm text-center">ID</th>
                        <th   class="sticky top-0 px-4  py-2 bg-gray-600 ml-1 mr-1 w-1/5 xs:text-xs text-sm text-center">Name</th>
                        <th  class="sticky top-0 px-4 py-2 bg-gray-600 ml-1 mr-1 w-1/5 xs:text-xs text-sm text-center">Email</th>
                        <th  class="sticky top-0 px-4 py-2 bg-gray-600 ml-1 mr-1 w-1/5 xs:text-xs text-sm text-center">Role</th>
                        <th  class="sticky top-0 px-4 py-2 bg-gray-600 ml-1 mr-1 w-1/5 xs:text-xs text-sm text-center">Options</th>

                    </tr>
                    </thead>
                    <tbody class="bg-white " >
                        @foreach ($admins as $i   => $admin )
                        <tr class="h-10 min-h-10 max-h-10 w-full bg-gray-50 p-1 border-b-[1px] border-gray-300">
                        <td class="text-center">
                            <span  class="xs:text-xs text-sm ">{{ $admin->id }}</span>
                        </td>
                        <td class="text-center overflow-hidden"><span  class="xs:text-xs text-sm   text-left">{{ $admin->name }}</span></td>
                        <td class="text-center overflow-hidden"><span class=" xs:text-xs text-sm text-center">{{  $admin->email }}</span></td>

                        <td class="text-center overflow-hidden"><span  class="xs:text-xs text-sm text-center">{{  $admin->role }}</span></td>


                            <td class="text-center">
                                <div class="flex justify-center items-center">
                                    <span class="text-center">

                                        <svg data-toggle="modal" data-target="#show_editadmin" onclick="EditAdmin({{$i}})" class="text-svg_primary hover:text-secondary_blue hover:cursor-pointer h-6 w-6 " viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g id="SVGRepo_bgCarrier" stroke-width="0"/>
                                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>
                                            <g id="SVGRepo_iconCarrier">
                                                <path d="M12 3.99997H6C4.89543 3.99997 4 4.8954 4 5.99997V18C4 19.1045 4.89543 20 6 20H18C19.1046 20 20 19.1045 20 18V12M18.4142 8.41417L19.5 7.32842C20.281 6.54737 20.281 5.28104 19.5 4.5C18.7189 3.71895 17.4526 3.71895 16.6715 4.50001L15.5858 5.58575M18.4142 8.41417L12.3779 14.4505C12.0987 14.7297 11.7431 14.9201 11.356 14.9975L8.41422 15.5858L9.00257 12.6441C9.08001 12.2569 9.27032 11.9013 9.54951 11.6221L15.5858 5.58575M18.4142 8.41417L15.5858 5.58575"  stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke="currentColor" /> </g>
                                        </svg>
                                    </span>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{-- end of admins info --}}
                {{-- sessions --}}
                <div class="flex justify-center items-center bg-white text-md mt-4 rounded-[0.5rem] p-4">
                    <h1>{{ __('Admins Sessions') }}</h1>
                </div>
                @if (count($sessions) > 0)
                    <div class="mt-5 space-y-6 grid items-center grid-cols-12 gap-2 mb-4 ">
                        <!-- Other Browser Sessions -->
                        @foreach ($sessions as $session)
                            <div class="col-span-6 xs:col-span-12 flex justify-between items-center border border-black p-2 rounded-[0.5rem] mt-0">
                                <div class="flex items-center">
                                    <div>
                                        @if ($session->agent['is_desktop'])
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-gray-500">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 17.25v1.007a3 3 0 01-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0115 18.257V17.25m6-12V15a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 15V5.25m18 0A2.25 2.25 0 0018.75 3H5.25A2.25 2.25 0 003 5.25m18 0V12a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 12V5.25" />
                                            </svg>
                                        @else
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-gray-500">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 1.5H8.25A2.25 2.25 0 006 3.75v16.5a2.25 2.25 0 002.25 2.25h7.5A2.25 2.25 0 0018 20.25V3.75a2.25 2.25 0 00-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 18.75h3" />
                                            </svg>
                                        @endif
                                    </div>

                                    <div class="ml-3">
                                        <div class="text-sm text-gray-600">
                                            {{ $session->agent['platform'] ? $session->agent['platform'] : __('Unknown') }} - {{ $session->agent['browser'] ? $session->agent['browser'] : __('Unknown') }}
                                        </div>

                                        <div>
                                            <div class="text-xs text-gray-500">
                                                {{ $session->ip_address }},

                                                @if ($session->is_current_device)
                                                    <span class="text-green-500 font-semibold">{{ __('This device') }}</span>
                                                @else
                                                    {{ __('Last active') }} {{ $session->last_active }}
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex text-sm text-center text-secondary_blue ml-3">
                                        <span>{{ $session->admin_name }}{{ __(' (') }} <span class="text-xs">{{ $session->admin_role }}</span> {{ __(' )') }}</span>
                                    </div>
                                </div>
                                @if ($session->is_current_device==false)
                                <div>
                                    <form method="POST" action="{{ route('admin.adminLogout',["id"=>$session->id]) }}">
                                        @csrf
                                        <x-jet-button type="submit" wire:loading.attr="disabled">
                                            {{ __('Log Out ') }}
                                        </x-jet-button>
                                    </form>
                                </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endif
                {{-- end of sessions --}}
                {{-- App Setting --}}
                <div class="flex justify-center items-center bg-white text-md rounded-[0.5rem] p-4 mt-2">
                    <h1>{{ __('App Settings') }}</h1>
                </div>
                {{-- subscriptions info --}}
                <div class="grid grid-cols-3 gap-2 mt-4">
                    {{-- free --}}
                    @foreach ($allPlans as $key => $plan )


                    <div class="col-span-1 xs:col-span-3 ">
                        <div class="flex justify-start items-center">{{ $key }}</div>
                        <div class="border-[1px] border-black rounded-[0.5rem] p-4">
                            <form method="POST" action="{{ route('admin.saveplan') }}">
                                @csrf
                                <input value="{{ $plan->id }}" type="hidden" name="planid">
                                {{-- price --}}
                                <div  class="flex justify-between items-center space-x-10 my-1">
                                    <label  class="text-secondary_blue font-bold text-sm xs:ml-2 xs:mr-2 w-auto whitespace-nowrap " for="price">
                                        {{ __('Price') }}
                                    </label>
                                    <input  value="{{ $plan->price }}" type="number"  min="0"  pattern="\d*" minlength="7" maxlength="7"  id="price" name="price"
                                    class="  w-1/4  mr-2  h-10 bg-gray-50   text-gray-900 text-sm rounded-lg
                                    block  px-2 border-gray-300  focus:border-secondary
                                     focus:ring-secondary"     required>
                                </div>
                                {{-- num_forms --}}
                                <div  class="flex justify-between items-center space-x-10 my-1">
                                    <label  class="text-secondary_blue font-bold text-sm xs:ml-2 xs:mr-2 w-auto whitespace-nowrap " for="num_forms">
                                        {{ __('Max. Forms') }}
                                    </label>
                                    <input  value="{{ $plan->num_forms }}" type="number"  min="0"  pattern="\d*" minlength="7" maxlength="7"  id="num_forms" name="num_forms"
                                    class="  w-1/4  mr-2  h-10 bg-gray-50   text-gray-900 text-sm rounded-lg
                                    block  px-2 border-gray-300  focus:border-secondary
                                     focus:ring-secondary  "     required>
                                </div>
                                {{-- num_questions --}}
                                <div  class="flex justify-between items-center space-x-10 my-1 ">
                                    <label  class="text-secondary_blue font-bold text-sm xs:ml-2 xs:mr-2 w-auto whitespace-nowrap " for="num_questions">
                                        {{ __('Max. Questions / Forms') }}
                                    </label>
                                    <input  value="{{ $plan->num_questions }}" type="number"  min="0"  pattern="\d*" minlength="7" maxlength="7"  id="num_questions" name="num_questions"
                                    class="  w-1/4  mr-2  h-10 bg-gray-50   text-gray-900 text-sm rounded-lg
                                    block  px-2 border-gray-300  focus:border-secondary
                                     focus:ring-secondary  "     required>
                                </div>
                                 {{-- num_media_items --}}
                                 <div  class="flex justify-between items-center space-x-10 my-1 ">
                                    <label  class="text-secondary_blue font-bold text-sm xs:ml-2 xs:mr-2 w-auto whitespace-nowrap " for="num_media_items">
                                        {{ __('Max. Media Items / Forms') }}
                                    </label>
                                    <input  value="{{ $plan->num_media_items }}" type="number"  min="0"  pattern="\d*" minlength="7" maxlength="7"  id="num_media_items" name="num_media_items"
                                    class="  w-1/4  mr-2  h-10 bg-gray-50   text-gray-900 text-sm rounded-lg
                                    block  px-2 border-gray-300  focus:border-secondary
                                     focus:ring-secondary  "     required>
                                </div>
                                {{-- num_responses --}}
                                <div  class="flex justify-between items-center space-x-10 my-1">
                                    <label  class="text-secondary_blue font-bold text-sm xs:ml-2 xs:mr-2 w-auto whitespace-nowrap " for="num_responses">
                                        {{ __('Max. Responses') }}
                                    </label>
                                    <input  value="{{ $plan->num_responses }}" type="number" min="0"    pattern="\d*" minlength="7" maxlength="7"  id="num_responses" name="num_responses"
                                    class="  w-1/4  mr-2  h-10 bg-gray-50   text-gray-900 text-sm rounded-lg
                                    block  px-2 border-gray-300  focus:border-secondary
                                     focus:ring-secondary  "     required>
                                </div>
                                {{-- Num Kiosks --}}
                                <div  class="flex justify-between items-center space-x-10 my-1">
                                    <label  class="text-secondary_blue font-bold text-sm xs:ml-2 xs:mr-2 w-auto whitespace-nowrap " for="num_kiosks">
                                        {{ __('Max. Kiosks') }}
                                    </label>
                                    <input  value="{{ $plan->num_kiosks }}" type="number" min="0" max="50"   pattern="\d*" minlength="7" maxlength="7"  id="num_kiosks" name="num_kiosks"
                                    class="  w-1/4  mr-2  h-10 bg-gray-50   text-gray-900 text-sm rounded-lg
                                    block  px-2 border-gray-300  focus:border-secondary
                                     focus:ring-secondary  "     required>
                                </div>
                                {{-- account_members --}}
                                <div  class="flex justify-between items-center space-x-10 my-1">
                                    <label  class="text-secondary_blue font-bold text-sm xs:ml-2 xs:mr-2 w-auto whitespace-nowrap " for="account_members">
                                        {{ __('Max. Account Members') }}
                                    </label>
                                    <input  value="{{ $plan->account_members }}" type="number" min="0" max="5"   pattern="\d*" minlength="7" maxlength="7"  id="account_members" name="account_members"
                                    class="  w-1/4  mr-2  h-10 bg-gray-50   text-gray-900 text-sm rounded-lg
                                    block  px-2 border-gray-300  focus:border-secondary
                                     focus:ring-secondary  "     required>
                                </div>
                                {{-- todo --}}
                                <div class=" flex justify-between items-center space-x-10 my-1 "  >
                                    <label  class="text-secondary_blue font-bold text-sm xs:ml-2 xs:mr-2 w-auto whitespace-nowrap " for="todo">
                                        {{ __('To Do Available') }}
                                    </label>
                                    <select  id="todo" name="todo" class=" w-1/4  h-10   text-sm rounded-lg
                                      px-2  border-gray-300  focus:border-secondary mr-2 focus:ring-secondary "  >
                                      <option {{ $plan->todo == true ? 'selected' : '' }} value="true">{{ __('Yes') }}</option>
                                      <option {{ $plan->todo == false ? 'selected' : '' }} value="false">{{ __('No') }}</option>
                                    </select>
                                </div>
                                {{-- Sign PDF Available --}}
                                <div class=" flex justify-between items-center space-x-10 my-1 "  >
                                    <label  class="text-secondary_blue font-bold text-sm xs:ml-2 xs:mr-2 w-auto whitespace-nowrap " for="signpdf">
                                        {{ __('Sign PDF Available') }}
                                    </label>
                                    <select  id="signpdf" name="signpdf" class=" w-1/4  h-10   text-sm rounded-lg
                                      px-2  border-gray-300  focus:border-secondary mr-2 focus:ring-secondary "  >
                                      <option {{ $plan->signpdf == true ? 'selected' : '' }} value="true">{{ __('Yes') }}</option>
                                      <option {{ $plan->signpdf == false ? 'selected' : '' }} value="false">{{ __('No') }}</option>
                                    </select>
                                </div>
                                {{-- professional_dashboard_statistics =>disabled --}}
                                <div class=" flex justify-between items-center space-x-10 my-1 "  >
                                    <label  class="text-gray-300 font-bold text-sm xs:ml-2 xs:mr-2 w-auto whitespace-nowrap " for="professional_dashboard_statistics">
                                        {{ __('Professional Dashboard & Statistics') }}
                                    </label>
                                    <select   id="professional_dashboard_statistics" name="professional_dashboard_statistics" class=" w-1/4  h-10   text-sm rounded-lg
                                      px-2  border-gray-300  focus:border-secondary mr-2 focus:ring-secondary "  >
                                      <option {{ $plan->professional_dashboard_statistics == true ? 'selected' : '' }} value="true">{{ __('Yes') }}</option>
                                      <option {{ $plan->professional_dashboard_statistics == false ? 'selected' : '' }} value="false">{{ __('No') }}</option>
                                    </select>
                                </div>
                                {{-- pro_questions => disabled --}}
                                <div class=" flex justify-between items-center space-x-10 my-1 "  >
                                    <label  class="text-gray-300 font-bold text-sm xs:ml-2 xs:mr-2 w-auto whitespace-nowrap " for="pro_questions">
                                        {{ __('Pro Questions Types') }}
                                    </label>
                                    <select   id="pro_questions" name="pro_questions" class=" w-1/4  h-10   text-sm rounded-lg
                                      px-2  border-gray-300  focus:border-secondary mr-2
                                       focus:ring-secondary "  >
                                      <option {{ $plan->pro_questions == true ? 'selected' : '' }} value="true">{{ __('Yes') }}</option>
                                      <option {{ $plan->pro_questions == false ? 'selected' : '' }} value="false">{{ __('No') }}</option>
                                    </select>
                                </div>
                                {{-- custom_form  --}}
                                <div class=" flex justify-between items-center space-x-10 my-1 "  >
                                    <label  class="text-secondary_blue font-bold text-sm xs:ml-2 xs:mr-2 w-auto whitespace-nowrap " for="custom_form">
                                        {{ __('Custom Form Logo') }}
                                    </label>
                                    <select  id="custom_form" name="custom_form" class=" w-1/4  h-10   text-sm rounded-lg
                                      px-2  border-gray-300  focus:border-secondary mr-2
                                       focus:ring-secondary "  >
                                      <option {{ $plan->custom_form == true ? 'selected' : '' }} value="true">{{ __('Yes') }}</option>
                                      <option {{ $plan->custom_form == false ? 'selected' : '' }} value="false">{{ __('No') }}</option>
                                    </select>
                                </div>
                                {{-- form terms --}}
                                <div class=" flex justify-between items-center space-x-10 my-1 "  >
                                    <label  class="text-secondary_blue font-bold text-sm xs:ml-2 xs:mr-2 w-auto whitespace-nowrap " for="form_terms">
                                        {{ __('Form Terms Available') }}
                                    </label>
                                    <select  id="form_terms" name="form_terms" class=" w-1/4  h-10   text-sm rounded-lg
                                        px-2  border-gray-300  focus:border-secondary mr-2
                                         focus:ring-secondary "  >
                                        <option {{ $plan->form_terms == true ? 'selected' : '' }} value="true">{{ __('Yes') }}</option>
                                      <option {{ $plan->form_terms == false ? 'selected' : '' }} value="false">{{ __('No') }}</option>
                                    </select>
                                </div>
                                {{-- export --}}
                                <div class=" flex justify-between items-center space-x-10 my-1 "  >
                                    <label  class="text-secondary_blue font-bold text-sm xs:ml-2 xs:mr-2 w-auto whitespace-nowrap " for="export">
                                        {{ __('Export Statistics Reports') }}
                                    </label>
                                    <select  id="export" name="export" class=" w-1/4  h-10   text-sm rounded-lg
                                        px-2  border-gray-300  focus:border-secondary mr-2
                                         focus:ring-secondary "  >
                                        <option {{ $plan->export == true ? 'selected' : '' }} value="true">{{ __('Yes') }}</option>
                                        <option {{ $plan->export == false ? 'selected' : '' }} value="false">{{ __('No') }}</option>
                                    </select>
                                </div>
                                {{--multi_languages => disabled --}}
                                <div class=" flex justify-between items-center space-x-10 my-1 "  >
                                    <label  class="text-gray-300 font-bold text-sm xs:ml-2 xs:mr-2 w-auto whitespace-nowrap " for="multi_languages">
                                        {{ __('Multi-Languages Form') }}
                                    </label>
                                    <select   id="multi_languages" name="multi_languages" class=" w-1/4  h-10   text-sm rounded-lg
                                        px-2  border-gray-300  focus:border-secondary mr-2 focus:ring-secondary "  >
                                        <option {{ $plan->multi_languages == true ? 'selected' : '' }} value="true">{{ __('Yes') }}</option>
                                        <option {{ $plan->multi_languages == false ? 'selected' : '' }} value="false">{{ __('No') }}</option>
                                    </select>
                                </div>
                                {{-- valid period --}}
                                <div  class="flex justify-between items-center space-x-10 my-1">
                                    <label  class="text-secondary_blue font-bold text-sm xs:ml-2 xs:mr-2 w-auto whitespace-nowrap " for="valid_period">
                                        {{ __('Valid Period\M') }}
                                    </label>
                                    <input  value="{{ $plan->valid_period }}" type="number" min="0"    pattern="\d*" minlength="7" maxlength="7"  id="valid_period" name="valid_period"
                                    class="  w-1/4  mr-2  h-10 bg-gray-50   text-gray-900 text-sm rounded-lg
                                    block  px-2 border-gray-300  focus:border-secondary
                                     focus:ring-secondary  "     required>
                                </div>
                                {{-- grace_period --}}
                                <div  class="flex justify-between items-center space-x-10 my-1">
                                    <label  class="text-secondary_blue font-bold text-sm xs:ml-2 xs:mr-2 w-auto whitespace-nowrap " for="grace_period">
                                        {{ __('Grace Period\M') }}
                                    </label>
                                    <input  value="{{ $plan->grace_period }}" type="number" min="0"   pattern="\d*" minlength="7" maxlength="7"  id="grace_period" name="grace_period"
                                    class="  w-1/4  mr-2  h-10 bg-gray-50   text-gray-900 text-sm rounded-lg
                                    block  px-2 border-gray-300  focus:border-secondary
                                     focus:ring-secondary  "     required>
                                </div>
                                {{-- locked_period --}}
                                <div  class="flex justify-between items-center space-x-10 my-1">
                                    <label  class="text-secondary_blue font-bold text-sm xs:ml-2 xs:mr-2 w-auto whitespace-nowrap " for="locked_period">
                                        {{ __('Locked Period\M') }}
                                    </label>
                                    <input  value="{{ $plan->locked_period }}" type="number" min="0"   pattern="\d*" minlength="7" maxlength="7"  id="locked_period" name="locked_period"
                                    class="  w-1/4  mr-2  h-10 bg-gray-50   text-gray-900 text-sm rounded-lg
                                    block  px-2 border-gray-300  focus:border-secondary
                                     focus:ring-secondary "     required>
                                </div>



                                <div class="flex justify-end items-center mt-4">
                                    <x-jet-button class="ml-3" type="submit"   >
                                        {{ __('Save') }}
                                    </x-jet-button>
                                </div>
                            </form>
                        </div>
                    </div>
                    @endforeach


                    <div class="col-span-1 xs:col-span-3 ">
                        {{-- responses Category --}}
                        <div class="max-h-[200px]">
                            <div  class="flex justify-start items-center">{{ __('Additional responses price') }}</div>
                            <div class="border-[1px] border-black rounded-[0.5rem] p-4">
                                <h1>{{ __('Edit:') }}</h1>
                                <div class="flex justify-between items-center">
                                    <select  id="responsesCategories_select" name="responsesCategories_select" class=" w-full  h-10   text-sm rounded-lg
                                    px-2  border-gray-300  focus:border-secondary mr-2
                                     focus:ring-secondary "  >
                                        @foreach($responsesCategories as $key => $category)
                                            <option value="{{ $key }}">{{ $category->num }}{{ __(' responses with price:') }}{{ $category->price }}</option>
                                        @endforeach
                                </select>
                                <x-jet-button onclick="ShowFormEdit()" class="ml-3" type="button"   >
                                    {{ __('Edit') }}
                                </x-jet-button>
                                </div>
                                <form id="editresponsescategories_form" method="POST" action="{{ route('admin.saveresponsescategories') }}" class="hidden justify-between items-center mt-2">
                                    @csrf
                                    <input type="hidden" id="cat_id" name="cat_id">
                                    <input   type="number"  min="0"  pattern="\d*"   id="num_edit" name="num_edit"
                                        class="  w-1/4  mr-2  h-10 bg-gray-50   text-gray-900 text-sm rounded-lg
                                        block  px-2 border-gray-300  focus:border-secondary
                                         focus:ring-secondary  "     required>
                                    <h1>{{ __(' responses with price:') }}</h1>
                                    <input   type="number"  min="0"  pattern="\d*"   id="price_edit" name="price_edit"
                                    class="  w-1/4  mr-2  h-10 bg-gray-50   text-gray-900 text-sm rounded-lg
                                    block  px-2 border-gray-300  focus:border-secondary
                                     focus:ring-secondary  "     required>
                                    <x-jet-button class="ml-3" type="submit"   >
                                        {{ __('Save') }}
                                    </x-jet-button>
                                </form>
                            </div>
                        </div>
                        {{-- account status edit --}}
                        <div class="mt-10">
                            <div  class="flex justify-start items-center">{{ __('Accounts') }} <span class="text-xs">{{ __('(change status of account)') }}</span> </div>
                            <div class="border-[1px] border-black rounded-[0.5rem] p-4">
                                <div class="flex justify-between items-center">
                                    <input   type="number"  min="0"  pattern="\d*"   id="idaccount_check" name="idaccount_check"
                                        class="  w-1/4  mr-2  h-10 bg-gray-50   text-gray-900 text-sm rounded-lg
                                        block  px-2 border-gray-300  focus:border-secondary
                                         focus:ring-secondary  "     required>
                                        <x-jet-button onclick="ckeckAccounts()" class="ml-3" type="button"   >
                                            {{ __('Check') }}
                                        </x-jet-button>
                                </div>
                                <div id="check_result" >

                                </div>
                            </div>
                        </div>
                        {{-- export accounts --}}
                        <div class="flex justify-between items-center mt-10 border-[1px] border-black rounded-[0.5rem] p-4">
                           <span>{{ __('Export Accounts') }}</span>
                           <x-jet-button type="button" onclick="getAccounts()"  class="">export</x-jet-button>

                        </div>
                        {{-- clients --}}
                        <div class="mt-10">
                            <div  class="flex justify-between items-center mb-2">{{ __('Clients') }}
                                <x-jet-button class="ml-3" data-toggle="modal" data-target="#show_client"  type="button"   >
                                    {{ __('Add new') }}
                                </x-jet-button>
                            </div>
                            <div class="border-[1px] border-black rounded-[0.5rem] p-4 overflow-hidden">
                                <div class="owl-carousel owl-theme client-logo " id="client-logo">
                                    @foreach ($clients as $client)
                                    <div class="item mx-1  ">
                                      <img src="{{ asset($client->client_logo) }}" class="w-[100px] h-[100px] object-contain" alt="client-logo">

                                        <div class="flex justify-center items-center">
                                            <svg onclick="DeleteClient({{ $client->id }})"  class="h-6 w-6 text-svg_primary hover:text-primary_red focus:text-primary_red"  viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <g id="SVGRepo_bgCarrier" stroke-width="0"/>
                                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>
                                                <g id="SVGRepo_iconCarrier"> <path d="M10 11V17" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/> <path d="M14 11V17" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/> <path d="M4 7H20" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/> <path d="M6 7H12H18V18C18 19.6569 16.6569 21 15 21H9C7.34315 21 6 19.6569 6 18V7Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/> <path d="M9 5C9 3.89543 9.89543 3 11 3H13C14.1046 3 15 3.89543 15 5V7H9V5Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/> </g>
                                            </svg>
                                        </div>
                                  </div>
                                    @endforeach
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            {{--end subscriptions info --}}
                {{-- promo codes --}}
                <div class="flex justify-between items-center bg-white text-md rounded-[0.5rem] p-2 mt-2">
                    <h1>{{ __('Promotion Codes') }}</h1>
                    <x-jet-button class="ml-3" data-toggle="modal" data-target="#show_promocode"  type="button"   >
                        {{ __('Add new') }}
                    </x-jet-button>
                </div>
                <div class="max-h-[400px] overflow-y-auto">
                    <table class="admins_table table-fixed w-full  rounded-lg mt-4  " >
                        {{-- head of table --}}
                        <thead class="h-14">
                        <tr class="border-b-[1px] border-t-[1px] p-1  bg-gray-600 text-white ">

                            <th   class="sticky top-0 px-4 py-2 z-50 bg-gray-600 ml-1 mr-1 w-1/5 xs:text-xs text-sm text-center">Code</th>
                            <th   class="sticky top-0 px-4  py-2 bg-gray-600 ml-1 mr-1 w-1/5 xs:text-xs text-sm text-center">For</th>
                            <th  class="sticky top-0 px-4 py-2 bg-gray-600 ml-1 mr-1 w-1/5 xs:text-xs text-sm text-center">Discount Value</th>
                            <th  class="sticky top-0 px-4 py-2 bg-gray-600 ml-1 mr-1 w-1/5 xs:text-xs text-sm text-center">Valid</th>
                            <th  class="sticky top-0 px-4 py-2 bg-gray-600 ml-1 mr-1 w-1/5 xs:text-xs text-sm text-center">Accessibility</th>
                            <th  class="sticky top-0 px-4 py-2 bg-gray-600 ml-1 mr-1 w-1/5 xs:text-xs text-sm text-center">How many used</th>

                            <th  class="sticky top-0 px-4 py-2 bg-gray-600 ml-1 mr-1 w-1/5 xs:text-xs text-sm text-center">Note</th>

                            <th  class="sticky top-0 px-4 py-2 bg-gray-600 ml-1 mr-1 w-1/5 xs:text-xs text-sm text-center">Options</th>

                        </tr>
                        </thead>
                        <tbody class="bg-white " >
                            @foreach($promotionCodes as $key => $promoCode)
                                @php
                                    $typeUse = '';
                                                switch ($promoCode->use_type) {
                                                    case 'upgrade':
                                                        $typeUse = 'Upgrade';
                                                        break;
                                                    case 'renew':
                                                        $typeUse = 'Renew';
                                                        break;
                                                    case 'buyresponses':
                                                        $typeUse = 'Buy Responses';
                                                        break;
                                                    default:
                                                        $typeUse = 'Unknown';
                                                        break;
                                                }
                                                $validStatus = $promoCode->valid ? 'Valid' : 'Not Valid';
                                             $publicStatus = $promoCode->public ? 'Public' : 'Private';
                                @endphp
                            <tr class="h-10 min-h-10 max-h-10 w-full bg-gray-50 p-1 border-b-[1px] border-gray-300">
                            <td class="text-center">
                                <span  class="xs:text-xs text-sm ">{{ $promoCode->code }}</span>
                            </td>
                            <td class="text-center overflow-hidden"><span  class="xs:text-xs text-sm   text-left">{{ $typeUse }}</span></td>
                            <td class="text-center overflow-hidden"><span class=" xs:text-xs text-sm text-center">{{  $promoCode->discount_value }}</span></td>

                            <td class="text-center overflow-hidden"><span  class="xs:text-xs text-sm text-center">{{  $validStatus }}</span></td>
                            <td class="text-center overflow-hidden"><span  class="xs:text-xs text-sm text-center">{{  $publicStatus }}</span></td>
                            <td class="text-center overflow-hidden"><span  class="xs:text-xs text-sm text-center">{{  $promoCode->used }}</span></td>
                            <td class="text-center overflow-hidden"><span  class="xs:text-xs text-sm text-center">{{  $promoCode->note }}</span></td>


                                <td class="text-center">
                                    <div class="flex justify-center space-x-2 items-center">
                                        <div class="text-center">

                                            <svg data-toggle="modal" data-target="#show_promocode" onclick="EditPromoCode({{$key}})" class="text-svg_primary hover:text-secondary_blue hover:cursor-pointer h-6 w-6 " viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <g id="SVGRepo_bgCarrier" stroke-width="0"/>
                                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>
                                                <g id="SVGRepo_iconCarrier">
                                                    <path d="M12 3.99997H6C4.89543 3.99997 4 4.8954 4 5.99997V18C4 19.1045 4.89543 20 6 20H18C19.1046 20 20 19.1045 20 18V12M18.4142 8.41417L19.5 7.32842C20.281 6.54737 20.281 5.28104 19.5 4.5C18.7189 3.71895 17.4526 3.71895 16.6715 4.50001L15.5858 5.58575M18.4142 8.41417L12.3779 14.4505C12.0987 14.7297 11.7431 14.9201 11.356 14.9975L8.41422 15.5858L9.00257 12.6441C9.08001 12.2569 9.27032 11.9013 9.54951 11.6221L15.5858 5.58575M18.4142 8.41417L15.5858 5.58575"  stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke="currentColor" /> </g>
                                            </svg>
                                        </div>
                                        <div class="text-center">


                                            <!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">
                                            <!-- Uploaded to: SVG Repo, www.svgrepo.com, Transformed by: SVG Repo Mixer Tools -->
                                            <svg onclick="DeletePromoCode({{ $promoCode->id }})"  class="h-6 w-6 text-svg_primary hover:text-primary_red focus:text-primary_red"  viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g id="SVGRepo_bgCarrier" stroke-width="0"/>
                                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>
                                            <g id="SVGRepo_iconCarrier"> <path d="M10 11V17" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/> <path d="M14 11V17" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/> <path d="M4 7H20" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/> <path d="M6 7H12H18V18C18 19.6569 16.6569 21 15 21H9C7.34315 21 6 19.6569 6 18V7Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/> <path d="M9 5C9 3.89543 9.89543 3 11 3H13C14.1046 3 15 3.89543 15 5V7H9V5Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/> </g>
                                            </svg>


                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

               {{-- end of promo code --}}

               {{-- devices --}}
               <div class="flex justify-between items-center bg-white text-md rounded-[0.5rem] p-2 mt-2">
                <h1>{{ __('Devices') }}</h1>
                <x-jet-button class="ml-3" data-toggle="modal" data-target="#show_deivce"  type="button"   >
                    {{ __('Add new') }}
                </x-jet-button>
                </div>
                <div class="max-h-[400px] overflow-y-auto">
                    <table class="admins_table table-fixed w-full  rounded-lg mt-4  " >
                        {{-- head of table --}}
                        <thead class="h-14">
                        <tr class="border-b-[1px] border-t-[1px] p-1  bg-gray-600 text-white ">

                            <th   class="sticky top-0 px-4 py-2 z-50 bg-gray-600 ml-1 mr-1 w-1/5 xs:text-xs text-sm text-center">Name</th>
                            <th   class="sticky top-0 px-4  py-2 bg-gray-600 ml-1 mr-1 w-1/5 xs:text-xs text-sm text-center">Device Model</th>
                            <th  class="sticky top-0 px-4 py-2 bg-gray-600 ml-1 mr-1 w-1/5 xs:text-xs text-sm text-center">Price Before</th>
                            <th  class="sticky top-0 px-4 py-2 bg-gray-600 ml-1 mr-1 w-1/5 xs:text-xs text-sm text-center">Price Now</th>
                            <th  class="sticky top-0 px-4 py-2 bg-gray-600 ml-1 mr-1 w-1/5 xs:text-xs text-sm text-center">Options</th>


                        </tr>
                        </thead>
                        <tbody class="bg-white " >
                            @foreach($typeDevices as $key => $type)

                            <tr class="h-10 min-h-10 max-h-10 w-full bg-gray-50 p-1 border-b-[1px] border-gray-300">
                            <td class="text-center">
                                <span  class="xs:text-xs text-sm ">{{ $type->name }}</span>
                            </td>
                            <td class="text-center overflow-hidden"><span  class="xs:text-xs text-sm   text-left">{{ $type->model->device_model }}</span></td>
                            <td class="text-center overflow-hidden"><span class=" xs:text-xs text-sm text-center">{{  $type->price_prev }}</span></td>

                            <td class="text-center overflow-hidden"><span  class="xs:text-xs text-sm text-center">{{  $type->price }}</span></td>
                            <td class="text-center">
                                <div class="flex justify-center space-x-2 items-center">
                                    <div class="text-center">

                                        <svg data-toggle="modal" data-target="#show_deivce" onclick="EditDevice({{$key}})" class="text-svg_primary hover:text-secondary_blue hover:cursor-pointer h-6 w-6 " viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g id="SVGRepo_bgCarrier" stroke-width="0"/>
                                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>
                                            <g id="SVGRepo_iconCarrier">
                                                <path d="M12 3.99997H6C4.89543 3.99997 4 4.8954 4 5.99997V18C4 19.1045 4.89543 20 6 20H18C19.1046 20 20 19.1045 20 18V12M18.4142 8.41417L19.5 7.32842C20.281 6.54737 20.281 5.28104 19.5 4.5C18.7189 3.71895 17.4526 3.71895 16.6715 4.50001L15.5858 5.58575M18.4142 8.41417L12.3779 14.4505C12.0987 14.7297 11.7431 14.9201 11.356 14.9975L8.41422 15.5858L9.00257 12.6441C9.08001 12.2569 9.27032 11.9013 9.54951 11.6221L15.5858 5.58575M18.4142 8.41417L15.5858 5.58575"  stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke="currentColor" /> </g>
                                        </svg>
                                    </div>
                                    <div class="text-center">


                                        <!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">
                                        <!-- Uploaded to: SVG Repo, www.svgrepo.com, Transformed by: SVG Repo Mixer Tools -->
                                        <svg onclick="DeleteDevice({{ $type->id }})"  class="h-6 w-6 text-svg_primary hover:text-primary_red focus:text-primary_red"  viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <g id="SVGRepo_bgCarrier" stroke-width="0"/>
                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>
                                        <g id="SVGRepo_iconCarrier"> <path d="M10 11V17" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/> <path d="M14 11V17" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/> <path d="M4 7H20" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/> <path d="M6 7H12H18V18C18 19.6569 16.6569 21 15 21H9C7.34315 21 6 19.6569 6 18V7Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/> <path d="M9 5C9 3.89543 9.89543 3 11 3H13C14.1046 3 15 3.89543 15 5V7H9V5Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/> </g>
                                        </svg>


                                    </div>
                                </div>
                            </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
               {{-- end of devices --}}
            </div>
        </div>
    </div>

    <div  class="modal fade fixed top-0 left-0 z-[1055]  h-full w-full  " data-backdrop="static" data-keyboard="false" id="show_editadmin" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered  min-h-[calc(100%-1rem)] w-full max-w-[800px] translate-y-[-50px] items-center  transition-all duration-10 ease-out-in min-[576px]:mx-auto min-[576px]:mt-7 min-[576px]:min-h-[calc(100%-3.5rem)]" role="document">
        <div class="modal-content  w-full flex-col rounded-md border-none  bg-clip-padding text-current shadow-lg
        outline-none ">
            {{-- header --}}
            <div class="flex items-center justify-between p-4 border-b rounded-t ">
                <div class="flex items-center">
                <h3 class="text-xl font-semibold text-gray-900 ">
                    {{ __('Edit admin ') }}
                </h3>

                </div>
                <button type="button"  class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex
                items-center   close" data-dismiss="modal" aria-label="Close">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0
                    011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                </button>
            </div>
            <div id="show_editadmin_body"  class=" 2xl:max-h-[700px] xs:max-h-[400px] p-4">
                <form method="POST" action="{{ route('admin.info.update') }}">
                    @csrf
                <input type="hidden" value="" name="admin_id" id="admin_id" required>
                <div class="mb-2">
                    <label  class="text-black text-sm xs:ml-2 xs:mr-2 w-20 whitespace-nowrap" for="user_name">
                        User Name
                    </label>
                    <input maxlength="60" type="text" id="user_name" name="user_name" class=" w-full  mr-2  h-10 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500
                    focus:border-blue-500 block  px-2"    required>
                </div>
                <div class="mb-2">
                <label  class="text-black text-sm xs:ml-2 xs:mr-2 w-20 whitespace-nowrap" for="email">
                    Email
                </label>
                <input maxlength="60" type="email" id="email" name="email" class=" w-full  mr-2  h-10 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500
                focus:border-blue-500 block px-2"    required>
                </div>
                <div class="mb-2">
                <label  class="text-black text-sm xs:ml-2 xs:mr-2 w-20 whitespace-nowrap" for="role_select">
                   Role
                </label>
                <select   id="role_select" name="role_select" class=" w-full  h-10   text-sm rounded-lg
                px-2  border-gray-300   focus:border-secondary mr-2
                 focus:ring-secondary "   >


                </select>
                </div>
                <div class="mb-2">
                    <input type="hidden" name="changed_password" id="changed_password">
                    <label  class="text-black text-sm xs:ml-2 xs:mr-2 w-20 whitespace-nowrap" for="password">
                        Password
                    </label>
                    <div class="flex justify-between" id="changed_password_div" >
                    <div class="border border-gray-200 rounded-[0.5rem] opacity-50 w-full h-10 min-h-10 mr-4">

                    </div>
                        <x-jet-button onclick="changePassword()"  type="button"   >
                            {{ __('Change') }}
                        </x-jet-button>
                    </div>
                </div>
                    <div class="flex items-center p-6 space-x-2 border-t border-gray-200 rounded-b ">

                        <x-jet-secondary-button  data-dismiss="modal" aria-label="Close"  type="button"  wire:loading.attr="disabled">
                            {{ __('Cancel') }}
                        </x-jet-secondary-button>
                        <x-jet-button class="ml-3" type="submit"   wire:loading.attr="disabled">
                            {{ __('Save') }}
                        </x-jet-button>
                    </div>
                </form>

            </div>

        </div>
        </div>
    </div>
    {{-- promo codes modal --}}
    <div  class="modal fade fixed top-0 left-0 z-[1055]  h-full w-full  " data-backdrop="static" data-keyboard="false" id="show_promocode" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered  min-h-[calc(100%-1rem)] w-full max-w-[800px] translate-y-[-50px] items-center  transition-all duration-10 ease-out-in min-[576px]:mx-auto min-[576px]:mt-7 min-[576px]:min-h-[calc(100%-3.5rem)]" role="document">
        <div class="modal-content  w-full flex-col rounded-md border-none  bg-clip-padding text-current shadow-lg
        outline-none ">
            {{-- header --}}
            <div class="flex items-center justify-between p-4 border-b rounded-t ">
                <div class="flex items-center">
                <h3 id="dialog_title" class="text-xl font-semibold text-gray-900 ">
                    {{ __('Add promotion code ') }}
                </h3>

                </div>
                <button  onclick="ClearFormEditPromoCode()" type="button"  class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex
                items-center   close" data-dismiss="modal" aria-label="Close">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0
                    011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                </button>
            </div>
            <div   class=" 2xl:max-h-[700px] xs:max-h-[400px] p-4">
                <form id="promocodeform" method="POST" action="{{ route('admin.addpromocode') }}">
                    <div id="error_container" class="alert alert-danger" style="display: none;">
                        <ul id="error_list">
                        </ul>
                    </div>
                    @csrf
                    <input type="hidden" id="promocodeid" name="promocodeid">
                    {{-- code text --}}
                    <div class="grid grid-cols-12 gap-1 justify-between items-center space-x-4 w-full">
                        <x-input-label for="promocodetext" class="col-span-2" :value="__('Code')" />
                        <input    maxlength="10"   type="text"     id="promocodetext" name="promocodetext"
                            class="  w-full    h-10 bg-gray-50   text-gray-900 text-sm rounded-lg col-span-7
                            block  px-2 border-gray-300  focus:border-secondary
                             focus:ring-secondary  "     required>
                            <x-jet-button onclick="generateRandomCode()" class="flex justify-center col-span-3 " type="button"   >
                                {{ __('generate') }}
                            </x-jet-button>
                    </div>
                   {{-- type of use --}}
                   <div class="grid grid-cols-12 gap-1 justify-between items-center space-x-4 w-full mt-4">
                        <x-input-label class="col-span-2" for="typeuse_select" :value="__('For')" />

                        <select  id="typeuse_select" name="typeuse_select" class="col-span-10   h-10   text-sm rounded-lg
                            px-2  border-gray-300  focus:border-secondary  bg-gray-50
                            focus:ring-secondary "  >
                                    <option value="buyresponses">{{ __('Buy Responses') }}</option>
                                    <option value="upgrade">{{ __('Upgrade') }}</option>
                                    <option value="renew">{{ __('Renew ') }}</option>

                        </select>
                   </div>
                   {{-- value of discount --}}
                    <div class="grid grid-cols-12 gap-1 justify-between items-center space-x-4 w-full mt-4">
                        <x-input-label class="col-span-2" for="discount_value" :value="__('Value of Discount')" />
                        <input   type="number"  min="1" max="100"  pattern="\d*"   id="discount_value" name="discount_value"
                            class="      h-10 bg-gray-50   text-gray-900 text-sm rounded-lg col-span-10
                            block  px-2 border-gray-300  focus:border-secondary
                             focus:ring-secondary  "     required>
                   </div>
                   {{-- permissions --}}
                   <div class="grid grid-cols-12 gap-1 justify-between items-center space-x-4 w-full mt-4">
                        <x-input-label class="col-span-2" for="" :value="__('Permissions')" />
                        {{-- public --}}
                        <div class="col-span-5 flex justify-center items-center space-x-2">
                            <x-input-label class="col-span-2" for="public_checkbox" :value="__('Public')" />
                            <label class=" relative inline-flex items-center cursor-pointer">
                                <input type="checkbox"  value="1"  checked class="sr-only peer" name="public_checkbox" id="public_checkbox">
                                <div class="w-11 col-span-3 h-6 bg-gray-200 peer-focus:outline-none
                                rounded-full peer  peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute
                                after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all
                                    peer-checked:bg-secondary_blue"></div>

                            </label>
                        </div>
                        {{-- valid --}}
                        <div class="col-span-5 flex justify-center items-center space-x-2">
                            <x-input-label class="col-span-2" for="valid_checkbox" :value="__('Valid')" />
                            <label class=" relative inline-flex items-center cursor-pointer">

                                <input type="checkbox" value="1"  checked  class="sr-only peer" name="valid_checkbox" id="valid_checkbox">
                                <div class="w-11 col-span-3 h-6 bg-gray-200 peer-focus:outline-none
                                rounded-full peer  peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute
                                after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all
                                    peer-checked:bg-secondary_blue"></div>

                                </label>
                        </div>
                   </div>
                   {{-- note --}}
                   <div class="grid grid-cols-12 gap-1 justify-between items-center space-x-4  my-2  w-full">
                    <x-input-label for="note" class="col-span-2" :value="__('Note')" />
                    <textarea    type="text"  rows="10"    id="note" name="note"
                        class="   h-10 bg-gray-50   text-gray-900 text-sm rounded-lg col-span-10
                        block  px-2 border-gray-300  focus:border-secondary
                         focus:ring-secondary  "     required></textarea>

                </div>

                    <div class="flex items-center p-6 space-x-2 border-t border-gray-200 rounded-b ">

                        <x-jet-secondary-button onclick="ClearFormEditPromoCode()"  data-dismiss="modal" aria-label="Close"  type="button"  wire:loading.attr="disabled">
                            {{ __('Cancel') }}
                        </x-jet-secondary-button>
                        <x-jet-button class="ml-3" type="submit"   wire:loading.attr="disabled">
                            {{ __('Save') }}
                        </x-jet-button>
                    </div>
                </form>

            </div>

        </div>
        </div>
    </div>
    {{-- device modal --}}
    <div  class="modal fade fixed top-0 left-0 z-[1055]  h-full w-full  " data-backdrop="static" data-keyboard="false" id="show_deivce" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered  min-h-[calc(100%-1rem)] w-full max-w-[800px] translate-y-[-50px] items-center  transition-all duration-10 ease-out-in min-[576px]:mx-auto min-[576px]:mt-7 min-[576px]:min-h-[calc(100%-3.5rem)]" role="document">
        <div class="modal-content  w-full flex-col rounded-md border-none  bg-clip-padding text-current shadow-lg
        outline-none ">
            {{-- header --}}
            <div class="flex items-center justify-between p-4 border-b rounded-t ">
                <div class="flex items-center">
                <h3 id="dialog_device_form_title" class="text-xl font-semibold text-gray-900 ">
                    {{ __('Add New Device ') }}
                </h3>

                </div>
                <button  onclick="ClearFormEditDevice()" type="button"  class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex
                items-center   close" data-dismiss="modal" aria-label="Close">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0
                    011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                </button>
            </div>
            <div   class=" 2xl:max-h-[700px] xs:max-h-[400px] p-4">
                <form id="deviceform" method="POST" enctype="multipart/form-data" action="{{ route('admin.adddevice') }}">
                    <div id="error_container" class="alert alert-danger" style="display: none;">
                        <ul id="error_list">
                        </ul>
                    </div>
                    @csrf
                    <input type="hidden" id="deviceid" name="deviceid">
                    {{-- Name of device --}}
                    <div class="grid grid-cols-12 gap-1 justify-between items-center space-x-4 w-full mt-4">
                        <x-input-label class="col-span-2" for="device_name" :value="__('Deivce Name')" />
                        <input   type="text"    id="device_name" name="device_name"
                            class="      h-10 bg-gray-50   text-gray-900 text-sm rounded-lg col-span-10
                            block  px-2 border-gray-300  focus:border-secondary
                            focus:ring-secondary  "     required>
                    </div>

                   {{-- device model --}}
                   <div class="grid grid-cols-12 gap-1 justify-between items-center space-x-4 w-full mt-4">
                        <x-input-label class="col-span-2" for="devicemodel_select" :value="__('Device Model')" />

                        <select  id="devicemodel_select" name="devicemodel_select" class="col-span-10   h-10   text-sm rounded-lg
                            px-2  border-gray-300  focus:border-secondary  bg-gray-50
                            focus:ring-secondary "  >
                            @foreach ($devicesModels as $model)
                            <option value="{{ $model->id }}">{{ $model->device_model }}</option>
                            @endforeach



                        </select>
                   </div>
                   <div class="grid grid-cols-12 gap-1 justify-between items-center space-x-4 w-full mt-4">
                    <x-input-label class="col-span-2" for="image" :value="__('Device Image')" />

                    <input  type="file"  accept="image/*"  id="image" name="image" class="col-span-10   h-10   text-sm rounded-lg
                        px-2  border-gray-300  focus:border-secondary  bg-gray-50
                        focus:ring-secondary "  required>

               </div>


                   {{-- price before --}}
                    <div class="grid grid-cols-12 gap-1 justify-between items-center space-x-4 w-full mt-4">
                        <x-input-label class="col-span-2" for="price_before" :value="__('Price Before')" />
                        <input   type="text" pattern="[0-9]*" inputmode="numeric"  id="price_before" name="price_before"
                            class="      h-10 bg-gray-50   text-gray-900 text-sm rounded-lg col-span-10
                            block  px-2 border-gray-300  focus:border-secondary
                             focus:ring-secondary  "     >
                   </div>
                   {{-- price now --}}
                   <div class="grid grid-cols-12 gap-1 justify-between items-center space-x-4 w-full mt-4">
                    <x-input-label class="col-span-2" for="price_now" :value="__('Price Now')" />
                    <input   type="text" pattern="[0-9]*" inputmode="numeric"  id="price_now" name="price_now"
                        class="      h-10 bg-gray-50   text-gray-900 text-sm rounded-lg col-span-10
                        block  px-2 border-gray-300  focus:border-secondary
                         focus:ring-secondary  "     required>
               </div>




                    <div class="flex items-center p-6 space-x-2 border-t border-gray-200 rounded-b ">

                        <x-jet-secondary-button onclick="ClearFormEditDevice()"  data-dismiss="modal" aria-label="Close"  type="button"  wire:loading.attr="disabled">
                            {{ __('Cancel') }}
                        </x-jet-secondary-button>
                        <x-jet-button class="ml-3" type="submit"   wire:loading.attr="disabled">
                            {{ __('Save') }}
                        </x-jet-button>
                    </div>
                </form>

            </div>

        </div>
        </div>
    </div>
    {{-- client modal --}}

    <div  class="modal fade fixed top-0 left-0 z-[1055]  h-full w-full  " data-backdrop="static" data-keyboard="false" id="show_client" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered  min-h-[calc(100%-1rem)] w-full max-w-[800px] translate-y-[-50px] items-center  transition-all duration-10 ease-out-in min-[576px]:mx-auto min-[576px]:mt-7 min-[576px]:min-h-[calc(100%-3.5rem)]" role="document">
        <div class="modal-content  w-full flex-col rounded-md border-none  bg-clip-padding text-current shadow-lg
        outline-none ">
            {{-- header --}}
            <div class="flex items-center justify-between p-4 border-b rounded-t ">
                <div class="flex items-center">
                <h3 id="dialog_client_form_title" class="text-xl font-semibold text-gray-900 ">
                    {{ __('Add New Client ') }}
                </h3>

                </div>
                <button  onclick="ClearFormEditClient()" type="button"  class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex
                items-center   close" data-dismiss="modal" aria-label="Close">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0
                    011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                </button>
            </div>
            <div   class=" 2xl:max-h-[700px] xs:max-h-[400px] p-4">
                <form id="deviceform" method="POST" enctype="multipart/form-data" action="{{ route('admin.addclient') }}">
                    <div id="error_container" class="alert alert-danger" style="display: none;">
                        <ul id="error_list">
                        </ul>
                    </div>
                    @csrf

                    <div class="grid grid-cols-12 gap-1 justify-between items-center space-x-4 w-full mt-4">
                        <x-input-label class="col-span-2" for="image" :value="__('Logo')" />

                        <input  type="file"  accept="image/*"  id="image" name="image" class="col-span-10   h-10   text-sm rounded-lg
                            px-2  border-gray-300  focus:border-secondary  bg-gray-50
                            focus:ring-secondary "  required>

                    </div>







                    <div class="flex items-center p-6 space-x-2 border-t border-gray-200 rounded-b ">

                        <x-jet-secondary-button onclick="ClearFormEditClient()"  data-dismiss="modal" aria-label="Close"  type="button"  wire:loading.attr="disabled">
                            {{ __('Cancel') }}
                        </x-jet-secondary-button>
                        <x-jet-button class="ml-3" type="submit"   wire:loading.attr="disabled">
                            {{ __('Save') }}
                        </x-jet-button>
                    </div>
                </form>

            </div>

        </div>
        </div>
    </div>

    @livewireScripts()
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="{{ asset('https://unpkg.com/xlsx-populate/browser/xlsx-populate.min.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>

        pathExcelFile="/resources/admin/Accounts.xlsx";
        function getAccounts(){
            axios.get('/api/data/export/accounts')
            .then(response => {
                // Handle the response data
                exportAccounts(response.data) ;
            })
            .catch(error => {
                // Handle any errors
                console.error(error);
            });
        }
        function exportAccounts(Accounts){


             if(Accounts){
            fetch(pathExcelFile)
            .then(response => response.arrayBuffer())
            .then(buffer => {
                const workbook = XlsxPopulate.fromDataAsync(buffer);

                return workbook.then(workbook => {

                        const sheet = workbook.sheet(0);

                        Accounts.forEach(function(account, i) {

                            sheet.cell(`A${i+2}`).value(account.email);
                            sheet.cell(`B${i+2}`).value(account.business_name);
                            sheet.cell(`C${i+2}`).value(account.name);
                            sheet.cell(`D${i+2}`).value(account.mobile_number);
                            sheet.cell(`E${i+2}`).value(account.country);
                            sheet.cell(`F${i+2}`).value(account.city);
                            sheet.cell(`G${i+2}`).value(account.subscription_type);
                            sheet.cell(`H${i+2}`).value(account.subscription_status);
                        });

                    // Save the modified workbook

                    return workbook.outputAsync();

                });
            })
            // add some of setting to download
            .then(fileData => {

                const blob = new Blob([fileData], {
                    details: accounts
                }, {
                    type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
                });


                    const url = URL.createObjectURL(blob);
                    const a = document.createElement('a');
                    a.href = url;

                    a.download =  'Accounts.xlsx'; // Set the desired name for the downloaded file
                    document.body.appendChild(a);
                    a.click();
                    document.body.removeChild(a);

            });
        }
        }
    </script>
    <script type="text/javascript">
            function dropdown() {
                document.querySelector("#submenu").classList.toggle("hidden");
                document.querySelector("#arrow").classList.toggle("rotate-0");
            }
            dropdown();

            function openSidebar() {
                document.querySelector(".sidebar").classList.toggle("hidden");
            }

        </script>
    <script>
         var responsesCategories = {!! json_encode($responsesCategories->toArray(), JSON_HEX_TAG) !!};

        function ShowFormEdit(){
            form=document.getElementById('editresponsescategories_form');
            form.classList.remove('hidden');
            form.classList.add('flex');
            selectedCat=document.getElementById('responsesCategories_select').value;
            document.getElementById('cat_id').value=responsesCategories[selectedCat].id;
            document.getElementById('price_edit').value=responsesCategories[selectedCat].price;
            document.getElementById('num_edit').value=responsesCategories[selectedCat].num;
        }
    </script>

    <script src="{{ asset('js/jquery.min.js')}}"></script>
    <script src="{{ asset('js/owl.carousel.min.js')}}"></script>
    <script src="{{ asset('js/bootstrap.min.js')}}"></script>

    <link href="{{ asset('https://fonts.googleapis.com/icon?family=Material+Icons')}}" rel="stylesheet">
    <script src="{{ asset('js/Chart.min.js')}}"></script>
    <script src="{{ asset('js/cropper.min.js')}}"></script>
    <script src="{{ asset('js/index.min.js') }}"></script>
    <script src="{{ asset('js/flowbite.min.js')}}"></script>

    <script src="{{ asset('js/sort-list.js')}}"></script>

    <script src="https://cdn.jsdelivr.net/npm/jquery.fancytable/dist/fancyTable.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>




<script>
 var admins = {!! json_encode($admins->toArray(), JSON_HEX_TAG) !!};
 var accounts = {!! json_encode($accounts->toArray(), JSON_HEX_TAG) !!};
//    account check function
   function ckeckAccounts(){

    id=document.getElementById('idaccount_check').value;
    if(id){id = parseInt(id, 10); }
    resultDiv=document.getElementById('check_result');
    let found = false;

    accounts.forEach(account => {
        if (account.id === id) {

            resultDiv.innerHTML = `
            <form class="flex justify-between items-center  mt-8" method="post" action="{{ route('admin.changeaccountstatus') }}">
                            @csrf
                        <input id="accountId" name="accountId" type="hidden" value="${account.id}">
                        <div class="flex justify-center items-center">
                            <h1 >Status:</h1>
                            <label class="mb-0 relative inline-flex items-center cursor-pointer">

                                <input type="checkbox" name="status" id="status"   value="${account.active}" ${ account.active?"checked":"" } class="sr-only peer"

                                >
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none e
                                rounded-full peer  peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute
                                after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all
                                     peer-checked:bg-secondary_blue"></div>

                            </label>
                        </div>
                        <x-jet-button  class="ml-3" type="submit"   >
                                            {{ __('Save') }}
                        </x-jet-button>

            </form>
            `;
            found = true;
            // Use return to exit the arrow function prematurely
            return;
        }
    });

    if (!found) {
        resultDiv.innerHTML = `not found`;
    }
   }


   function EditAdmin(i){
     admin=admins[i];
     modal=document.getElementById('tickets_table');
     document.getElementById('user_name').value=admin.name;
     document.getElementById('email').value=admin.email;
     document.getElementById('admin_id').value=admin.id;
     role_select=document.getElementById('role_select');
     role_select.value=admin.role;
     role_select.innerHTML=`
     <option ${admin.role=='admin'?'selected':""} value="admin"  >Admin</option>
    <option ${admin.role=='super_admin'?'selected':""} value="super_admin"  >Super Admin</option>
     `;

   }

  function changePassword(){

    document.getElementById('changed_password').value=true;
    document.getElementById('changed_password_div').innerHTML=`
        <div class="relative w-full mr-4">
            <input   maxlength="60" type="password" id="password" name="password" pattern="^(?=.*[A-Z])(?=.*\\d)(?=.*[!@#$%^&*])[A-Za-z\\d!@#$%^&*]{8,}$"
                    title="Password must be strong" class=" w-full  mr-2  h-10 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500
            focus:border-blue-500 block   px-2"    required>
            <div   class="absolute  top-2 right-0 pr-3 flex items-center text-sm leading-5">
                    <svg id="passIcon_password" onclick="togglePasswordVisibility()" class="h-6 w-8 text-gray-700 " fill="none"  viewBox="0 0 24 24"  xmlns="http://www.w3.org/2000/svg">

                        <g id="SVGRepo_bgCarrier" stroke-width="0"/>

                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>

                        <g id="SVGRepo_iconCarrier">
                            <path opacity="0.5" d="M10 22C6.22876 22 4.34315 22 3.17157 20.8284C2 19.6569 2 18.7712 2 15" stroke="#1C274C" stroke-width="1.5"
                            stroke-linecap="round"/> <path opacity="0.5" d="M22 15C22 18.7712 22 19.6569 20.8284 20.8284C19.6569 22 17.7712 22 14 22"
                            stroke="#1C274C" stroke-width="1.5" stroke-linecap="round"/> <path opacity="0.5"
                            d="M14 2C17.7712 2 19.6569 2 20.8284 3.17157C22 4.34315 22 5.22876 22 9"
                            stroke="#1C274C" stroke-width="1.5" stroke-linecap="round"/>
                            <path opacity="0.5" d="M10 2C6.22876 2 4.34315 2 3.17157 3.17157C2 4.34315 2 5.22876 2 9" stroke="#1C274C" stroke-width="1.5"
                            stroke-linecap="round"/>
                            <path d="M5.89243 14.0598C5.29748 13.3697 5 13.0246 5 12C5 10.9754 5.29747 10.6303 5.89242 9.94021C7.08037 8.56222 9.07268 7
                            12 7C14.9273 7 16.9196 8.56222 18.1076 9.94021C18.7025 10.6303 19 10.9754 19 12C19 13.0246 18.7025 13.3697 18.1076 14.0598C16.9196
                            15.4378 14.9273 17 12 17C9.07268 17 7.08038 15.4378 5.89243 14.0598Z" stroke="#1C274C" stroke-width="1.5"/>
                            <circle cx="12" cy="12" r="2" stroke="#1C274C" stroke-width="1.5"/>
                        </g>

                    </svg>
            </div>
        </div>
        <x-jet-button onclick="cancelChangePassword()"  type="button"   >
                {{ __('Cancel') }}
        </x-jet-button>
        `;
  }
  function cancelChangePassword(){
    document.getElementById('changed_password').value=false;
    document.getElementById('changed_password_div').innerHTML=`
    <div class="border border-gray-200 rounded-[0.5rem] opacity-50 w-full h-10 min-h-10">

    </div>
        <x-jet-button onclick="changePassword()"  type="button"   >
            {{ __('Change') }}
        </x-jet-button>
    </div>`;
  }
  function togglePasswordVisibility() {
     passwordInput=document.getElementById('password');
     icon=document.getElementById('passIcon_password');
     if (passwordInput.type == 'password') {
        passwordInput.type = 'text';  // Show password
        icon.innerHTML=`
            <g id="SVGRepo_bgCarrier" stroke-width="0"/>

            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>

            <g id="SVGRepo_iconCarrier"> <g opacity="0.5">
            <path d="M14 2.75C15.9068 2.75 17.2615 2.75159 18.2892 2.88976C19.2952 3.02503 19.8749 3.27869 20.2981 3.7019C20.7852 4.18904 20.9973 4.56666 21.1147
            5.23984C21.2471 5.9986 21.25 7.08092 21.25 9C21.25 9.41422 21.5858 9.75 22 9.75C22.4142 9.75 22.75 9.41422 22.75 9L22.75 8.90369C22.7501 7.1045
            22.7501 5.88571 22.5924 4.98199C22.417 3.97665 22.0432 3.32568 21.3588 2.64124C20.6104 1.89288 19.6615 1.56076 18.489 1.40314C17.3498 1.24997
            15.8942 1.24998 14.0564 1.25H14C13.5858 1.25 13.25 1.58579 13.25 2C13.25 2.41421 13.5858 2.75 14 2.75Z" fill="#1C274C"/>
            <path d="M2.00001 14.25C2.41422 14.25 2.75001 14.5858 2.75001 15C2.75001 16.9191 2.75289 18.0014 2.88529
            18.7602C3.00275 19.4333 3.21477 19.811 3.70191 20.2981C4.12512 20.7213 4.70476 20.975 5.71085 21.1102C6.73852 21.2484 8.09318 21.25 10 21.25C10.4142
                21.25 10.75 21.5858 10.75 22C10.75 22.4142 10.4142 22.75 10 22.75H9.94359C8.10583 22.75 6.6502 22.75 5.51098 22.5969C4.33856 22.4392 3.38961 22.1071
                2.64125 21.3588C1.95681 20.6743 1.58304 20.0233 1.40762 19.018C1.24992 18.1143 1.24995 16.8955 1.25 15.0964L1.25001 15C1.25001 14.5858 1.58579 14.25
                2.00001 14.25Z" fill="#1C274C"/> <path d="M22 14.25C22.4142 14.25 22.75 14.5858 22.75 15L22.75 15.0963C22.7501 16.8955 22.7501 18.1143 22.5924
                19.018C22.417 20.0233 22.0432 20.6743 21.3588 21.3588C20.6104 22.1071 19.6615 22.4392 18.489 22.5969C17.3498 22.75 15.8942 22.75 14.0564
                22.75H14C13.5858 22.75 13.25 22.4142 13.25 22C13.25 21.5858 13.5858 21.25 14 21.25C15.9068 21.25 17.2615 21.2484 18.2892 21.1102C19.2952 20.975 19.8749
                20.7213 20.2981 20.2981C20.7852 19.811 20.9973 19.4333 21.1147 18.7602C21.2471 18.0014 21.25 16.9191 21.25 15C21.25 14.5858 21.5858 14.25 22 14.25Z"
                fill="#1C274C"/>
                <path d="M9.94359 1.25H10C10.4142 1.25 10.75 1.58579 10.75 2C10.75 2.41421 10.4142 2.75 10 2.75C8.09319 2.75 6.73852 2.75159 5.71085 2.88976C4.70476
                3.02503 4.12512 3.27869 3.70191 3.7019C3.21477 4.18904 3.00275 4.56666 2.88529 5.23984C2.75289 5.9986 2.75001 7.08092 2.75001 9C2.75001 9.41422
                2.41422 9.75 2.00001 9.75C1.58579 9.75 1.25001 9.41422 1.25001 9L1.25 8.90369C1.24995 7.10453 1.24992 5.8857 1.40762 4.98199C1.58304 3.97665 1.95681
                3.32568 2.64125 2.64124C3.38961 1.89288 4.33856 1.56076 5.51098 1.40314C6.65019 1.24997 8.10584 1.24998 9.94359 1.25Z" fill="#1C274C"/> </g>
                <path d="M12 10.75C11.3096 10.75 10.75 11.3096 10.75 12C10.75 12.6904 11.3096 13.25 12 13.25C12.6904 13.25 13.25 12.6904 13.25 12C13.25 11.3096
                12.6904 10.75 12 10.75Z" fill="#1C274C"/> <path fill-rule="evenodd" clip-rule="evenodd" d="M5.89243 14.0598C5.29747 13.3697 5 13.0246 5 12C5 10.9754
                5.29748 10.6303 5.89242 9.94021C7.08037 8.56222 9.07268 7 12 7C14.9273 7 16.9196 8.56222 18.1076 9.94021C18.7025 10.6303 19 10.9754 19 12C19 13.0246
                18.7025 13.3697 18.1076 14.0598C16.9196 15.4378 14.9273 17 12 17C9.07268 17 7.08038 15.4378 5.89243 14.0598ZM9.25 12C9.25 10.4812 10.4812 9.25 12
                9.25C13.5188 9.25 14.75 10.4812 14.75 12C14.75 13.5188 13.5188 14.75 12 14.75C10.4812 14.75 9.25 13.5188 9.25 12Z" fill="#1C274C"/> </g>
            `;
    } else {
        passwordInput.type = 'password';  // Hide password
        icon.innerHTML=`
        <g id="SVGRepo_bgCarrier" stroke-width="0"/>

        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>

        <g id="SVGRepo_iconCarrier">
            <path opacity="0.5" d="M10 22C6.22876 22 4.34315 22 3.17157 20.8284C2 19.6569 2 18.7712 2 15" stroke="#1C274C" stroke-width="1.5"
            stroke-linecap="round"/> <path opacity="0.5" d="M22 15C22 18.7712 22 19.6569 20.8284 20.8284C19.6569 22 17.7712 22 14 22"
            stroke="#1C274C" stroke-width="1.5" stroke-linecap="round"/> <path opacity="0.5"
            d="M14 2C17.7712 2 19.6569 2 20.8284 3.17157C22 4.34315 22 5.22876 22 9"
            stroke="#1C274C" stroke-width="1.5" stroke-linecap="round"/>
            <path opacity="0.5" d="M10 2C6.22876 2 4.34315 2 3.17157 3.17157C2 4.34315 2 5.22876 2 9" stroke="#1C274C" stroke-width="1.5"
            stroke-linecap="round"/>
            <path d="M5.89243 14.0598C5.29748 13.3697 5 13.0246 5 12C5 10.9754 5.29747 10.6303 5.89242 9.94021C7.08037 8.56222 9.07268 7
            12 7C14.9273 7 16.9196 8.56222 18.1076 9.94021C18.7025 10.6303 19 10.9754 19 12C19 13.0246 18.7025 13.3697 18.1076 14.0598C16.9196
            15.4378 14.9273 17 12 17C9.07268 17 7.08038 15.4378 5.89243 14.0598Z" stroke="#1C274C" stroke-width="1.5"/>
            <circle cx="12" cy="12" r="2" stroke="#1C274C" stroke-width="1.5"/>
        </g>`;
    }
  }
//   promo code
var PromotionCodes = {!! json_encode($promotionCodes->toArray(), JSON_HEX_TAG) !!};
var typeDevices = {!! json_encode($typeDevices->toArray(), JSON_HEX_TAG) !!};

// edit promo code

//   generate random promo code
var length=10;
function generateRandomCode() {
    var characters = '123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    var charactersLength = characters.length;
    var randomString = '';
    for (var i = 0; i < length; i++) {
        randomString += characters.charAt(Math.floor(Math.random() * charactersLength));
    }
    document.getElementById('promocodetext').value=randomString;

}
var edit=false;
function ClearFormEditPromoCode(){
    edit=false
    document.getElementById('dialog_title').innerText="Add promo code";
    document.getElementById('promocodetext').value ='';
    document.getElementById('typeuse_select').value ='buyresponses';
    document.getElementById('discount_value').value ='';
    document.getElementById('public_checkbox').checked = true;
    document.getElementById('valid_checkbox').checked = true;
    document.getElementById('note').value='';
        var form = document.getElementById('promocodeform');

        form.setAttribute('action', `{{ route("admin.addpromocode") }}`);



}
// delete promo code
function DeletePromoCode(id){
    Swal.fire({
                title:'Delte Promotion Code',
                html: 'Do you want delete  this promotion code?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#1277D1',
            showCancelButton: true,
            cancelButtonColor:'#f3f4f6',
            cancelButtonText:`<h5 style='color:000000;border:0;box-shadow: none;'>Cancel</h5>`,
            confirmButtonText:'Ok'
            }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '{{ route('admin.deletepromocode', ['id' => ':id']) }}'.replace(':id', id);

            }
            })

}

// edit promo code
 function EditPromoCode(PromoCodeKey){
    edit=true;

    document.getElementById('dialog_title').innerText="Edit promo code";
     PromoCode = PromotionCodes[PromoCodeKey];
    document.getElementById('promocodetext').value = PromoCode.code;
    document.getElementById('typeuse_select').value = PromoCode.use_type;
    document.getElementById('discount_value').value = PromoCode.discount_value;
    document.getElementById('public_checkbox').checked = PromoCode.public;

    document.getElementById('valid_checkbox').checked = PromoCode.valid;
    document.getElementById('note').value=PromoCode.note;
    var form = document.getElementById('promocodeform');


    document.getElementById('promocodeid').value = PromoCode.id;
    form.setAttribute('action', `{{ route("admin.editpromocode") }}`);


 }


//  check on unique of promocode
document.getElementById('promocodeform').addEventListener('submit', function (event) {
    event.preventDefault(); // Prevent the form from submitting
    var code = document.getElementById('promocodetext').value;

    // Perform an AJAX request to check the uniqueness of the code
    if(edit==false){
    $.ajax({
        url: '{{ route('admin.checkcodeunique') }}',
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: { code: code },
        success: function(response) {
            if (response.unique) {
                // If the code is unique, submit the form
                document.getElementById('promocodeform').submit();
            } else {

                // If the code is not unique, display an error message
                var errorContainer = document.getElementById('error_container');
                var errorList = document.getElementById('error_list');
                errorList.innerHTML = '<li>The code must be unique.</li>';
                errorContainer.style.display = 'block';
            }
        },
        error: function() {
            // Handle errors
            console.error('Error checking code uniqueness.');
        }
    });
    }
    else
    {
        document.getElementById('promocodeform').submit();

    }
});


// devices
// edit device
function EditDevice(DeviceKey)
{
    edit=true;

    document.getElementById('dialog_device_form_title').innerText="Edit Device";
     Device = typeDevices[DeviceKey];
     console.log(Device);
    document.getElementById('device_name').value = Device.name;
    document.getElementById('devicemodel_select').value = Device.model.id;
    document.getElementById('price_before').value = Device.price_prev;
    document.getElementById('price_now').value = Device.price;


    var form = document.getElementById('deviceform');


    document.getElementById('deviceid').value = Device.id;
    form.setAttribute('action', `{{ route("admin.editdevice") }}`);


 }
 function ClearFormEditDevice(){
    edit=false
    document.getElementById('dialog_device_form_title').innerText="Add New Device";
    document.getElementById('device_name').value ='';
    document.getElementById('discount_value').value ='';
    document.getElementById('price_before').value ='';
    document.getElementById('price_now').value ='';
    document.getElementById('image').value=null;
        var form = document.getElementById('deviceform');

        form.setAttribute('action', `{{ route("admin.adddevice") }}`);

 }
// delete device
function DeleteDevice(id){
    Swal.fire({
                title:'Delte Device',
                html: 'Do you want delete  this Device?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#1277D1',
            showCancelButton: true,
            cancelButtonColor:'#f3f4f6',
            cancelButtonText:`<h5 style='color:000000;border:0;box-shadow: none;'>Cancel</h5>`,
            confirmButtonText:'Ok'
            }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '{{ route('admin.deletedevice', ['id' => ':id']) }}'.replace(':id', id);

            }
            })

}


</script>

<script>
    // clients
    // delete device
    function DeleteClient(id){
        Swal.fire({
                    title:'Delete Client',
                    html: 'Do you want delete  this Client?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#1277D1',
                showCancelButton: true,
                cancelButtonColor:'#f3f4f6',
                cancelButtonText:`<h5 style='color:000000;border:0;box-shadow: none;'>Cancel</h5>`,
                confirmButtonText:'Ok'
                }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '{{ route('admin.deleteclient', ['id' => ':id']) }}'.replace(':id', id);

                }
                })

    }
    $('.client-logo').owlCarousel({
            loop: true,
            margin: 0,
            dots: false,
            nav: false,
            autoplay: true,
            responsiveClass:true,
            responsive: {
                0: {
                    items: 3
                },
                300: {
                    items: 3
                },
                600: {
                    items: 4
                },
                1000: {
                    items: 5
                }
            },
            onInitialized: function(event) {
                var items = event.item.count;
                var visibleItems = event.page.size;
                if (items <= visibleItems) {
                    this.settings.loop = false;
                    this.settings.merge = true;
                    this.settings.mergeFit = true;
                }
            }
        })
  </script>
    {{-- menubar for each form in owl carousel  --}}

    <script>
        var message = document.getElementById('message').value;
        console.log(message);
    if(message){
    if (message=="error")
    {
            Swal.fire({
                icon: 'error',
                title:message,
                text:message,
                confirmButtonColor:'#1277D1',
            })
    }
    else if(message=="success")
    {
        Swal.fire({
                    icon: 'success',
                    title:message,
                    text:message,
                    confirmButtonColor:'#1277D1',
            })
    }
}

    </script>

    @stack('scripts')
    @stack('modals')
</body>

</html>
