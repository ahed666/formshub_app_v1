


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

            <div class="2xl:col-span-7 xl:col-span-7 lg:col-span-7 md:col-span-7 sm:col-span-7 xs:col-span-7    pt-2 pl-[14px] pr-[14px] pb-2  xs:px-0   ">
                <div class=" ">
                    <div class="flex justify-between   items-center mb-1 w-1/2">
                        <div class="flex justify-center items-center">

                            <div class="relative">
                                <input onkeydown="handleKey_linkedKiosks(event)" id="search_linkedKiosks" class="block w-[400px] p-1 h-10 pl-10 text-sm text-gray-900 border
                                border-gray-300 rounded-lg bg-gray-50
                                " placeholder="Search in account id ..." required>
                                <button onclick="resetsearch_linkedKiosks()" type="button" class="text-white absolute right-[2px] bottom-[2px]   focus:ring-0
                                focus:outline-none  font-medium rounded-lg text-sm px-4 py-2
                                "><svg class="w-6 h-6 text-black" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                                </svg></button>
                            </div>
                            <button onclick="searching_linkedKiosks()"  type="button" class="inline-flex items-center h-6 px-1 bg-secondary_blue whitespace-nowrap
                            border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-secondary_1
                            active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition ml-3"  >
                                {{ _('search') }}
                            </button>
                        </div>
                        <div class="ml-14">
                            <h1 class="text-md">{{ __('Linked Kiosks') }}</h1>
                        </div>

                    </div>
                    <div id="linkedKiosks_table"  class="w-full bg-white rounded-[0.5rem] overflow-auto max-h-[400px] min-h-[400px] ">

                    </div>
                </div>
                <div class="my-2 border border-gray-300"></div>
                <div class=" ">
                    <div class="flex justify-between   items-center mb-1 w-1/2">
                        <div class="flex justify-center items-center">
                            <div class="relative">
                                <input onkeydown="handleKey(event)" id="search" class="block w-[400px] p-1 h-10 pl-10 text-sm text-gray-900 border
                                border-gray-300 rounded-lg bg-gray-50
                                " placeholder="Search in device code ..." required>
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
                        <div class="ml-14">
                            <h1 class="text-md">{{ __('All Kiosks') }}</h1>
                        </div>

                    </div>
                    <div id="kiosks_table"  class="w-full bg-white rounded-[0.5rem] overflow-auto max-h-[400px] min-h-[400px]">

                    </div>
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
</script>

{{-- linked kiosks --}}
<script>
 var linkedKiosks = {!! json_encode($linkedkiosks->toArray(), JSON_HEX_TAG) !!};


    if(linkedKiosks.length>0)
    InitiallinkedKiosksTable(linkedKiosks);

    function handleKey_linkedKiosks(event) {
        if (event.key === "Enter") {
            searching_linkedKiosks()
        } else if (event.key === "Escape") {
            resetsearch_linkedKiosks();
        }
    }
    function searching_linkedKiosks(){
        var new_linkedKiosks=[];

        var text =document.getElementById('search_linkedKiosks').value;
        if(text.match(/^\s*$/))
            {
                InitiallinkedKiosksTable(linkedKiosks);
            }
        else
        {
            linkedKiosks.forEach(kiosk => {
                             console.log(kiosk);
                            if('AC-'+kiosk.account_id==text||kiosk.account_id==text)
                            new_linkedKiosks.push(kiosk);

                    });
                    InitiallinkedKiosksTable(new_linkedKiosks);
        }
    }
 // intial todo table
    function InitiallinkedKiosksTable(linkedKiosks){



        linkedKiosks_table=document.getElementById('linkedKiosks_table');
        linkedKiosks_table.innerHTML='';
        linkedKiosks_table.innerHTML+=`
            <table  class="linkedKiosks_table table-fixed  w-full rounded-xl   " >

                <thead class="h-10">
                    <tr class="  border-b-[1px] border-t-[1px] p-1  bg-secondary_blue text-white ">


                        <th data-sortas="numeric" class=" sticky top-0 px-4 py-2 bg-secondary_blue ml-1 mr-1 w-1/5 text-sm xs:text-xs text-center "  >Account ID</th>
                        <th data-sortas="numeric" class="sticky top-0 px-4 py-2 bg-secondary_blue ml-1 mr-1 w-1/5 text-sm xs:text-xs text-center" >Device Code</th>
                        <th data-sortas="datetime" class="sticky top-0 px-4 py-2 bg-secondary_blue ml-1 mr-1 w-1/5 text-sm xs:text-xs text-center" >Kiosk Linked Date</th>
                        <th data-sortas="datetime" class="sticky top-0 px-4 py-2 bg-secondary_blue ml-1 mr-1 w-1/5 text-sm xs:text-xs text-center" >Last Update</th>
                    </tr>
                </thead>
                <tbody id="linkedKiosks_table_body" class="bg-white " >
                </tbody>
            </table>

         `;
         linkedKiosks_table_body=document.getElementById('linkedKiosks_table_body');
         linkedKiosks.forEach(function(kiosk,i) {

            bg_custom=i%2==0?"bg-white":"bg-slate-50";
            linkedKiosks_table_body.innerHTML+=`
                <tr class="hover:border-2 hover:border-secondary_blue hover:z-20 hover:shadow h-10 h-10 min-h-10 max-h-10 w-full   p-1 border-b-[1px] border-gray-200">

                <td data-sortvalue="${ kiosk.account_id }" class="text-center px-14">
                    <div  class=" whitespace-nowrap p-1 rounded-[0.5rem] text-sm xs:text-xs ">
                        <span class="">
                        AC-${ kiosk.account_id }</span>
                    </div>
                </td>

                <td data-sortvalue="${ kiosk.device_code }" class="text-center ">
                    <div data-bs-toggle="tooltip"  data-bs-html="true" title="${ kiosk.device_code}" class="hover:cursor-pointer min-h-[40px] max-h-[40px] overflow-hidden truncate flex justify-center items-center">
                    <span  class="truncate text-sm xs:text-xs">
                    ${kiosk.device_code}</span>
                    </div>
                </td>

                <td data-sortvalue="${ kiosk.created_at }" class="text-center ">
                    <div data-bs-toggle="tooltip"  data-bs-html="true" title="${formatDate(kiosk.created_at)}" class="hover:cursor-pointer min-h-[40px] max-h-[40px] overflow-hidden truncate flex justify-center items-center">
                    <span  class="truncate text-sm xs:text-xs ${kiosk.today?'font-bold':''}">
                        ${formatDate(kiosk.created_at)}</span>
                    </div>
                </td>
                <td data-sortvalue="${ kiosk.updated_at }" class="text-center ">
                    <div  data-bs-toggle="tooltip"  data-bs-html="true" title="${formatDate(kiosk.updated_at)}" class="hover:cursor-pointer min-h-[40px] max-h-[40px] overflow-hidden truncate flex justify-center items-center">
                    <span  class="truncate text-sm xs:text-xs">
                        ${formatDate(kiosk.updated_at)}</span>
                    </div>
                </td>



                </tr>
            `;

         });

        $(".linkedKiosks_table").fancyTable({
			sortColumn:4,
            sortable:true,
            sortOrder: 'descending',
            searchable:false,
			globalSearch:false
		});
    }

    function resetsearch_linkedKiosks(){
        document.getElementById('search_linkedKiosks').value="";
        InitiallinkedKiosksTable(linkedKiosks);
    }

</script>
{{-- kiosks --}}
<script>
    var kiosks = {!! json_encode($kiosks->toArray(), JSON_HEX_TAG) !!};


       if(kiosks.length>0)
       InitialKioskTable(kiosks);

       function handleKey(event) {
           if (event.key === "Enter") {
               searching()
           } else if (event.key === "Escape") {
               resetsearch();
           }
       }
       function searching(){
           var new_Forms=[];

           var text =document.getElementById('search').value;
           if(text.match(/^\s*$/))
               {
                   InitialKioskTable(kiosks);
               }
           else
           {
               kiosks.forEach(kiosk => {

                               if(kiosk.device_code==text)
                               new_Forms.push(kiosk);

                       });
                       InitialKioskTable(new_Forms);
           }
       }
    // intial todo table
       function InitialKioskTable(kiosks){



           kiosks_table=document.getElementById('kiosks_table');
           kiosks_table.innerHTML='';
           kiosks_table.innerHTML+=`
               <table  class="kiosks_table table-fixed  w-full rounded-xl   " >

                   <thead class="h-10">
                       <tr class="  border-b-[1px] border-t-[1px] p-1  bg-secondary_blue text-white ">


                           <th  data-sortas="numeric" class=" sticky top-0 px-4 py-2 bg-secondary_blue ml-1 mr-1 w-1/5 text-sm xs:text-xs text-center "  >ID</th>
                           <th data-sortas="numeric" class="sticky top-0 px-4 py-2 bg-secondary_blue ml-1 mr-1 w-1/5 text-sm xs:text-xs text-center" >Device Code</th>
                           <th data-sortas="numeric" class="sticky top-0 px-4 py-2 bg-secondary_blue ml-1 mr-1 w-1/5 text-sm xs:text-xs text-center" >Device Model</th>
                           <th data-sortas="numeric" class="sticky top-0 px-4 py-2 bg-secondary_blue ml-1 mr-1 w-1/5 text-sm xs:text-xs text-center" >App Version</th>

                           <th data-sortas="numeric" class="sticky top-0 px-4 py-2 bg-secondary_blue ml-1 mr-1 w-1/5 text-sm xs:text-xs text-center" >Ready To Connect</th>
                           <th data-sortas="datetime" class="sticky top-0 px-4 py-2 bg-secondary_blue ml-1 mr-1 w-1/5 text-sm xs:text-xs text-center" >Kiosk Creation Date</th>
                           <th data-sortas="datetime" class="sticky top-0 px-4 py-2 bg-secondary_blue ml-1 mr-1 w-1/5 text-sm xs:text-xs text-center" >Last Update</th>
                       </tr>
                   </thead>
                   <tbody id="kiosks_table_body" class="bg-white " >
                   </tbody>
               </table>

            `;
            kiosks_table_body=document.getElementById('kiosks_table_body');
            kiosks.forEach(function(kiosk,i) {

               bg_custom=i%2==0?"bg-white":"bg-slate-50";
               kiosks_table_body.innerHTML+=`
                   <tr class="hover:border-2 hover:border-secondary_blue hover:z-20 hover:shadow h-10 h-10 min-h-10 max-h-10 w-full   p-1 border-b-[1px] border-gray-200">

                   <td data-sortvalue="${ kiosk.id }" class="text-center px-14">
                       <div  class=" whitespace-nowrap p-1 rounded-[0.5rem] text-sm xs:text-xs ">
                           <span class="">
                           ${ kiosk.id }</span>
                       </div>
                   </td>

                   <td data-sortvalue="${ kiosk.device_code }" class="text-center ">
                       <div data-bs-toggle="tooltip"  data-bs-html="true" title="${ kiosk.device_code}" class="hover:cursor-pointer min-h-[40px] max-h-[40px] overflow-hidden truncate flex justify-center items-center">
                       <span  class="truncate text-sm xs:text-xs">
                       ${kiosk.device_code}</span>
                       </div>
                   </td>
                   <td data-sortvalue="${ kiosk.device_model }" class="text-center ">
                       <div data-bs-toggle="tooltip"  data-bs-html="true" title="${ kiosk.device_model}" class="hover:cursor-pointer min-h-[40px] max-h-[40px] overflow-hidden truncate flex justify-center items-center">
                       <span  class="truncate text-sm xs:text-xs">
                       ${kiosk.device_model}</span>
                       </div>
                   </td>
                   <td data-sortvalue="${ kiosk.app_version }" class="text-center ">
                       <div data-bs-toggle="tooltip"  data-bs-html="true" title="${ kiosk.app_version}" class="hover:cursor-pointer min-h-[40px] max-h-[40px] overflow-hidden truncate flex justify-center items-center">
                       <span  class="truncate text-sm xs:text-xs">
                       ${kiosk.app_version}</span>
                       </div>
                   </td>
                   <td data-sortvalue="${ kiosk.ready_connect }" class="text-center ">
                       <div data-bs-toggle="tooltip"  data-bs-html="true" title="${ kiosk.ready_connect===1}" class="hover:cursor-pointer min-h-[40px] max-h-[40px] overflow-hidden truncate flex justify-center items-center">
                       <span  class="truncate text-sm xs:text-xs ${kiosk.ready_connect?'text-valid':'text-primary_red'}">
                       ${kiosk.ready_connect===1}</span>
                       </div>
                   </td>
                   <td data-sortvalue="${ formatDate(kiosk.created_at) }" class="text-center ">
                       <div data-bs-toggle="tooltip"  data-bs-html="true" title="${formatDate(kiosk.created_at)}" class="hover:cursor-pointer min-h-[40px] max-h-[40px] overflow-hidden truncate flex justify-center items-center">
                       <span  class="truncate text-sm xs:text-xs ${kiosk.today?'font-bold':''}">
                           ${formatDate(kiosk.created_at)}</span>
                       </div>
                   </td>
                   <td data-sortvalue="${ formatDate(kiosk.updated_at) }" class="text-center ">
                       <div data-bs-toggle="tooltip"  data-bs-html="true" title="${formatDate(kiosk.updated_at)}" class="hover:cursor-pointer min-h-[40px] max-h-[40px] overflow-hidden truncate flex justify-center items-center">
                       <span  class="truncate text-sm xs:text-xs">
                           ${formatDate(kiosk.updated_at)}</span>
                       </div>
                   </td>



                   </tr>
               `;

            });

           $(".kiosks_table").fancyTable({
               sortColumn:4,
               sortOrder: 'descending',
               sortable:true,
               searchable:false,
               globalSearch:false
           });
       }

       function resetsearch(){
           document.getElementById('search').value="";
           InitialKioskTable(kiosks);
       }

</script>
    {{-- menubar for each form in owl carousel  --}}



    @stack('scripts')
    @stack('modals')
</body>

</html>
