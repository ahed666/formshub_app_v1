<div wire:loading.class="disabled opacity-50 ">
{{-- table of kiosk --}}
<div class="max-h-screen min-h-screen mb-10 mt-6  ">
    {{-- search --}}
    <div class="h-10 mb-2 flex justify-between w-full">
        {{-- <div class="relative" data-te-dropdown-ref>
            <a
              class="no-underline focus:no-underline hover:no-underline flex items-center whitespace-nowrap rounded bg-secondary px-6 pb-2 pt-2.5
               text-xs font-medium uppercase leading-normal text-white shadow-[0_4px_9px_-4px_#3b71ca] transition duration-150 ease-in-out
               hover:bg-secondary_1 hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:bg-primary-600
               focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:outline-none focus:ring-0 active:bg-primary-700
               active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] motion-reduce:transition-none"
              type="button"
              id="dropdownMenuButton2"
              data-te-dropdown-toggle-ref
              aria-expanded="false"
              data-te-ripple-init
              data-te-ripple-color="light">
              {{ __('Filter') }}
              <span class="ml-2 w-2">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  viewBox="0 0 20 20"
                  fill="currentColor"
                  class="h-5 w-5">
                  <path
                    fill-rule="evenodd"
                    d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"
                    clip-rule="evenodd" />
                </svg>
              </span>
            </a>
            <ul
              class="absolute z-[1000] float-left m-0 hidden min-w-max list-none overflow-hidden rounded-lg border-none bg-white bg-clip-padding text-left text-base shadow-lg  [&[data-te-dropdown-show]]:block"
              aria-labelledby="dropdownMenuButton2"
              data-te-dropdown-menu-ref>
              <li wire:click="setfilter('Paid')">
                <a
                  class="cursor-pointer hover:cursor-pointer no-underline focus:no-underline hover:no-underline block w-full whitespace-nowrap bg-transparent px-4 py-2 text-sm font-normal text-neutral-700 hover:bg-neutral-100 active:text-neutral-800 active:no-underline disabled:pointer-events-none disabled:bg-transparent disabled:text-neutral-400 "
                  data-te-dropdown-item-ref
                  >Paid</a
                >
              </li>
              <li wire:click="setfilter('notpaid')">
                <a  class="cursor-pointer hover:cursor-pointer no-underline focus:no-underline hover:no-underline block w-full whitespace-nowrap bg-transparent px-4 py-2 text-sm font-normal text-neutral-700 hover:bg-neutral-100 active:text-neutral-800 active:no-underline disabled:pointer-events-none disabled:bg-transparent disabled:text-neutral-400 "
                  data-te-dropdown-item-ref
                  >Another Status</a>
              </li>
            </ul>
        </div> --}}
        <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only ">Search</label>
        <div class="relative w-[250px]">
            <div class="absolute inset-y-0 right-0 flex items-center pr-1 pointer-events-none">
                <svg aria-hidden="true" class="w-5 h-5 text-gray-500 " fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
            <input wire:model="searchtext"  type="text" id="default-search" class="block w-full p-1 h-full text-sm text-gray-900 border
             border-gray-300 rounded-lg
             focus:ring-gray-300 focus:border-gray-300
             bg-gray-50" placeholder="Invoice Number" required>
        </div>
    </div>

    {{-- table --}}
    <div class="max-h-screen min-h-screen rounded-lg  overflow-y-auto">
        <table class="billing_table table-fixed xs:table-auto w-full  rounded-lg   " >
        {{-- head of table --}}
        <thead class="h-14">
        <tr class="border-b-[1px] border-t-[1px] p-1  bg-gray-600 text-white ">

            <th data-sortas="numeric"   class="sticky top-0 px-4 py-2 xs:p-1 z-50 bg-gray-600 ml-1 mr-1 w-1/5 xs:text-xs text-sm ">{{ __('main.invoicenumber') }}

            </th>
            <th  data-sortas="case-insensitive" class="sticky top-0 px-4  py-2 xs:p-1 bg-gray-600 ml-1 mr-1 w-1/5 xs:text-xs text-sm"> {{ __('main.invoicedescription') }}

            </th>
            <th  class="sticky top-0 px-4 py-2 xs:p-1 bg-gray-600 ml-1 mr-1 w-1/5 xs:text-xs text-sm">{{ __('main.amount') }}

            </th>
            <th data-sortas="datetime"  class="sticky top-0 px-4 py-2 xs:p-1 bg-gray-600 ml-1 mr-1 w-1/5 xs:text-xs text-sm">{{ __('main.invoicedate') }}

            </th>
            <th  class="sticky top-0 px-4 py-2 xs:p-1 bg-gray-600 ml-1 mr-1 w-1/5 xs:text-xs text-sm">{{ __('main.status') }}

            </th>
            <th   class="sticky top-0 px-4 py-2 xs:p-1 bg-gray-600 ml-1 mr-1 w-1/5 text-sm xs:text-xs">{{ __('main.download') }}</th>

        </tr>
        </thead>
        {{-- bdy of table --}}
        <tbody class="bg-white " >



        @foreach ($invoices as $i   => $invoice )
        <tr class="h-10 min-h-10 max-h-10 w-full bg-gray-50 p-1 border-b-[1px] border-gray-200">
        <td data-sortvalue="{{ $invoice->id }}" class="text-center">
            @php

            @endphp
            <span data-sortvalue="{{ $invoice->id }}" class="xs:text-xs text-sm ">{{ __('FHINV-') }}{{ $invoice->invoice_no }}</span>

        </td>
        <td class="text-left"><span  class="xs:text-xs text-sm   text-left">{{ $invoice->invoice_description }}</span></td>
        <td class="text-center"><span class=" xs:text-xs text-sm text-center">{{ $invoice->price_in_tax }}</span></td>
        {{-- device code --}}
        <td data-sortvalue="{{$invoice->invoice_date}}" class="text-center"><span  class="xs:text-xs text-sm text-center">{{\Carbon\Carbon::parse($invoice->invoice_date)->format('Y-m-d')  }}</span></td>
        {{-- status --}}
        <td class="text-center"> <span class="{{ $invoice->status=="Paid"?"text-valid":"text-yellow-400" }} text-center  xs:text-xs text-sm whitespace-nowrap">{{ $invoice->status }}</span>
        </td>
        {{-- options of Kiosks (delete and form) --}}
        {{-- <td class="text-center flex justify-center items-center"> --}}
            <td class="text-center">
                <div class="flex justify-center items-center">
                    <span class="text-center">
                        <svg wire:click="print({{ $invoice->id }})" class="h-6 w-6 xs:w-3 xs:h-3 text-black  hover:text-secondary hover:cursor-pointer" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 8.25H7.5a2.25 2.25 0 00-2.25 2.25v9a2.25 2.25 0 002.25 2.25h9a2.25 2.25 0 002.25-2.25v-9a2.25 2.25 0 00-2.25-2.25H15M9 12l3 3m0 0l3-3m-3 3V2.25"></path>
                          </svg>
                         </span>
                </div>
            </td>
        </tr>
        @endforeach


        </tbody>
        </table>
    </div>
</div>
</div>
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/jquery.fancytable/dist/fancyTable.min.js"></script>



    <script type="text/javascript">
        $(document).ready(function() {
            $(".billing_table").fancyTable({
                sortColumn:0,
            sortable:true,
            searchable:false,
            sortOrder: 'descending',
			globalSearch:false
            });
        });
    </script>
@endpush
