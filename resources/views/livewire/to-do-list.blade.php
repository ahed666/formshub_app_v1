@push('styles')
{{-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script> --}}
<link  rel="stylesheet" href="{{ asset('styles/bootstrap.min.css')}}">

@endpush
<div  >

    @if ($accountStatus['status']=='Locked')

       <x-lockedaccount/>

    @elseif($allowAddToDoSubscribe==false)

       <x-lockedaccount/>
    @endif


    <div class="{{ $accountStatus['status']=='Locked'?"pointer-events-none opacity-50":"" }} 2xl:col-span-9 xs:row-span-8 mt-2  p-[1px] ">

        <div class=" w-full  mb-2 flex xs:grid justify-between p-2 pl-4 items-center bg-white drop-shadow     rounded-[0.5rem]" >
            {{-- data-toggle="modal" data-target="#todo-response"  --}}
           <button type="button" onclick="addtodo()" disabled    class="bg-secondary_blue rounded opacity-50  p-2  h-16 w-[100px] hover:cursor-pointer ease-in delay-100  hover:-translate-z-1 hover:scale-[1.1]  duration-200 xs:my-2   xs:flex xs:justify-center xs:items-center ">
                <div  class=" flex justify-center items-center">

                    <!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">
                    <svg   class=" w-6 h-6 " viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g id="SVGRepo_bgCarrier" stroke-width="0"/>
                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>
                    <g id="SVGRepo_iconCarrier"> <path d="M20 10V7C20 5.89543 19.1046 5 18 5H6C4.89543 5 4 5.89543 4 7V10M20 10H4M20 10V10.75M4 10V19C4 20.1046 4.89543 21 6 21H12M8 3V7M16 3V7" stroke="#ffffff" stroke-width="2" stroke-linecap="round"/> <path d="M17.5356 14V17.5355M17.5356 21.0711V17.5355M17.5356 17.5355L21.0712 17.5355M17.5356 17.5355H14.0001" stroke="#ffffff" stroke-width="2" stroke-linecap="round"/> </g>
                    </svg>

                </div>
               <div class="flex justify-center">
                   <span class="mt-1 text-white text-sm ">{{ __('main.addtask') }}</span>
               </div>
           </button>
           {{-- filters --}}
           <div class="flex xs:grid xs:grid-cols-12 xs:border-[1px] xs:p-2 border-gray-300 space-x-10 ">
                {{-- status --}}
                <div class="xs:col-span-6">
                   <label for="status" class="pointer-events-none  text-secondary_blue  left-3 top-0 mb-0 max-w-[90%] origin-[0_0] truncate pt-[0.37rem]
                    leading-[1.6]  transition-all duration-200 ease-out text-sm">{{ __('main.statusfilter') }}</label>
                    <select  onchange="Filtering()"   id="status" name="filter" class=" w-32 mr-2  h-10 bg-gray-50 border border-gray-300 text-gray-900 text-sm
                    rounded-lg   block  px-2"   required>
                            <option  class="opacity-50 pointer-events-none" value="all" selected>{{ __('main.all') }}</option>
                            <option  value="Open">{{ __('main.open') }}</option>
                            <option  value="Pending">{{ __('main.pending') }}</option>
                            <option  value="In Progress">{{ __('main.inprogress') }}</option>
                            <option  value="Closed">{{ __('main.closed') }}</option>
                    </select>
                </div>
                {{-- priority --}}
                <div class="xs:col-span-6">
                    <label for="priority" class="pointer-events-none  text-secondary_blue    left-3 top-0 mb-0 max-w-[90%] origin-[0_0] truncate pt-[0.37rem]
                    leading-[1.6]  transition-all duration-200 ease-out text-sm">{{ __('main.priorityfilter') }}</label>
                    <select  onchange="Filtering()"   id="priority" name="filter" class=" w-32 mr-2  h-10 bg-gray-50 border border-gray-300 text-gray-900 text-sm
                    rounded-lg  block     px-2"   required>
                            <option  class="opacity-50 pointer-events-none" value="all" selected>{{ __('main.all') }}</option>
                            <option  value="Low">{{ __('main.low') }}</option>
                            <option  value="Medium">{{ __('main.medium') }}</option>
                            <option  value="High">{{ __('main.high') }}</option>
                    </select>
                </div>
            
           </div>
           {{-- Info Panel --}}
           <div id="box_status_info" class="flex xs:mt-2">



           </div>

       </div>
       {{-- table of kiosk --}}
    <div class=" border     shadow  rounded-[0.5rem] p-4">
        @if(count($todos)==0)
                <div class="col-span-12 flex justify-center items-center ">
                  <span class="text-md text-center text-black">{{ __('main.notasks' ) }}</span>
                </div>
        @else
       <div id="todo_table" class="grow rounded-[0.5rem]  overflow-y-auto ">

       </div>
       @endif
    </div>
   </div>
    {{-- show full response of to do list --}}
    <div  class="modal fade fixed top-0 left-0 z-[1055]  h-full w-full  " id="show-response" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="show-response-modal" aria-hidden="true">
        <div class="xs:m-0 modal-dialog modal-dialog-centered  min-h-[calc(100%-1rem)] w-full max-w-[1000px] translate-y-[-50px] items-center  transition-all duration-10 ease-out-in min-[576px]:mx-auto min-[576px]:mt-7 min-[576px]:min-h-[calc(100%-3.5rem)]" role="document">
        <div class="modal-content  w-full flex-col rounded-md border-none  bg-clip-padding text-current shadow-lg
        outline-none ">
        @livewire('show-response')
        </div>
        </div>
    </div>
    <div  class="modal fade fixed top-0 left-0 z-[1055]  h-full w-full   " data-backdrop="static" data-keyboard="false" id="todo-response" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="xs:m-0 modal-dialog modal-dialog-centered  min-h-[calc(100%-1rem)] w-full max-w-[800px] translate-y-[-50px] items-center  transition-all duration-10 ease-out-in min-[576px]:mx-auto min-[576px]:mt-7 min-[576px]:min-h-[calc(100%-3.5rem)]" role="document">
        <div class="modal-content  w-full flex-col rounded-md border-none  bg-clip-padding text-current shadow-lg
        outline-none ">

            @livewire('add-todo')
        </div>
        </div>
    </div>

    {{-- edit todo --}}


</div>
@push('scripts')
<script>
    var translations = @json(__('main'));
    var responses_data;
    var todos;
    var todos_list;
    var StatusColors={
        "Open":"red-100","Pending":"yellow-50","In Progress":"[#d2e8fc]","Closed":"green-100"
    };
    const svgStatus = {
        'Open': `<svg class="inline-block w-4 h-4 xs:w-3 xs:h-3  " viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g id="SVGRepo_bgCarrier" stroke-width="0"/>
                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>
                    <g id="SVGRepo_iconCarrier"> <path opacity="0.5" d="M2 16C2 13.1716 2 11.7574 2.87868 10.8787C3.75736 10 5.17157 10 8 10H16C18.8284 10 20.2426 10 21.1213 10.8787C22 11.7574 22 13.1716 22 16C22 18.8284 22 20.2426 21.1213 21.1213C20.2426 22 18.8284 22 16 22H8C5.17157 22 3.75736 22 2.87868 21.1213C2 20.2426 2 18.8284 2 16Z" fill="#ce2727"/> <path d="M12.75 14C12.75 13.5858 12.4142 13.25 12 13.25C11.5858 13.25 11.25 13.5858 11.25 14V18C11.25 18.4142 11.5858 18.75 12 18.75C12.4142 18.75 12.75 18.4142 12.75 18V14Z" fill="#ce2727"/> <path d="M6.75 8C6.75 5.10051 9.10051 2.75 12 2.75C14.4453 2.75 16.5018 4.42242 17.0846 6.68694C17.1879 7.08808 17.5968 7.32957 17.9979 7.22633C18.3991 7.12308 18.6405 6.7142 18.5373 6.31306C17.788 3.4019 15.1463 1.25 12 1.25C8.27208 1.25 5.25 4.27208 5.25 8V10.0546C5.68651 10.022 6.18264 10.0089 6.75 10.0036V8Z" fill="#ce2727"/> </g>
                    </svg>`,
        'Pending': `<svg class="inline-block w-4 h-4 xs:w-3 xs:h-3 " viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g id="SVGRepo_bgCarrier" stroke-width="0"/>
                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>
                    <g id="SVGRepo_iconCarrier"> <path opacity="0.15" d="M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z" fill="#ffee38"/> <path d="M12 16.99V17M12 7V14M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z" stroke="#ccbb00" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> </g>

                    </svg>`,
        'In Progress':`<svg class="inline-block w-4 h-4 xs:w-3 xs:h-3 " viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"/>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>
                        <g id="SVGRepo_iconCarrier"> <circle opacity="0.5" cx="12" cy="12" r="10" stroke="#003cff" stroke-width="1.5"/> <path d="M17 10L7 10L10.4375 7" stroke="#003cff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> <path d="M7 14L17 14L13.5625 17" stroke="#003cff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> </g>
                        </svg>`,
        'Closed':`<svg class="inline-block w-4 h-4 xs:w-3 xs:h-3 " viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g id="SVGRepo_bgCarrier" stroke-width="0"/>
                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>
                    <g id="SVGRepo_iconCarrier"> <path opacity="0.5" d="M2 16C2 13.1716 2 11.7574 2.87868 10.8787C3.75736 10 5.17157 10 8 10H16C18.8284 10 20.2426 10 21.1213 10.8787C22 11.7574 22 13.1716 22 16C22 18.8284 22 20.2426 21.1213 21.1213C20.2426 22 18.8284 22 16 22H8C5.17157 22 3.75736 22 2.87868 21.1213C2 20.2426 2 18.8284 2 16Z" fill="#007002"/> <path d="M12.75 14C12.75 13.5858 12.4142 13.25 12 13.25C11.5858 13.25 11.25 13.5858 11.25 14V18C11.25 18.4142 11.5858 18.75 12 18.75C12.4142 18.75 12.75 18.4142 12.75 18V14Z" fill="#007002"/> <path d="M6.75 8C6.75 5.10051 9.10051 2.75 12 2.75C14.8995 2.75 17.25 5.10051 17.25 8V10.0036C17.8174 10.0089 18.3135 10.022 18.75 10.0546V8C18.75 4.27208 15.7279 1.25 12 1.25C8.27208 1.25 5.25 4.27208 5.25 8V10.0546C5.68651 10.022 6.18264 10.0089 6.75 10.0036V8Z" fill="#007002"/> </g>
                    </svg>`
    };
    document.addEventListener("livewire:load", () => {
        //all responses
        responses_data=@this.responses_data;
        todos=@this.todos;

         if(todos.length>0)
        {InitialTodoTable(todos);}
        // InitialTodoFilters();


    });
    window.addEventListener('after_delete_todo', event => {
        //all responses
        console.log('deleted');
        responses_data=@this.responses_data;
                todos=@this.todos;

                if(todos.length==0)
                    {
                        document.getElementById('todo_table').innerHTML=`
                        <div class="flex justify-center items-center">
                        <span>${translations.notasks}</span>
                        </div>
                        `;
                    }
                else{
                InitialTodoTable(todos);}
    });
    window.addEventListener('close_modal_edit_todo', event => {
    window.location.reload();
    });
    // reset filters
    function ResetFilters(){
        const selectElements = document.querySelectorAll('select[name="filter"]');
        selectElements.forEach(element => {
            element.value=null;
        });
        InitialTodoTable(todos);
    }
    //initial todo filters
    function InitialTodoFilters(){
        forms_name=[];
        users_name=[];
        username_filter=document.getElementById('user_name');
        formname_filter=document.getElementById('form_title');
        username_filter.innerHTML+=`<option disabled class="opacity-50 pointer-events-none" value="null" selected>{{ __('Choose User') }}</option>`;
        formname_filter.innerHTML+=`<option disabled class="opacity-50 pointer-events-none" value="null" selected>{{ __('Choose Form') }}</option>`;
       todos.forEach(element => {
        if(!forms_name.includes(element.form_title))
        forms_name.push(element.form_title);
        if(!users_name.includes(element.user_name))
        users_name.push(element.user_name);

       });
       forms_name.forEach(element => {
        formname_filter.innerHTML+=`<option  value="${element}">${element}</option>`;
       });
       users_name.forEach(element => {
        username_filter.innerHTML+=`<option  value="${element}">${element}</option>`;
       });

    }
    //filtering function
    function Filtering(){
        const selectElements = document.querySelectorAll('select[name="filter"]');
        var todos_list_filter=[];
        todos_list=todos;
        selectElements.forEach(element => {

            if(element.value!='all')
            { todos_list_filter=[];
                 console.log(element.value);
                todos_list.forEach(todo => {
                    if(todo.status==element.value&&element.id=="status")
                    {
                        if(!todos_list_filter.includes(todo))
                        todos_list_filter.push(todo);

                    }
                    else if(todo.priority==element.value&&element.id=="priority")
                    {
                        if(!todos_list_filter.includes(todo))
                        todos_list_filter.push(todo);

                    }
                    // else if(todo.user_name==element.value&&element.id=="user_name")
                    // {
                    //     if(!todos_list_filter.includes(todo))
                    //     todos_list_filter.push(todo);

                    // }
                    // else if(todo.form_name==element.value&&element.id=="form_name")
                    // {
                    //     if(!todos_list_filter.includes(todo))
                    //     todos_list_filter.push(todo);

                    // }

                })
                todos_list=todos_list_filter.slice();
            }



            console.log(todos_list);
        });




        InitialTodoTable(todos_list);
    }

    // intial todo table
    function InitialTodoTable(todos_list){
        var colors=JSON.parse(JSON.stringify(StatusColors));
        var box_status_info=document.getElementById('box_status_info');
        box_status_info.innerHTML=``;
        const StatusMap = new Map();
        StatusMap.set("Open", 0);
        StatusMap.set("Pending", 0);
        StatusMap.set("In Progress", 0);
        StatusMap.set("Closed", 0);

         todo_table=document.getElementById('todo_table');
         todo_table.innerHTML='';
         todo_table.innerHTML+=`
            <table  class="todos_table table-fixed  w-full rounded-xl   " >

                <thead class="h-10">
                    <tr class="  border-b-[1px] border-t-[1px] p-1  bg-secondary_blue text-white ">


                        <th  class=" sticky top-0 px-4 py-2 xs:p-1 bg-secondary_blue ml-1 mr-1 w-1/5 text-sm xs:text-xs text-center "  >${translations.task}</th>
                        <th class="sticky top-0 px-4 py-2 xs:p-1 bg-secondary_blue ml-1 mr-1 w-1/5 text-sm xs:text-xs text-center" >${translations.status}</th>
                        <th class="sticky top-0 px-4 py-2 xs:p-1 bg-secondary_blue ml-1 mr-1 w-1/5 text-sm xs:text-xs text-center" >${translations.priority}</th>
                        <th class="sticky top-0 px-4 py-2 xs:p-1 bg-secondary_blue ml-1 mr-1 w-1/5 text-sm xs:text-xs text-center" >${translations.assignedto}</th>
                        <th class="sticky top-0 px-4 py-2 xs:p-1 bg-secondary_blue ml-1 mr-1 w-1/5 text-sm xs:text-xs text-center" >${translations.formtitle}</th>
                        <th class="sticky top-0 px-4 py-2 xs:p-1 bg-secondary_blue ml-1 mr-1 w-1/5 text-sm xs:text-xs text-center" >${translations.createdat_table}</th>
                        <th data-sortas="datetime" class="sticky top-0 px-4 py-2 xs:p-1 bg-secondary_blue ml-1 mr-1 w-1/5 text-sm xs:text-xs text-center" >${translations.options}</th>
                    </tr>
                </thead>
                <tbody id="todo_table_body" class="bg-white " >
                </tbody>
            </table>

         `;
         todo_table_body=document.getElementById('todo_table_body');
         todos_list.forEach(function(todo,i) {
            StatusMap.set(todo.status, StatusMap.get(todo.status)+1);
            ShowViewClass=todo.form_title==null?"hidden":"block";
            bg_custom=i%2==0?"bg-white":"bg-slate-50";
            todo_table_body.innerHTML+=`
                <tr class="h-10 min-h-10 max-h-10 w-full bg-${colors[todo.status]}  p-1 border-b-[1px] border-gray-200">

                <td class="  max-h-10  pl-2">
                    <div data-bs-toggle="tooltip"  data-bs-html="true" title="${todo.task}"  class="hover:cursor-pointer min-h-[40px] max-h-[40px] overflow-hidden truncate flex justify-start items-center">
                        <span class="text-sm xs:text-xs truncate text-left xs:block xs:truncate ">${todo.task}</span>
                    </div>
                </td>
                <td class="text-center px-14 xs:px-1">
                    <div  class="whitespace-nowrap p-1 rounded-[0.5rem] text-sm xs:text-xs ">
                        <span class="xs:block xs:truncate ">${svgStatus[todo.status]}${ todo.status }</span>
                    </div>
                <td class="text-center"> <span  class=" text-sm xs:text-xs xs:block xs:truncate  ">${ todo.priority}</span></td>
                <td class="text-center ">
                    <div data-bs-toggle="tooltip"  data-bs-html="true" title="${ todo.user_name }" class="hover:cursor-pointer min-h-[40px] max-h-[40px] overflow-hidden truncate flex justify-center items-center">
                    <span  class="truncate text-sm xs:text-xs xs:block xs:truncate ">
                    ${ todo.user_name }</span>
                    </div>
                    </td>
                <td class="text-center ">
                    <div data-bs-toggle="tooltip"  data-bs-html="true" title="${ todo.form_title }" class="hover:cursor-pointer min-h-[40px] max-h-[40px] overflow-hidden truncate flex justify-center items-center">
                    <span  class="truncate text-sm xs:text-xs xs:block xs:truncate ">${ todo.form_title }</span>
                    </div>
                </td>
                <td data-sortvalue="${ todo.formmated_created_at }" class="text-center ">
                    <div data-bs-toggle="tooltip"  data-bs-html="true" title="${ todo.formmated_created_at }" class="hover:cursor-pointer min-h-[40px] max-h-[40px] overflow-hidden truncate flex justify-center items-center">
                    <span  class="truncate text-sm xs:text-xs xs:block xs:truncate ">${ todo.formmated_created_at }</span>
                    </div>
                </td>
                <td class="text-center">
                    <div class="flex justify-center items-center min-h-[40px] max-h-[40px]">

                        <a onclick="showResponse(${ todo.response_id })"   data-toggle="modal" data-target="#show-response"   class="ml-1 mr-1 xs:mx-[1px]  " >
                            <svg class="text-svg_primary hover:text-secondary_blue hover:cursor-pointer h-6 w-6 xs:w-3 xs:h-3  ${ShowViewClass}" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">

                                <g id="SVGRepo_bgCarrier" stroke-width="0"/>

                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>

                                <g id="SVGRepo_iconCarrier"> <circle cx="12" cy="12" r="1" stroke="currentColor" stroke-width="2"/> <path d="M18.2265 11.3805C18.3552 11.634 18.4195 11.7607 18.4195 12C18.4195 12.2393 18.3552 12.366 18.2265 12.6195C17.6001 13.8533 15.812 16.5 12 16.5C8.18799 16.5 6.39992 13.8533 5.77348 12.6195C5.64481 12.366 5.58048 12.2393 5.58048 12C5.58048 11.7607 5.64481 11.634 5.77348 11.3805C6.39992 10.1467 8.18799 7.5 12 7.5C15.812 7.5 17.6001 10.1467 18.2265 11.3805Z" stroke="currentColor" stroke-width="2"/> <path d="M17 4H17.2C18.9913 4 19.887 4 20.4435 4.5565C21 5.11299 21 6.00866 21 7.8V8M17 20H17.2C18.9913 20 19.887 20 20.4435 19.4435C21 18.887 21 17.9913 21 16.2V16M7 4H6.8C5.00866 4 4.11299 4 3.5565 4.5565C3 5.11299 3 6.00866 3 7.8V8M7 20H6.8C5.00866 20 4.11299 20 3.5565 19.4435C3 18.887 3 17.9913 3 16.2V16" stroke="currentColor" stroke-width="2" stroke-linecap="round"/> </g>

                            </svg>
                        </a>




                        <a onclick="edittodo(${todo.id})"    data-toggle="modal" data-target="#todo-response"   type="button" class="ml-1 mr-1 xs:mx-[1px]" >
                            <svg class="text-svg_primary hover:text-secondary_blue hover:cursor-pointer h-6 w-6 xs:w-3 xs:h-3  " viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"/>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>
                            <g id="SVGRepo_iconCarrier">
                                <path d="M12 3.99997H6C4.89543 3.99997 4 4.8954 4 5.99997V18C4 19.1045 4.89543 20 6 20H18C19.1046 20 20 19.1045 20 18V12M18.4142 8.41417L19.5 7.32842C20.281 6.54737 20.281 5.28104 19.5 4.5C18.7189 3.71895 17.4526 3.71895 16.6715 4.50001L15.5858 5.58575M18.4142 8.41417L12.3779 14.4505C12.0987 14.7297 11.7431 14.9201 11.356 14.9975L8.41422 15.5858L9.00257 12.6441C9.08001 12.2569 9.27032 11.9013 9.54951 11.6221L15.5858 5.58575M18.4142 8.41417L15.5858 5.58575"  stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke="currentColor" /> </g>
                            </svg>
                        </a>
                        <a onclick="deletetodoConfirmation(${todo.id})" class="ml-1 mr-1 xs:mx-[1px]" >
                            <svg  class="xs:w-3 xs:h-3  w-6 h-6 text-svg_primary hover:text-primary_red hover:cursor-pointer" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g id="SVGRepo_bgCarrier" stroke-width="0"/>
                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>
                                    <g id="SVGRepo_iconCarrier"> <path d="M10 11V17" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/> <path d="M14 11V17" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/> <path d="M4 7H20" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/> <path d="M6 7H12H18V18C18 19.6569 16.6569 21 15 21H9C7.34315 21 6 19.6569 6 18V7Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/> <path d="M9 5C9 3.89543 9.89543 3 11 3H13C14.1046 3 15 3.89543 15 5V7H9V5Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/> </g>
                            </svg>
                        </a>
                    </div>
                </td>

                </tr>
            `;

         });
         console.log(StatusMap);
         StatusMap.forEach((value, key) => {
            switch (key) {
                case "Open":
                   title=translations.open;
                    break;
                    case "Pending":
                   title=translations.pending;
                    break;
                    case "In Progress":
                   title=translations.inprogress;
                    break;
                default:
                title=translations.closed;
                    break;
            }

                   box_status_info.innerHTML+=`<div class="grid p-2 rounded-full ml-1 mr-1 w-16 h-16 text-center items-center justify-center  bg-${colors[key]} "><span class="text-center font-bold text-xs p-[1px] block whitespace-nowrap px-2">${title}</span><span class="ml-1 mr-1 block font-bold text-sm">${value}</span><div>`;
                    key!="Closed"?box_status_info.innerHTML+=`<div class="flex justify-center items-center"><span>
                        <svg class="w-4 h-4 " fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25L21 12m0 0l-3.75 3.75M21 12H3"></path>
                            </svg>
                        </span></div>`:"";
                });
        $(".todos_table").fancyTable({
			sortColumn:5,
            sortable:true,
            searchable:false,
            sortOrder: 'descending',
			globalSearch:false
		});
    }


   // function to show each response individal
   function showResponse(id){
        Livewire.emit('showResponse',id);
    }
    // emit edit to do
    function edittodo(id){

    Livewire.emit('edit_todo',id);
    }
    function addtodo(id=null){

        Livewire.emit('add_todo',id);
        console.log('add');
    }

</script>
<script src="https://cdn.jsdelivr.net/npm/jquery.fancytable/dist/fancyTable.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
       //  to confirm delete language


        function deletetodoConfirmation(id){
        (
        async () => {

        const { value: accept } = await Swal.fire({
            text: "You will no longer have access to this task",
        input: 'checkbox',
        inputValue: 0,
        icon:'question',
        confirmButtonColor: '#dc2626',
        showCancelButton: true,
          cancelButtonColor:'#f3f4f6',
        cancelButtonText:"<h5 style='color:000000;border:0;box-shadow: none;'>Cancel</h5>",
        inputPlaceholder:
        'Are you sure you want to delete it',
        confirmButtonText:
            'Delete ',
        inputValidator: (result) => {
            return !result && 'Checkbox is required'
        }
        })

        if (accept) {
            Livewire.emit('deleteTodoConfirmed',id);
        }

        })()}
</script>
@endpush
