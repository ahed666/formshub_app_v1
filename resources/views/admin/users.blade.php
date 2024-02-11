


<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('admin.includes.head')


</head>
<body class="font-sans antialiased">
    <div class="min-h-screen max-h-fit bg-gray-100 dark:bg-gray-900">
        <div class=" grid 2xl:grid-cols-8 xl:grid-cols-8 lg:grid-cols-8 md:grid-cols-1 sm:grid-cols-1 xs:grid-cols-1  gap-1 xs:gap-0 md:gap-0 sm:gap-0">
            <div class="z-[100]  2xl:col-span-1 xl:col-span-1 lg:col-span-1 md:col-span-1 sm:col-span-1 xs:col-span-1 lg:mr-2 xl:mr-2 sm:mb-2 md:row-span-2 ">
                @include('admin.layouts.navigation')
            </div>

            <div class="2xl:col-span-7 xl:col-span-7 lg:col-span-7 md:col-span-7 sm:col-span-7 xs:col-span-7   pt-2 pl-[14px] pr-[14px] pb-2  xs:px-0   ">
                <div class="flex justify-start items-center mb-1">

                        <div class="relative">
                            <input onkeydown="handleKey(event)" id="search" class="block w-[400px] p-1 h-10 pl-10 text-sm text-gray-900 border
                            border-gray-300 rounded-lg bg-gray-50" placeholder="Search in user id" required>
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
                <div id="accounts_table"  class="w-full bg-white rounded-[0.5rem] overflow-auto max-h-[90vh]">

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
 var users = {!! json_encode($users->toArray(), JSON_HEX_TAG) !!};

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
    if(users.length>0)
    InitialUserTable(users);

    function handleKey(event) {
        if (event.key === "Enter") {
            searching()
        } else if (event.key === "Escape") {
            resetsearch();
        }
    }
    function searching(){
        var new_users=[];

        var text =document.getElementById('search').value;
        if(text.match(/^\s*$/))
            {
                InitialUserTable(users);
            }
        else
        {
            users.forEach(user => {

                            if(user.id==text)
                            new_users.push(user);

                    });
                    InitialUserTable(new_users);
        }
    }
 // intial todo table
    function InitialUserTable(users){



        accounts_table=document.getElementById('accounts_table');
        accounts_table.innerHTML='';
        accounts_table.innerHTML+=`
            <table  class="accounts_table table-fixed  w-full rounded-xl   " >

                <thead class="h-10">
                    <tr class="  border-b-[1px] border-t-[1px] p-1  bg-secondary_blue text-white ">


                        <th data-sortas="numeric"  class=" sticky top-0 px-4 py-2 bg-secondary_blue ml-1 mr-1 w-1/5 text-sm xs:text-xs text-center "  >User ID</th>
                        <th class="sticky top-0 px-4 py-2 bg-secondary_blue ml-1 mr-1 w-1/5 text-sm xs:text-xs text-center" >Name</th>
                        <th class="sticky top-0 px-4 py-2 bg-secondary_blue ml-1 mr-1 w-1/5 text-sm xs:text-xs text-center" >Email</th>
                        <th class="sticky top-0 px-4 py-2 bg-secondary_blue ml-1 mr-1 w-1/5 text-sm xs:text-xs text-center" >Mobile Number</th>
                        <th class="sticky top-0 px-4 py-2 bg-secondary_blue ml-1 mr-1 w-1/5 text-sm xs:text-xs text-center" >Verified</th>
                        <th  class=" sticky top-0 px-4 py-2 bg-secondary_blue ml-1 mr-1 w-1/5 text-sm xs:text-xs text-center">E.S Notification</th>
                        <th class="sticky top-0 px-4 py-2 bg-secondary_blue ml-1 mr-1 w-1/5 text-sm xs:text-xs text-center" >E.S Events</th>
                        <th class="sticky top-0 px-4 py-2 bg-secondary_blue ml-1 mr-1 w-1/5 text-sm xs:text-xs text-center" >E.S Security</th>
                        <th class="sticky top-0 px-4 py-2 bg-secondary_blue ml-1 mr-1 w-1/5 text-sm xs:text-xs text-center" >E.S Payment</th>
                        <th data-sortas="datetime" class="sticky top-0 px-4 py-2 bg-secondary_blue ml-1 mr-1 w-1/5 text-sm xs:text-xs text-center" >User Creation Date</th>
                        <th data-sortas="datetime" class="sticky top-0 px-4 py-2 bg-secondary_blue ml-1 mr-1 w-1/5 text-sm xs:text-xs text-center" >Last Update</th>
                    </tr>
                </thead>
                <tbody id="accounts_table_body" class="bg-white " >
                </tbody>
            </table>

         `;
         accounts_table_body=document.getElementById('accounts_table_body');
         users.forEach(function(user,i) {

            bg_custom=i%2==0?"bg-white":"bg-slate-50";
            accounts_table_body.innerHTML+=`
                <tr class=" hover:border-2 hover:border-secondary_blue hover:z-20 hover:shadow h-10 h-10 min-h-10 max-h-10 w-full   p-1 border-b-[1px] border-gray-200">

                <td data-sortvalue="${ user.id }" class="text-center px-14">
                    <div  class=" whitespace-nowrap p-1 rounded-[0.5rem] text-sm xs:text-xs ">
                        <span class="">
                        ${ user.id }</span>
                    </div>
                </td>


                <td class="text-center ">
                    <div data-bs-toggle="tooltip"  data-bs-html="true" title="${ user.name }" class="hover:cursor-pointer min-h-[40px] max-h-[40px] overflow-hidden truncate flex justify-center items-center">
                    <span  class="truncate text-sm xs:text-xs">
                    ${user.name}</span>
                    </div>
                </td>
                <td class="text-center ">
                    <div data-bs-toggle="tooltip"  data-bs-html="true" title="${ user.email }" class="hover:cursor-pointer min-h-[40px] max-h-[40px] overflow-hidden truncate flex justify-center items-center">
                    <span  class="truncate text-sm xs:text-xs">
                    ${user.email}</span>
                    </div>
                </td>
                <td class="text-center ">
                    <div data-bs-toggle="tooltip"  data-bs-html="true" title="${ user.mobile_number }" class="hover:cursor-pointer min-h-[40px] max-h-[40px] overflow-hidden truncate flex justify-center items-center">
                    <span  class="truncate text-sm xs:text-xs">
                    ${user.mobile_number}</span>
                    </div>
                </td>
                <td class="text-center ">
                    <div data-bs-toggle="tooltip"  data-bs-html="true" title="${ user.email_verified_at==null?user.email_verified_at:formatDate(user.email_verified_at) }" class="hover:cursor-pointer min-h-[40px] max-h-[40px] overflow-hidden truncate flex justify-center items-center">
                    <span  class="truncate text-sm xs:text-xs ${user.email_verified_at==null?'text-primary_red':'text-valid'}">
                    ${user.email_verified_at==null?user.email_verified_at:formatDate(user.email_verified_at)}</span>
                    </div>
                </td>
                <td class="text-center ">
                    <div data-bs-toggle="tooltip"  data-bs-html="true" title="${ user.email_sub_notification===1 }" class="hover:cursor-pointer min-h-[40px] max-h-[40px] overflow-hidden truncate flex justify-center items-center">
                    <span  class="truncate text-sm xs:text-xs">
                    ${user.email_sub_notification===1}</span>
                    </div>
                </td>
                <td class="text-center ">
                    <div data-bs-toggle="tooltip"  data-bs-html="true" title="${ user.email_sub_offers_events===1 }" class="hover:cursor-pointer min-h-[40px] max-h-[40px] overflow-hidden truncate flex justify-center items-center">
                    <span  class="truncate text-sm xs:text-xs">
                    ${user.email_sub_offers_events===1}</span>
                    </div>
                </td>
                <td class="text-center ">
                    <div data-bs-toggle="tooltip"  data-bs-html="true" title="${ user.email_sub_security===1 }" class="hover:cursor-pointer min-h-[40px] max-h-[40px] overflow-hidden truncate flex justify-center items-center">
                    <span  class="truncate text-sm xs:text-xs">
                    ${user.email_sub_security===1}</span>
                    </div>
                </td>
                <td class="text-center ">
                    <div data-bs-toggle="tooltip"  data-bs-html="true" title="${ user.email_sub_payment_subscriptions===1 }" class="hover:cursor-pointer min-h-[40px] max-h-[40px] overflow-hidden truncate flex justify-center items-center">
                    <span  class="truncate text-sm xs:text-xs">
                    ${user.email_sub_payment_subscriptions===1}</span>
                    </div>
                </td>
                <td data-sortvalue="${ user.created_at }" class="text-center ">
                    <div data-bs-toggle="tooltip"  data-bs-html="true" title="${ formatDate(user.created_at) }" class="hover:cursor-pointer min-h-[40px] max-h-[40px] overflow-hidden truncate flex justify-center items-center">
                    <span  class="truncate text-sm xs:text-xs ${user.today?'font-bold':''}">
                    ${formatDate(user.created_at)}</span>
                    </div>
                </td>
                <td data-sortvalue="${ user.updated_at }" class="text-center ">
                    <div data-bs-toggle="tooltip"  data-bs-html="true" title="${ formatDate(user.updated_at) }" class="hover:cursor-pointer min-h-[40px] max-h-[40px] overflow-hidden truncate flex justify-center items-center">
                    <span  class="truncate text-sm xs:text-xs">
                    ${formatDate(user.updated_at)}</span>
                    </div>
                </td>


                </tr>
            `;

         });

        $(".accounts_table").fancyTable({
			sortColumn:0,
            sortable:true,
            sortOrder: 'descending',
            searchable:false,
			globalSearch:false
		});
    }

    function resetsearch(){
        document.getElementById('search').value="";
        InitialUserTable(users);
    }

</script>


    {{-- menubar for each form in owl carousel  --}}



    @stack('scripts')
    @stack('modals')
</body>

</html>
