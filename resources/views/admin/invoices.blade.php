


<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('admin.includes.head')


</head>
<body class="font-sans antialiased">
    <div class="min-h-screen max-h-fit bg-gray-100 ">
        <div class=" grid 2xl:grid-cols-8 xl:grid-cols-8 lg:grid-cols-8 md:grid-cols-1 sm:grid-cols-1 xs:grid-cols-1  gap-1 xs:gap-0 md:gap-0 sm:gap-0">
            <div class="z-[100]  2xl:col-span-1 xl:col-span-1 lg:col-span-1 md:col-span-1 sm:col-span-1 xs:col-span-1 lg:mr-2 xl:mr-2 sm:mb-2 md:row-span-2 ">
                @include('admin.layouts.navigation')
            </div>

            <div class="2xl:col-span-7 xl:col-span-7 lg:col-span-7 md:col-span-7 sm:col-span-7 xs:col-span-7   pt-2 pl-[14px] pr-[14px] pb-2  xs:px-0   ">
                <div class="flex justify-start items-center mb-1">

                        <div class="relative">
                            <input onkeydown="handleKey(event)" id="search" class="block w-[400px] p-1 h-10 pl-10 text-sm text-gray-900 border
                            border-gray-300 rounded-lg bg-gray-50
                            " placeholder="Search in invoice no" required>
                            <button onclick="resetsearch()" type="button" class="text-white absolute right-[2px] bottom-[2px]   focus:ring-0
                            focus:outline-none  font-medium rounded-lg text-sm px-4 py-2
                            "><svg class="w-6 h-6 text-black" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                            </svg></button>
                        </div>
                        <button onclick="searching()"  type="button" class="inline-flex items-center h-6 px-1 bg-secondary_blue whitespace-nowrap
                        border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-secondary_1
                        active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition ml-3"  >
                            {{ _('search') }}
                        </button>


                </div>
                <div id="invoices_table"  class="w-full bg-white rounded-[0.5rem] overflow-auto max-h-[90vh]">

                 </div>
            </div>
        </div>
    </div>

    @livewireScripts()
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



<script>
 var invoices = {!! json_encode($invoices->toArray(), JSON_HEX_TAG) !!};
       // convert timestamp to date
    function formatDate(date) {
            var d = new Date(date),
            month = '' + (d.getMonth() + 1),
            day = '' + d.getDate(),
            year = d.getFullYear();

            if (month.length < 2)
                month = '0' + month;
            if (day.length < 2)
                day = '0' + day;

            return [year, month, day].join('-');
    }

    if(invoices.length>0)
    InitialInvoicesTable(invoices);

    function handleKey(event) {
        if (event.key === "Enter") {
            searching()
        } else if (event.key === "Escape") {
            resetsearch();
        }
    }
    function searching(){
        var new_invoices=[];

        var text =document.getElementById('search').value;
        if(text.match(/^\s*$/))
            {
                InitialInvoicesTable(invoices);
            }
        else
        {
            invoices.forEach(invoice => {

                            if(invoice.invoice_no==text)
                            new_invoices.push(invoice);

                    });
                    InitialInvoicesTable(new_invoices);
        }
    }
 // intial todo table
    function InitialInvoicesTable(invoices){



        invoices_table=document.getElementById('invoices_table');
        invoices_table.innerHTML='';
        invoices_table.innerHTML+=`
            <table  class="invoices_table table-fixed overflow-auto  w-full rounded-xl   " >

                <thead class="h-10">
                    <tr class="  border-b-[1px] border-t-[1px] p-1  bg-secondary_blue text-white ">


                        <th data-sortas="numeric"   class=" sticky top-0 px-4 py-2 bg-secondary_blue ml-1 mr-1 w-1/5 text-sm xs:text-xs text-center "  >Invoice No</th>
                        <th class="sticky top-0 px-4 py-2 bg-secondary_blue ml-1 mr-1 w-1/5 text-sm xs:text-xs text-center" >Invoice Description</th>
                        <th data-sortas="numeric" class="sticky top-0 px-4 py-2 bg-secondary_blue ml-1 mr-1 w-1/5 text-sm xs:text-xs text-center" >Account ID</th>
                        <th class="sticky top-0 px-4 py-2 bg-secondary_blue ml-1 mr-1 w-1/5 text-sm xs:text-xs text-center" >Business Name</th>
                        <th class="sticky top-0 px-4 py-2 bg-secondary_blue ml-1 mr-1 w-1/5 text-sm xs:text-xs text-center" >Location</th>
                        <th class="sticky top-0 px-4 py-2 bg-secondary_blue ml-1 mr-1 w-1/5 text-sm xs:text-xs text-center" >Price ex TAX</th>
                        <th class="sticky top-0 px-4 py-2 bg-secondary_blue ml-1 mr-1 w-1/5 text-sm xs:text-xs text-center" >TAX</th>
                        <th class="sticky top-0 px-4 py-2 bg-secondary_blue ml-1 mr-1 w-1/5 text-sm xs:text-xs text-center" >Price in TAX</th>
                        <th class="sticky top-0 px-4 py-2 bg-secondary_blue ml-1 mr-1 w-1/5 text-sm xs:text-xs text-center" >TRN</th>
                        <th data-sortas="datetime" class="sticky top-0 px-4 py-2 bg-secondary_blue ml-1 mr-1 w-1/5 text-sm xs:text-xs text-center" >Invoice Date</th>
                        <th class="sticky top-0 px-4 py-2 bg-secondary_blue ml-1 mr-1 w-1/5 text-sm xs:text-xs text-center" >Download</th>
                    </tr>
                </thead>
                <tbody id="invoices_table_body" class="bg-white " >
                </tbody>
            </table>

         `;
         invoices_table_body=document.getElementById('invoices_table_body');
         console.log(invoices);
         invoices.forEach(function(invoice,i) {
            const createdAtTimestamp = new Date(invoice.created_at);
            bg_custom=i%2==0?"bg-white":"bg-slate-50";
            invoices_table_body.innerHTML+=`
                <tr class="hover:border-2 hover:border-secondary_blue hover:z-20 hover:shadow h-10 h-10 min-h-10 max-h-10 w-full   p-1 border-b-[1px] border-gray-200">



                <td data-sortvalue="${ invoice.invoice_no }" class="text-center ">
                    <div data-bs-toggle="tooltip"  data-bs-html="true" title="FHINV-${invoice.invoice_no}" class="hover:cursor-pointer min-h-[40px] max-h-[40px] overflow-hidden truncate flex justify-center items-center">
                    <span  class="truncate text-sm xs:text-xs">
                        FHINV-${invoice.invoice_no}</span>
                    </div>
                </td>
                <td class="text-center ">
                    <div data-bs-toggle="tooltip"  data-bs-html="true" title="${ invoice.invoice_description }" class="hover:cursor-pointer min-h-[40px] max-h-[40px] overflow-hidden truncate flex justify-center items-center">
                    <span  class="truncate text-sm xs:text-xs">
                    ${invoice.invoice_description}</span>
                    </div>
                </td>
                <td data-sortvalue="${ invoice.account_id }" class="text-center ">
                    <div data-bs-toggle="tooltip"  data-bs-html="true" title="${ invoice.account_id }" class="hover:cursor-pointer min-h-[40px] max-h-[40px] overflow-hidden truncate flex justify-center items-center">
                    <span  class="truncate text-sm xs:text-xs">
                        AC-${invoice.account_id}</span>
                    </div>
                </td>
                <td class="text-center ">
                    <div data-bs-toggle="tooltip"  data-bs-html="true" title="${ invoice.business_name }" class="hover:cursor-pointer min-h-[40px] max-h-[40px] overflow-hidden truncate flex justify-center items-center">
                    <span  class="truncate text-sm xs:text-xs">
                    ${invoice.business_name}</span>
                    </div>
                </td>
                <td class="text-center ">
                    <div data-bs-toggle="tooltip"  data-bs-html="true" title="${ invoice.location }" class="hover:cursor-pointer min-h-[40px] max-h-[40px] overflow-hidden truncate flex justify-center items-center">
                    <span  class="truncate text-sm xs:text-xs">
                    ${invoice.location}</span>
                    </div>
                </td>
                <td class="text-center ">
                    <div data-bs-toggle="tooltip"  data-bs-html="true" title="${ invoice.price_ex_tax }" class="hover:cursor-pointer min-h-[40px] max-h-[40px] overflow-hidden truncate flex justify-center items-center">
                    <span  class="truncate text-sm xs:text-xs">
                    ${invoice.price_ex_tax}</span>
                    </div>
                </td>
                <td class="text-center ">
                    <div data-bs-toggle="tooltip"  data-bs-html="true" title="${ invoice.tax }%" class="hover:cursor-pointer min-h-[40px] max-h-[40px] overflow-hidden truncate flex justify-center items-center">
                    <span  class="truncate text-sm xs:text-xs">
                    ${invoice.tax}%</span>
                    </div>
                </td>
                <td class="text-center ">
                    <div data-bs-toggle="tooltip"  data-bs-html="true" title="${ invoice.price_in_tax }" class="hover:cursor-pointer min-h-[40px] max-h-[40px] overflow-hidden truncate flex justify-center items-center">
                    <span  class="truncate text-sm xs:text-xs">
                    ${invoice.price_in_tax}</span>
                    </div>
                </td>
                <td class="text-center ">
                    <div data-bs-toggle="tooltip"  data-bs-html="true" title="${ invoice.trn }" class="hover:cursor-pointer min-h-[40px] max-h-[40px] overflow-hidden truncate flex justify-center items-center">
                    <span  class="truncate text-sm xs:text-xs">
                    ${invoice.trn}</span>
                    </div>
                </td>
                <td data-sortvalue="${ invoice.invoice_date}" class="text-center ">
                    <div data-bs-toggle="tooltip"  data-bs-html="true" title="${ formatDate(invoice.invoice_date) }" class="hover:cursor-pointer min-h-[40px] max-h-[40px] overflow-hidden truncate flex justify-center items-center">
                    <span  class="truncate text-sm xs:text-xs  ${invoice.today?'font-bold':''}">
                    ${formatDate(invoice.invoice_date)}</span>
                    </div>
                </td>
                <td class="text-center">
                <div class="flex justify-center items-center">
                    <span class="text-center">
                        <svg onclick="print(${ invoice.id })" class="h-6 w-6 text-black  hover:text-secondary hover:cursor-pointer" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 8.25H7.5a2.25 2.25 0 00-2.25 2.25v9a2.25 2.25 0 002.25 2.25h9a2.25 2.25 0 002.25-2.25v-9a2.25 2.25 0 00-2.25-2.25H15M9 12l3 3m0 0l3-3m-3 3V2.25"></path>
                          </svg>
                         </span>
                </div>
                </td>

                </tr>
            `;

         });

        $(".invoices_table").fancyTable({
			sortColumn:0,
            sortOrder: 'descending',
            sortable:true,
            searchable:false,
			globalSearch:false
		});
    }

    function resetsearch(){
        document.getElementById('search').value="";
        InitialInvoicesTable(invoices);
    }
  function print(id){
    window.location.href = '/admin-center/printinvoice/' + id;
  }
</script>


    {{-- menubar for each Form  in owl carousel  --}}



    @stack('scripts')
    @stack('modals')
</body>

</html>
