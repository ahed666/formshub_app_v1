<div>
    <div class=" grow py-4 xs:py-1">

        {{-- first row of charts --}}
        <div class="grid grid-cols-12">
            {{-- info  --}}
            <div class="col-span-4 xs:col-span-12 p-4 xs:p-1 bg-white  mb-2 mr-2 xs:mr-0  max-h-[300px] rounded-[0.5rem]">
                        @php
                            $text="text";$bar="bar";
                        @endphp
                    <div class="min-h-[80%]">
                <x-form-info-tag :svg="$formage_svg" :type="$text" :tag="__('main.formage_overview')" :info=" $form_age " :class="'text-secondary_blue'" />
                <x-form-info-tag :svg="$responses_svg" :type="$text" :tag="__('main.totalresponses')" :info="$totalresponses" :class="'text-secondary_blue'" />
                <x-form-info-tag :svg="$todo_svg" :type="$text" :tag="__('main.todo')" :info=" $totaltodos " :class="'text-secondary_blue'" />
                <x-form-info-tag :svg="$score_svg" :type="$bar" :tag="__('main.scoreaverage')" :info=" $averagescore " :bgcolor="'bg-yellow-300'" :class="''" />
                <x-form-info-tag :svg="$completion_svg" :type="$bar" :tag="__('main.completionaverage')" :info="$completPercent" :bgcolor="'bg-valid'" :class="''" />
                 </div>
                 <div class="flex justify-end items-center">
                    <span class="rounded-[0.5rem] w-auto h-6   p-1 text-xs {{ $status?"text-valid bg-green-100":"text-primary_red bg-red-100" }}">{{ $status?__('main.active'):__('main.inactive') }}</span>
               </div>
            </div>
            {{-- responses/dates --}}
            <div class="col-span-8  xs:col-span-12 p-4 xs:p-1  items-center max-h-auto  grid  mb-2 ml-2 xs:ml-0   bg-white max-h-[300px] rounded-[0.5rem]" >
                <div class="xs:grid flex justify-between  mb-2  ">
                    <div><span class="text-sm">{{ __('main.audienceinteractive') }}</span></div>
                    <div class="flex justify-center items-center mt-2 xs:max-w-xs ">
                        <div class="ml-2 mr-2 flex items-center "><h1 class="text-center ml-1 mr-1 text-sm xs:text-xs">{{ __('main.start') }}
                            </h1> <input type="date" wire:model="startdate" class=" rounded-lg h-8 text-sm p-[1px]" name="" id="startdate">
                        </div>
                        <div class="ml-2 mr-2 flex items-center"><h1 class="text-center ml-1 mr-1 text-sm xs:text-xs">{{ __('main.end') }}
                            </h1> <input type="date" wire:model="enddate" class=" rounded-lg h-8 text-sm p-[1px]"  name="" id="enddate">
                        </div>
                    </div>
                </div>
                <canvas id="responses_date" class="max-h-[80%]"></canvas>

            </div>



        </div>
          {{-- first row of charts --}}
        <div class="grid grid-cols-12   ">
            {{-- responses/devices --}}
            <div class="col-span-4 xs:col-span-12 p-4 xs:p-1  items-center max-h-auto  grid  mt-2 mr-2 xs:mr-0  bg-white rounded-[0.5rem] ">
                <div class=" flex justify-start mb-2  ">
                    <span class="text-sm">{{ __('main.responsessource') }}</span>
                </div>
                <div class="flex justify-center items-center"><canvas id="responses_device" class="max-h-[350px] max-w-[350px] xs:max-w-auto"></canvas></div>
            </div>

             {{-- last responses --}}
            <div class="col-span-8 xs:col-span-12 p-4 xs:p-1    mt-2 ml-2 xs:ml-0   bg-white rounded-[0.5rem]">
                  <div class="flex justify-between items-center">
                    <div><span class="text-sm">{{ __('main.mostrecentresponses') }}</span></div>

                        <a href="{{ route('all-responses', $current_form->id ) }}">
                            <x-jet-button  type="submit"   wire:loading.attr="disabled">
                            {{ __('main.viewall') }}
                    </x-jet-button></a>


                </div>
                  <div class=" overflow-y-auto scrollbar scrollbar-thumb-secondary_blue scrollbar-track-gray-200 px-2 rounded-[0.5rem] mt-2 max-h-[350px] ">
                    <table  class="mostresponses_table table-fixed  w-full   " >

                        <thead class="h-10">
                            <tr class="  border-b-[1px] border-t-[1px] p-1  bg-secondary_blue text-white ">
                                <th  class=" sticky top-0 px-4 py-2 bg-secondary_blue ml-1 mr-1 w-1/5 text-sm xs:text-xs text-center "  >{{ __('main.dateandtime') }}</th>
                                <th class="sticky top-0 px-4 py-2 bg-secondary_blue ml-1 mr-1 w-1/5 text-sm xs:text-xs text-center" >{{ __('main.language') }}</th>
                                <th class="sticky top-0 px-4 py-2 bg-secondary_blue ml-1 mr-1 w-1/5 text-sm xs:text-xs text-center" >{{ __('main.score_table') }}</th>
                                <th class="sticky top-0 px-4 py-2 bg-secondary_blue ml-1 mr-1 w-1/5 text-sm xs:text-xs text-center" >{{ __('main.completionpercent') }}</th>
                            </tr>
                        </thead>
                        <tbody id="todo_table_body" class="bg-white " >
                            @foreach ($mostresponses as $response )


                                <tr data-response-id="{{ $response->id }}"
                                      wire:loading.class=" animate-pulse " class="hover:border-2 hover:border-secondary_blue hover:z-20 hover:shadow  w-full p-1 border-b-[1px] border-gray-200 bg-white  ">

                                    <td  class="  max-h-8 pl-2">
                                        <div data-bs-toggle="tooltip"  data-bs-html="true" title="{{ \Carbon\Carbon::parse($response->reviewed_at)->setTimezone(Auth::user()->timezone)->format('Y-m-d H:i') }}"  class="hover:cursor-pointer min-h-[35px] max-h-[35px] overflow-hidden truncate flex justify-center items-center">
                                            <span class="text-sm xs:text-xs truncate text-center ">{{ \Carbon\Carbon::parse($response->reviewed_at)->setTimezone(Auth::user()->timezone)->format('Y-m-d H:i') }}</span>
                                        </div>
                                    </td>
                                    <td class="  max-h-8  pl-2">
                                        <div data-bs-toggle="tooltip"  data-bs-html="true" title="{{$response->lang}}"  class="hover:cursor-pointer  min-h-[35px] max-h-[35px] overflow-hidden truncate flex justify-center items-center">
                                            <span class="text-sm xs:text-xs truncate text-left ">{{$main_languages[$response->response_language]['name']}}</span>
                                        </div>
                                    </td>
                                    <td class=" max-h-8  pl-2">
                                        <div data-bs-toggle="tooltip"  data-bs-html="true" title="{{$response->score}}%"  class="hover:cursor-pointer  min-h-[35px] max-h-[35px] overflow-hidden truncate flex justify-center items-center">

                                            <x-progress-bar :value="$response->score" class="bg-yellow-300" />

                                        </div>
                                    </td>
                                    <td class="  max-h-8  pl-2">
                                        <div   class="hover:cursor-pointer  min-h-[35px] max-h-[35px] overflow-hidden truncate flex justify-center items-center ">
                                            <x-progress-bar :value="$response->complet_percent" class="bg-valid" />
                                        </div>
                                    </td>

                                </tr>

                            @endforeach
                        </tbody>
                    </table>
                  </div>
            </div>
        </div>



    </div>
</div>
@push('scripts')
<script src="{{ asset('js/index.min.js')}}"></script>
<script src="{{ asset('https://cdn.jsdelivr.net/gh/livewire/sortable@v0.x.x/dist/livewire-sortable.js')}}"></script>
<script defer src="{{ asset('https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.js')}}" defer></script>
<script src="{{ asset('https://cdn.jsdelivr.net/npm/sweetalert2@11')}}"></script>
<script src="{{ asset('https://cdn.jsdelivr.net/npm/jquery.fancytable/dist/fancyTable.min.js') }}"></script>
<script src="{{ asset('js/chart.umd.min.js') }}"></script>
<script src="{{ asset('https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns/dist/chartjs-adapter-date-fns.bundle.min.js') }}"></script>
<script src="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/chartjs-plugin-datalabels/2.2.0/chartjs-plugin-datalabels.min.js')}}"></script>


{{-- all responses --}}
<script>
      var translations = @json(__('main'));

    var responses;
    var formquestions;
    var formlanguages;
    var language;
    var questions;
    var defultTbody;
    var responseIndex;
    // after success add todo
    var responsesdates;
    var numofresponses;
    var numofresponsesCanceld;
    var numofresponsesfordevices;
    var devices;
    var responses_date;
    var responses_device;
     var mindate;
     var maxdate;
     var colorArray=[     "#1E88E5","#E53935","#FDD835","#43A047","#546E7A","#FB8C00","#6D4C41","#8E24AA","#C0CA33","#00ACC1",
                          "#42A5F5","#EF5350","#FFEE58","#66BB6A","#78909C","#FFA726","#8D6E63","#AB47BC","#D4E157","#26C6DA",
                          "#90CAF9","#EF9A9A","#FFF59D","#A5D6A7","#B0BEC5","#FFCC80","#BCAAA4","#CE93D8","#E6EE9C","#80DEEA",
                          "#1565C0","#B71C1C","#F57F17","#1B5E20","#263238","#E65100","#3E2723","#4A148C","#827717","#006064",
                          "#E3F2FD","#FFEBEE","#FFFDE7","#E8F5E9","#ECEFF1","#FFF3E0","#D7CCC8","#F3E5F5","#F0F4C3","#B2EBF2",

         ];

    document.addEventListener("DOMContentLoaded", () => {
        //  charts
        responsesdates=@this.responsesdates;
        numofresponses=@this.numofresponses;
        numofresponsesCanceld=@this.numofresponsesCanceld;
        numofresponsesfordevices=@this.numofresponsesfordevices;
        devices=@this.devices;
        mindate=@this.mindate;
        maxdate=@this.maxdate;
          if(responsesdates!=null){
        setMinAndMaxPickerDate();
        viewcharts();}
    });

</script>
{{-- charts js --}}
<script>

     document.addEventListener('reinitialchart',(e)=>{
         responses_date.destroy();
         responses_device.destroy();
        responsesdates=e.detail.responsesdates;
        numofresponses=e.detail.numofresponses;
        numofresponsesCanceld=@this.numofresponsesCanceld;
        setMinAndMaxPickerDate(responsesdates);
        viewcharts();



    });


function setMinAndMaxPickerDate(){

        var maxDate=new Date(maxdate);
        var minDate=new Date(mindate);
        maxDate=converttodate(maxDate);
        minDate=converttodate(minDate);
        enddate=document.getElementById('enddate');
        startdate=document.getElementById('startdate');
        enddate.setAttribute("max",maxDate);
        startdate.setAttribute("max",maxDate);
        enddate.setAttribute("min",minDate);
        startdate.setAttribute("min",minDate);
}

function converttodate(Date){
    var dd = Date.getDate();
        var mm = Date.getMonth()+1; //January is 0!
        var yyyy = Date.getFullYear();
        if(dd<10){
                dd='0'+dd
            }
            if(mm<10){
                mm='0'+mm
            }

            Date = yyyy+'-'+mm+'-'+dd;
            return Date;
}
function viewcharts(){
      response_date();
      response_device();
     }

    // 1) responses/dates
    function response_date(){
        const data = {
        labels:responsesdates,
        datasets: [{
            label: translations.responses,
            data: numofresponses,
            tension: 0.4,
            backgroundColor: [

            '#1E88E5'

            ],
            borderColor: [

            'rgba(54, 162, 235, 1)'

            ],
            borderWidth: 1
        }]
        };
        // config
        const bgColor={
                id:'bgColor',
                beforeDraw:(chart,options)=>{
                    const {ctx,width,height}=chart;
                    ctx.fillStyle='white';
                    ctx.fillRect(0,0,width,height)
                    ctx.restore();
                }
            }

        // // config
        // const config = {
        // type: 'line',
        // data,
        // options: {
        //     scales: {
        //     y: {
        //         beginAtZero: true
        //     }
        //     }


        // },
        // plugins:[bgColor]
        // };
        const config =
        {
            type: 'line',
            data,
            options: {
                responsive: true,
                scales:{
                    x:{
                        type:'time',
                        time:{
                            unit:'day'

                        }
                    }
                },
                legend: {
                        display:true,
                        position: 'top',
                },

                plugins:
                {

                    title: {
                        display: false,
                        text: translations.numofeachanswer
                    }

                }
            },
            plugins:[bgColor]
        };

        // render init block
        responses_date = new Chart(
        document.getElementById('responses_date'),
        config
        );
    }
    // 2) responses/devices
    function response_device(){
        const data = {
        labels:devices,
        datasets: [{
            label: translations.responses+'/'+translations.kiosks,
            data: numofresponsesfordevices,
            backgroundColor: colorArray,
            borderColor: [

            'transparent'

            ],
            borderWidth: 1
        }]
        };

        // config
        const config = {
        type: 'pie',
        data,
        options: {
            responsive: true,
            plugins: {
            legend: {
                position: 'top',
            },
            datalabels:{formatter:(value,context)=>{return value;}}

            }}
        };

        // render init block
        responses_device = new Chart(
        document.getElementById('responses_device'),
        config
        );
    }







</script>

@endpush
