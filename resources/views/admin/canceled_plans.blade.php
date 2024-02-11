


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
                                <input onkeydown="handleKey_canceledPlans(event)" id="search_canceledPlans" class="block w-[400px] p-1 h-10 pl-10 text-sm text-gray-900 border
                                border-gray-300 rounded-lg bg-gray-50
                                " placeholder="Search in account id" required>
                                <button onclick="resetsearch_canceledPlans()" type="button" class="text-white absolute right-[2px] bottom-[2px]   focus:ring-0
                                focus:outline-none  font-medium rounded-lg text-sm px-4 py-2
                                "><svg class="w-6 h-6 text-black" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                                </svg></button>
                            </div>
                            <button onclick="searching_canceledPlans()"  type="button" class="inline-flex items-center h-6 px-1 bg-secondary_blue whitespace-nowrap
                            border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-secondary_1
                            active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition ml-3"  >
                                {{ _('search') }}
                            </button>
                        </div>


                    </div>
                    <div id="canceledPlans_table"  class="w-full bg-white rounded-[0.5rem] overflow-auto max-h-[400px] min-h-[400px]">

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

{{-- canceledPlans --}}
<script>
 var canceledPlans = {!! json_encode($canceledPlans->toArray(), JSON_HEX_TAG) !!};


    if(canceledPlans.length>0)
    InitialcanceledPlansTable(canceledPlans);
    else
    {
    document.getElementById('canceledPlans_table').innerHTML=`
    <div class="flex justify-center items-center p-10">
       <h1>NO Canceled Subscriptions</h1>
    </div>
    `;


    }

    function handleKey_canceledPlans(event) {
        if (event.key === "Enter") {
            searching_canceledPlans()
        } else if (event.key === "Escape") {
            resetsearch_canceledPlans();
        }
    }
    function searching_canceledPlans(){
        var new_canceledPlans=[];

        var text =document.getElementById('search_canceledPlans').value;
        if(text.match(/^\s*$/))
            {
                InitialcanceledPlansTable(canceledPlans);
            }
        else
        {
            canceledPlans.forEach(canceledPlan => {

                            if(canceledPlan.account_id==text)
                            new_canceledPlans.push(canceledPlan);

                    });
                    InitialcanceledPlansTable(new_canceledPlans);
        }
    }

 // intial todo table
 function InitialcanceledPlansTable(canceledPlans){



    canceledPlans_table=document.getElementById('canceledPlans_table');
    canceledPlans_table.innerHTML='';
    canceledPlans_table.innerHTML+=`
        <table  class="canceledPlans_table table-fixed  w-full rounded-xl   " >

            <thead class="h-10">
                <tr class="  border-b-[1px] border-t-[1px] p-1  bg-secondary_blue text-white ">


                    <th data-sortas="numeric" class=" sticky top-0 px-4 py-2 bg-secondary_blue ml-1 mr-1 w-1/5 text-sm xs:text-xs text-center "  >ID</th>
                    <th data-sortas="numeric" class="sticky top-0 px-4 py-2 bg-secondary_blue ml-1 mr-1 w-1/5 text-sm xs:text-xs text-center" >Account ID</th>
                    <th class="sticky top-0 px-4 py-2 bg-secondary_blue ml-1 mr-1 w-1/5 text-sm xs:text-xs text-center" >Canceled by Email</th>

                    <th class="sticky top-0 px-4 py-2 bg-secondary_blue ml-1 mr-1 w-1/5 text-sm xs:text-xs text-center" >Subs Type</th>
                    <th class="sticky top-0 px-4 py-2 bg-secondary_blue ml-1 mr-1 w-1/5 text-sm xs:text-xs text-center" >Responses Category</th>
                    <th data-sortas="numeric" class="sticky top-0 px-4 py-2 bg-secondary_blue ml-1 mr-1 w-1/5 text-sm xs:text-xs text-center" >Num of Responses</th>

                    <th data-sortas="datetime" class="sticky top-0 px-4 py-2 bg-secondary_blue ml-1 mr-1 w-1/5 text-sm xs:text-xs text-center" >Subs Created At</th>
                    <th data-sortas="datetime" class="sticky top-0 px-4 py-2 bg-secondary_blue ml-1 mr-1 w-1/5 text-sm xs:text-xs text-center" >Subs Expiry Date</th>
                    <th data-sortas="datetime" class="sticky top-0 px-4 py-2 bg-secondary_blue ml-1 mr-1 w-1/5 text-sm xs:text-xs text-center" >Canceled At</th>
                </tr>
            </thead>
            <tbody id="canceledPlans_table_body" class="bg-white " >
            </tbody>
        </table>

    `;
    canceledPlans_table_body=document.getElementById('canceledPlans_table_body');
    canceledPlans.forEach(function(plan,i) {

        bg_custom=i%2==0?"bg-white":"bg-slate-50";
        canceledPlans_table_body.innerHTML+=`
            <tr class="hover:border-2 hover:border-secondary_blue hover:z-20 hover:shadow h-10 h-10 min-h-10 max-h-10 w-full   p-1 border-b-[1px] border-gray-200">

            <td data-sortvalue="${ plan.id }" class="text-center px-14">
                <div  class=" whitespace-nowrap p-1 rounded-[0.5rem] text-sm xs:text-xs ">
                    <span class="">
                    ${ plan.id }</span>
                </div>
            </td>

            <td data-sortvalue="${ plan.account_id }" class="text-center ">
                <div data-bs-toggle="tooltip"  data-bs-html="true" title="AC-${ plan.account_id}" class="hover:cursor-pointer min-h-[40px] max-h-[40px] overflow-hidden truncate flex justify-center items-center">
                <span  class="truncate text-sm xs:text-xs">
                AC-${plan.account_id}</span>
                </div>
            </td>
            <td class="text-center ">
                <div data-bs-toggle="tooltip"  data-bs-html="true" title="${ plan.email}" class="hover:cursor-pointer min-h-[40px] max-h-[40px] overflow-hidden truncate flex justify-center items-center">
                <span  class="truncate text-sm xs:text-xs ">
                ${plan.user_email}</span>
                </div>
            </td>
            <td class="text-center ">
                <div data-bs-toggle="tooltip"  data-bs-html="true" title="${ plan.subscription_type}" class="hover:cursor-pointer min-h-[40px] max-h-[40px] overflow-hidden truncate flex justify-center items-center">
                <span  class="truncate text-sm xs:text-xs ">
                ${plan.subscription_type}</span>
                </div>
            </td>
            <td class="text-center ">
                <div data-bs-toggle="tooltip"  data-bs-html="true" title="${ plan.responses_cat_id}" class="hover:cursor-pointer min-h-[40px] max-h-[40px] overflow-hidden truncate flex justify-center items-center">
                <span  class="truncate text-sm xs:text-xs ">
                ${plan.responses_cat_id}</span>
                </div>
            </td>
            <td data-sortvalue="${ plan.num_responses }" class="text-center ">
                <div data-bs-toggle="tooltip"  data-bs-html="true" title="${ plan.num_responses}" class="hover:cursor-pointer min-h-[40px] max-h-[40px] overflow-hidden truncate flex justify-center items-center">
                <span  class="truncate text-sm xs:text-xs ">
                ${plan.num_responses}</span>
                </div>
            </td>


            <td data-sortvalue="${plan.plan_created_at}" class="text-center ">
                <div data-bs-toggle="tooltip"  data-bs-html="true" title="${formatDate(plan.plan_created_at)}" class="hover:cursor-pointer min-h-[40px] max-h-[40px] overflow-hidden truncate flex justify-center items-center">
                <span  class="truncate text-sm xs:text-xs">
                    ${formatDate(plan.plan_created_at)}</span>
                </div>
            </td>
            <td data-sortvalue="${plan.plan_expiry_date}" class="text-center ">
                <div data-bs-toggle="tooltip"  data-bs-html="true" title="${formatDate(plan.plan_expiry_date)}" class="hover:cursor-pointer min-h-[40px] max-h-[40px] overflow-hidden truncate flex justify-center items-center">
                <span  class="truncate text-sm xs:text-xs ">
                    ${formatDate(plan.plan_expiry_date)}</span>
                </div>
            </td>
            <td data-sortvalue="${plan.created_at}" class="text-center ">
                <div data-bs-toggle="tooltip"  data-bs-html="true" title="${formatDate(plan.created_at)}" class="hover:cursor-pointer min-h-[40px] max-h-[40px] overflow-hidden truncate flex justify-center items-center">
                <span  class="truncate text-sm xs:text-xs">
                    ${formatDate(plan.created_at)}</span>
                </div>
            </td>




            </tr>
        `;

    });

    $(".canceledPlans_table").fancyTable({
        sortColumn:8,
        sortable:true,
        sortOrder: 'descending',
        searchable:false,
        globalSearch:false
    });
}
    function resetsearch_canceledPlans(){
        document.getElementById('search_canceledPlans').value="";
        InitialcanceledPlansTable(canceledPlans);
    }

</script>

    {{-- menubar for each form in owl carousel  --}}



    @stack('scripts')
    @stack('modals')
</body>

</html>
