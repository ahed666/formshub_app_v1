


<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <link  rel="stylesheet" href="{{ asset('styles/bootstrap.min.css')}}">

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
                            " placeholder="Search in ticket id" required>
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
                <div id="tickets_table"  class="w-full bg-white rounded-[0.5rem] overflow-auto max-h-[90vh]">

                 </div>
            </div>
        </div>
    </div>
    <div  class="modal fade fixed top-0 left-0 z-[1055]  h-full w-full  " data-backdrop="static" data-keyboard="false" id="show_ticket" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered  min-h-[calc(100%-1rem)] w-full max-w-[800px] translate-y-[-50px] items-center  transition-all duration-10 ease-out-in min-[576px]:mx-auto min-[576px]:mt-7 min-[576px]:min-h-[calc(100%-3.5rem)]" role="document">
        <div class="modal-content  w-full flex-col rounded-md border-none  bg-clip-padding text-current shadow-lg
        outline-none ">
            {{-- header --}}
            <div class="flex items-center justify-between p-4 border-b rounded-t ">
                <div class="flex items-center">
                <h3 class="text-xl font-semibold text-gray-900 ">
                    {{ __(' Show Ticket ') }}
                </h3>

                </div>
                <button type="button"  class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex
                items-center " data-dismiss="modal" aria-label="Close">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0
                    011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                </button>
            </div>
            <div id="show_ticket_body"  class=" 2xl:max-h-[700px] xs:max-h-[400px]">

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
 var tickets = {!! json_encode($tickets->toArray(), JSON_HEX_TAG) !!};

var StatusColors={
        "Open":"primary_red","Pending":"yellow-400","In Progress":"secondary_blue","Closed":"valid"
};

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
    if(tickets.length>0)
    InitialTicketTable(tickets);

    function handleKey(event) {
        if (event.key === "Enter") {
            searching()
        } else if (event.key === "Escape") {
            resetsearch();
        }
    }
    function searching(){
        var new_tickets=[];

        var text =document.getElementById('search').value;
        if(text.match(/^\s*$/))
            {
                InitialTicketTable(tickets);
            }
        else
        {
            tickets.forEach(ticket => {

                            if(ticket.id==text)
                            new_tickets.push(ticket);

                    });
                    InitialTicketTable(new_tickets);
        }
    }
 // intial todo table
    function InitialTicketTable(tickets){



        tickets_table=document.getElementById('tickets_table');
        tickets_table.innerHTML='';
        tickets_table.innerHTML+=`
            <table  class="tickets_table table-fixed  w-full rounded-xl   " >

                <thead class="h-10">
                    <tr class="  border-b-[1px] border-t-[1px] p-1  bg-secondary_blue text-white ">


                        <th  data-sortas="numeric" class=" sticky top-0 px-4 py-2 bg-secondary_blue ml-1 mr-1 w-1/5 text-sm xs:text-xs text-center "  >ID</th>
                        <th data-sortas="numeric" class="sticky top-0 px-4 py-2 bg-secondary_blue ml-1 mr-1 w-1/5 text-sm xs:text-xs text-center" >Account ID</th>
                        <th class="sticky top-0 px-4 py-2 bg-secondary_blue ml-1 mr-1 w-1/5 text-sm xs:text-xs text-center" >Target</th>
                        <th class="sticky top-0 px-4 py-2 bg-secondary_blue ml-1 mr-1 w-1/5 text-sm xs:text-xs text-center" >Subject</th>
                        <th class="sticky top-0 px-4 py-2 bg-secondary_blue ml-1 mr-1 w-1/5 text-sm xs:text-xs text-center" >Description</th>
                        <th  class=" sticky top-0 px-4 py-2 bg-secondary_blue ml-1 mr-1 w-1/5 text-sm xs:text-xs text-center">Status</th>
                        <th class="sticky top-0 px-4 py-2 bg-secondary_blue ml-1 mr-1 w-1/5 text-sm xs:text-xs text-center" >Ticket Creation Date</th>
                        <th data-sortas="datetime" class="sticky top-0 px-4 py-2 bg-secondary_blue ml-1 mr-1 w-1/5 text-sm xs:text-xs text-center" >Last Update</th>
                        <th data-sortas="datetime" class="sticky top-0 px-4 py-2 bg-secondary_blue ml-1 mr-1 w-1/5 text-sm xs:text-xs text-center" >Options</th>
                    </tr>
                </thead>
                <tbody id="tickets_table_body" class="bg-white " >
                </tbody>
            </table>

         `;
         tickets_table_body=document.getElementById('tickets_table_body');
         tickets.forEach(function(ticket,i) {

            bg_custom=i%2==0?"bg-white":"bg-slate-50";
            tickets_table_body.innerHTML+=`
                <tr class="hover:border-2 hover:border-secondary_blue hover:z-20 hover:shadow h-10 h-10 min-h-10 max-h-10 w-full   p-1 border-b-[1px] border-gray-200">

                <td data-sortvalue="${ ticket.id }" class="text-center px-14">
                    <div  class=" whitespace-nowrap p-1 rounded-[0.5rem] text-sm xs:text-xs ">
                        <span class="">
                            FHT-${ ticket.id }</span>
                    </div>
                </td>


                <td data-sortvalue="${ ticket.id  }" class="text-center ">
                    <div data-bs-toggle="tooltip"  data-bs-html="true" title="${ ticket.account_id }" class="hover:cursor-pointer min-h-[40px] max-h-[40px] overflow-hidden truncate flex justify-center items-center">
                    <span  class="truncate text-sm xs:text-xs">
                    AC-${ticket.account_id}</span>
                    </div>
                </td>
                <td class="text-center ">
                    <div data-bs-toggle="tooltip"  data-bs-html="true" title="${ ticket.target }" class="${ticket.target=="Sales"?'bg-[#BFBCB9]':'bg-primary_blue'} hover:cursor-pointer min-h-[40px] max-h-[40px] overflow-hidden truncate flex justify-center items-center">
                    <span  class="truncate text-sm xs:text-xs">
                    ${ticket.target}</span>
                    </div>
                </td>
                <td class="text-center ">
                    <div data-bs-toggle="tooltip"  data-bs-html="true" title="${ ticket.subject }" class="hover:cursor-pointer min-h-[40px] max-h-[40px] overflow-hidden truncate flex justify-center items-center">
                    <span  class="truncate text-sm xs:text-xs">
                    ${ticket.subject}</span>
                    </div>
                </td>
                <td class="text-center ">
                    <div data-bs-toggle="tooltip"  data-bs-html="true" title="${ ticket.description }" class="hover:cursor-pointer min-h-[40px] max-h-[40px] overflow-hidden truncate flex justify-center items-center">
                    <span  class="truncate text-sm xs:text-xs">
                    ${ticket.description}</span>
                    </div>
                </td>
                <td class="text-center" id="status-${ticket.id}">
                    <div class="flex justify-center items-center">
                    <div data-bs-toggle="tooltip"  data-bs-html="true" title="${ ticket.status }" class="hover:cursor-pointer min-h-[40px] max-h-[40px] overflow-hidden truncate flex justify-center items-center">
                    <span  class="truncate text-sm xs:text-xs text-${StatusColors[ticket.status]}">
                    ${ticket.status}</span>
                    </div>

                    </div>
                </td>
                <td data-sortvalue="${ ticket.created_at }" class="text-center ">
                    <div data-bs-toggle="tooltip"  data-bs-html="true" title="${ formatDate(ticket.created_at) }" class="hover:cursor-pointer min-h-[40px] max-h-[40px] overflow-hidden truncate flex justify-center items-center">
                    <span  class="truncate text-sm xs:text-xs ${ticket.recently?'font-bold':''}">
                    ${formatDate(ticket.created_at)}</span>
                    </div>
                </td>
                <td data-sortvalue="${ ticket.updated_at }" class="text-center ">
                    <div data-bs-toggle="tooltip"  data-bs-html="true" title="${ formatDate(ticket.updated_at) }" class="hover:cursor-pointer min-h-[40px] max-h-[40px] overflow-hidden truncate flex justify-center items-center">
                    <span  class="truncate text-sm xs:text-xs">
                    ${formatDate(ticket.updated_at)}</span>
                    </div>
                </td>
                <td class="text-center ">
                    <div  class="hover:cursor-pointer min-h-[40px] max-h-[40px] overflow-hidden truncate flex justify-center items-center">
                        <svg data-toggle="modal" data-target="#show_ticket" onclick="showTicket(${ticket.id})" class="text-svg_primary hover:text-secondary_blue hover:cursor-pointer h-6 w-6 " viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"/>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>
                        <g id="SVGRepo_iconCarrier"> <circle cx="12" cy="12" r="1" stroke="currentColor" stroke-width="2"/> <path d="M18.2265 11.3805C18.3552 11.634 18.4195 11.7607 18.4195 12C18.4195 12.2393 18.3552 12.366 18.2265 12.6195C17.6001 13.8533 15.812 16.5 12 16.5C8.18799 16.5 6.39992 13.8533 5.77348 12.6195C5.64481 12.366 5.58048 12.2393 5.58048 12C5.58048 11.7607 5.64481 11.634 5.77348 11.3805C6.39992 10.1467 8.18799 7.5 12 7.5C15.812 7.5 17.6001 10.1467 18.2265 11.3805Z" stroke="currentColor" stroke-width="2"/> <path d="M17 4H17.2C18.9913 4 19.887 4 20.4435 4.5565C21 5.11299 21 6.00866 21 7.8V8M17 20H17.2C18.9913 20 19.887 20 20.4435 19.4435C21 18.887 21 17.9913 21 16.2V16M7 4H6.8C5.00866 4 4.11299 4 3.5565 4.5565C3 5.11299 3 6.00866 3 7.8V8M7 20H6.8C5.00866 20 4.11299 20 3.5565 19.4435C3 18.887 3 17.9913 3 16.2V16" stroke="currentColor" stroke-width="2" stroke-linecap="round"/> </g>
                        </svg>
                    </div>
                </td>


                </tr>
            `;

         });

        $(".tickets_table").fancyTable({
			sortColumn:6,
            sortable:true,
            sortOrder: 'descending',
            searchable:false,
			globalSearch:false
		});
    }

    function resetsearch(){
        document.getElementById('search').value="";
        InitialTicketTable(tickets);
    }

    function showTicket(id){
        var ticket;
        tickets.forEach(tckt => {
            if(tckt.id==id)
            ticket=tckt;return;
        });
         console.log(ticket);
         document.getElementById('show_ticket_body').innerHTML=`
           <div >
                <div class=" m-4 p-2 "  >
                    <label  class="text-secondary_blue font-bold text-sm xs:ml-2 xs:mr-2 w-20 whitespace-nowrap " for="device_name">{{ __('Target') }}</label>
                    <div class="bg-gray-100 p-1 text-sm">
                        ${ticket.target}
                    </div>
                </div>
                <div class=" m-4 p-2 "  >
                    <label  class="text-secondary_blue font-bold text-sm xs:ml-2 xs:mr-2 w-20 whitespace-nowrap " for="device_name">{{ __('Subject') }}</label>
                    <div class="bg-gray-100 p-1 text-sm">
                        ${ticket.subject}
                    </div>
                </div>
                <div class=" m-4 p-2 "  >
                    <label  class="text-secondary_blue font-bold text-sm xs:ml-2 xs:mr-2 w-20 whitespace-nowrap " for="device_name">{{ __('Description') }}</label>
                    <div class="bg-gray-100 p-1 text-sm">
                        ${ticket.description}
                    </div>
                </div>
                <div class=" m-4 p-2 ">
                    <form id="formChangeStauts-${ticket.id}" action="{{ route('admin.changestatus') }}" method="post" class="flex justify-center items-center max-h-10">
                    @csrf
                    <input type="hidden" name="ticket_id" value="${ticket.id}">

                    <select   id="status_select" name="status_select" class=" w-full  h-10   text-sm rounded-lg
                            px-2  border-gray-300  focus:border-secondary mr-2
                           focus:ring-secondary "   >

                                <option ${ticket.status==='Open'?'selected':""} value="Open"  >{{ __('Open') }}</option>
                                <option ${ticket.status=='In Progress'?'selected':""} value="In Progress"  >{{ __('In Progress') }}</option>
                                <option ${ticket.status=='Pending'?'selected':""} value="Pending"  >{{ __('Pending') }}</option>
                                <option ${ticket.status=='Closed'?'selected':""} value="Closed"  >{{ __('Closed') }}</option>
                    </select>
                    <div class="block">
                        <button type="submit">
                        <svg   class="w-6 h-6 text-svg_primary hover:text-valid hover:cursor-pointer"  viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g id="System / Save">
                            <path id="Vector" d="M17 21.0002L7 21M17 21.0002L17.8031 21C18.921 21 19.48 21 19.9074 20.7822C20.2837 20.5905 20.5905 20.2843 20.7822 19.908C21 19.4806 21 18.921 21 17.8031V9.21955C21 8.77072 21 8.54521 20.9521 8.33105C20.9095 8.14 20.8393 7.95652 20.7432 7.78595C20.6366 7.59674 20.487 7.43055 20.1929 7.10378L17.4377 4.04241C17.0969 3.66374 16.9242 3.47181 16.7168 3.33398C16.5303 3.21 16.3242 3.11858 16.1073 3.06287C15.8625 3 15.5998 3 15.075 3H6.2002C5.08009 3 4.51962 3 4.0918 3.21799C3.71547 3.40973 3.40973 3.71547 3.21799 4.0918C3 4.51962 3 5.08009 3 6.2002V17.8002C3 18.9203 3 19.4796 3.21799 19.9074C3.40973 20.2837 3.71547 20.5905 4.0918 20.7822C4.5192 21 5.07899 21 6.19691 21H7M17 21.0002V17.1969C17 16.079 17 15.5192 16.7822 15.0918C16.5905 14.7155 16.2837 14.4097 15.9074 14.218C15.4796 14 14.9203 14 13.8002 14H10.2002C9.08009 14 8.51962 14 8.0918 14.218C7.71547 14.4097 7.40973 14.7155 7.21799 15.0918C7 15.5196 7 16.0801 7 17.2002V21M15 7H9" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </g>
                        </svg>
                        <span class="text-xs block">save</span>
                        </button>

                    </div>
                    </form>
                </div>

            </div>

         `;
        // $modal=document.getElementById(`modalShowTicket-`${ticket.id});
    }
    // function saveStatusChanges(id){
    //     status=document.getElementById(`status_select-${id}`).value;
    //     window.location.href = '/admin-center/changestatus/'+id+'/'+ status;
    // }onclick="saveStatusChanges(${id})"
</script>


    {{-- menubar for each form in owl carousel  --}}



    @stack('scripts')
    @stack('modals')
</body>

</html>
