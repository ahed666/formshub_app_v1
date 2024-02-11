


<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('admin.includes.head')


</head>
@php
    $colors=[
    'Active' => 'valid',
    'Suspended' => 'primary_red',
    'Valid' => 'valid',
    'Grace' => 'yellow-300',
    'Locked' => 'primary_red',
    'Verified' => 'valid',
    'Non-Verified' => 'primary_red',
    'Open' => 'primary_red',
    'Pending' => 'yellow-300',
    'Closed' => 'valid',
    'In Progress' => 'secondary_blue'
    ];
@endphp
<body class="font-sans antialiased ">
    <div class="min-h-screen max-h-fit bg-gray-100 ">
        <div class=" grid 2xl:grid-cols-8 xl:grid-cols-8 lg:grid-cols-8 md:grid-cols-1 sm:grid-cols-1 xs:grid-cols-1  gap-1 xs:gap-0 md:gap-0 sm:gap-0">
            <div class="z-[100]  2xl:col-span-1 xl:col-span-1 lg:col-span-1 md:col-span-1 sm:col-span-1 xs:col-span-1 lg:mr-2 xl:mr-2 sm:mb-2 md:row-span-2 ">
                @include('admin.layouts.navigation')
            </div>
            <div class="2xl:col-span-7 xl:col-span-7 lg:col-span-7 md:col-span-7 sm:col-span-7 xs:col-span-7   pt-2 pl-[14px] pr-[14px] pb-2  xs:px-0   ">

                <div class=" grid grid-cols-12 grid-rows-2  px-2 pb-2 mt-2   gap-4   max-h-fit min-h-screen   xs:max-h-full" >

                    <div class="col-span-9   xs:col-span-12 bg-white rounded-[0.5rem] p-4 ">
                        <div class="flex justify-start items-center">
                             <h1 class="text-sm">{{ __('Info') }}</h1>
                        </div>
                        <div class="flex items-center xs:grid mt-4 min-h-[80%] h-[80%]">

                            {{-- Accounts --}}
                            <div class="min-h-full h-full hover:bg-gray-50 hover:shadow hover:border-secondary_blue xs:flex xs:justify-between xs:items-center grid grid-rows-5 gap-2 border-2  rounded-[0.5rem] p-2 mx-1 xs:my-1 w-full ">
                                <div class="row-span-1">
                                <h1 class="font-bold text-md text-center">{{ __('Accounts') }}</h1>
                                </div>
                                <div class="row-span-1">
                                <h1 class="text-md  text-secondary_blue text-center ">{{ $accounts['accountCount'] }}</h1>
                                </div>
                                <div class="row-span-3 grid grid-rows-3  h-full text-sm text-center justify-center items-center mt-4">

                                    <div class="row-span-1 mt-1">

                                        @foreach($accounts['accountsStatus'] as $key => $status)
                                         <h1 class=" text-{{ $colors[$status->property] }}"><span>{{ $status->property }}{{ __(' : ') }}</span>{{ $status->count  }}</h1>

                                         @endforeach
                                    </div>
                                    <div class="row-span-1 mt-1">

                                        @foreach($accounts['accountsDates'] as $key => $date)
                                        <h1><span class="text-black">{{ $key }}{{ __(' : ') }}</span>{{ $date  }}</h1>
                                        @endforeach
                                    </div>
                                    <div class="row-span-1 mt-1">
                                        <h1 class="text-primary_red"><span>{{ __('Deleted Accounts') }}{{ __(' : ') }}</span>{{ $accounts['accountsDeleted']  }}</h1>
                                   </div>
                                </div>

                            </div>
                             {{-- Subscriptions --}}
                             <div class="min-h-full h-full hover:bg-gray-50 hover:shadow hover:border-secondary_blue xs:flex xs:justify-between xs:items-center grid grid-rows-5 gap-2 border-2  rounded-[0.5rem] p-2 mx-1 xs:my-1 w-full ">
                                <div class="row-span-1">
                                <h1 class="font-bold text-md text-center">{{ __('Subscriptions') }}</h1>
                                </div>
                                <div class="row-span-1">
                                <h1 class="text-md  text-secondary_blue text-center ">{{ $subscriptions['subscriptionsCount'] }}</h1>
                                </div>
                                <div class="row-span-3 grid grid-rows-3  h-full text-sm text-center justify-center items-center mt-4">
                                    <div class="row-span-2 mt-1">
                                         @foreach($subscriptions['subscriptionsStatus'] as $key => $plan)
                                           <div class="grid mb-4">
                                            <div><h1><span class="text-black">{{ $plan->property }}{{ __(' : ') }}</span>{{ $plan->valid+$plan->grace+$plan->locked}}</h1></div>
                                            <div class="flex justify-between items-center mt-1">
                                                <h1 class="text-{{ $colors['Valid'] }} mx-1">{{ __('Valid : ') }}{{ $plan->valid }}</h1>
                                                <h1 class="text-{{ $colors['Grace'] }}  mx-1">{{ __('Grace : ') }}{{ $plan->grace }}</h1>
                                                <h1 class="text-{{ $colors['Locked'] }}  mx-1">{{ __('Locked : ') }}{{ $plan->locked }}</h1>
                                            </div>
                                           </div>


                                         @endforeach

                                    </div>
                                    <div class="row-span-1 mt-1">
                                        <h1 class="text-primary_red"><span >{{ __('Canceled Subscriptions ') }}{{ __(' : ') }}</span>{{ $subscriptions['subscriptionssCanceled']  }}</h1>
                                   </div>

                                </div>

                            </div>
                            {{-- Users --}}
                            <div class="min-h-full h-full hover:bg-gray-50 hover:shadow hover:border-secondary_blue xs:flex xs:justify-between xs:items-center grid grid-rows-5 gap-2 border-2  rounded-[0.5rem] p-2 mx-1 xs:my-1 w-full ">
                                <div class="row-span-1">
                                <h1 class="font-bold text-md text-center">{{ __('Users') }}</h1>
                                </div>
                                <div class="row-span-1">
                                <h1 class="text-md  text-secondary_blue text-center ">{{ $users['userCount'] }}</h1>
                                </div>
                                <div class=" row-span-3 grid grid-rows-3  h-full text-sm text-center justify-center items-center  mt-4">
                                    <div class="row-span-1 mt-1">
                                         @foreach($users['userVerifiy'] as $key => $plan)
                                         <h1 class="text-{{ $colors[$plan->property] }}"><span >{{ $plan->property }}{{ __(' : ') }}</span>{{ $plan->count  }}</h1>
                                         @endforeach

                                    </div>
                                    {{-- <div class="row-span-1 mt-1">

                                        @foreach($accounts['accountsStatus'] as $key => $status)
                                         <h1><span class="text-black">{{ $status->properity }}{{ __(' : ') }}</span>{{ $status->count  }}</h1>
                                         @endforeach
                                    </div>
                                    <div class="row-span-1 mt-1">

                                        @foreach($accounts['accountsDates'] as $key => $date)
                                        <h1><span class="text-black">{{ $key }}{{ __(' : ') }}</span>{{ $date  }}</h1>
                                        @endforeach
                                    </div> --}}
                                </div>

                            </div>
                            {{-- Linked kiosks --}}
                            <div class="min-h-full h-full hover:bg-gray-50 hover:shadow hover:border-secondary_blue xs:flex xs:justify-between xs:items-center grid grid-rows-5 gap-2 border-2  rounded-[0.5rem] p-2 mx-1 xs:my-1 w-full ">
                                <div class="row-span-1">
                                <h1 class="font-bold text-md text-center">{{ __('Kiosks') }}</h1>
                                </div>
                                <div class="row-span-1">
                                <h1 class="text-md  text-secondary_blue text-center ">{{ $kiosks['kioskCount'] }}</h1>
                                </div>
                                <div class="row-span-3 grid grid-rows-3  h-full text-sm text-center justify-center items-center mt-4">
                                    {{-- <div class="row-span-1 mt-1">
                                         @foreach($kiosks['kioskStatus'] as $key => $status)
                                         <h1><span class="text-black">{{ $status->property }}{{ __(' : ') }}</span>{{ $status->count  }}</h1>
                                         @endforeach

                                    </div> --}}
                                    <div class="row-span-1 mt-1">

                                        @foreach($kiosks['kioskLink'] as $key => $value)
                                        <h1><span class="text-black">{{ $key }}{{ __(' : ') }}</span>{{ $value  }}</h1>
                                        @endforeach
                                    </div>
                                </div>

                            </div>
                            {{-- forms --}}
                            <div class="min-h-full h-full hover:bg-gray-50 hover:shadow hover:border-secondary_blue xs:flex xs:justify-between xs:items-center grid grid-rows-5 gap-2 border-2  rounded-[0.5rem] p-2 mx-1 xs:my-1 w-full ">
                                <div class="row-span-1">
                                <h1 class="font-bold text-md text-center">{{ __('Forms') }}</h1>
                                </div>
                                <div class="row-span-1">
                                <h1 class="text-md  text-secondary_blue text-center ">{{ $forms['formsCount'] }}</h1>
                                </div>
                                <div class="row-span-3 grid grid-rows-3  h-full text-sm text-center justify-center items-center mt-4">
                                    <div class="row-span-1 mt-1">
                                         @foreach($forms['formsStatus'] as $key => $status)
                                         <h1><span class="text-black">{{ $status->property }}{{ __(' : ') }}</span>{{ $status->count  }}</h1>
                                         @endforeach

                                    </div>

                                </div>

                            </div>
                            {{-- responses --}}
                            <div class="min-h-full h-full hover:bg-gray-50 hover:shadow hover:border-secondary_blue xs:flex xs:justify-between xs:items-center grid grid-rows-5 gap-2 border-2  rounded-[0.5rem] p-2 mx-1 xs:my-1 w-full ">
                                <div class="row-span-1">
                                <h1 class="font-bold text-md text-center">{{ __('Responses') }}</h1>
                                </div>
                                <div class="row-span-1">
                                <h1 class="text-md  text-secondary_blue text-center ">{{ $responses['responsesCount'] }}</h1>
                                </div>
                                <div class="row-span-3 grid grid-rows-3  h-full text-sm text-center justify-center items-center mt-4">
                                    <div class="row-span-1 mt-1">
                                         @foreach($responses['responsesDates'] as $key => $value)
                                         <h1><span class="text-black">{{ $key}}{{ __(' : ') }}</span>{{ $value  }}</h1>
                                         @endforeach

                                    </div>

                                </div>

                            </div>

                        </div>
                    </div>
                    <div class="col-span-3 xs:col-span-12  grid grid-rows-2 gap-4 ">
                        <div class="row-span-1 bg-white rounded-[0.5rem] p-4">
                            <div class="grid grid-cols-12 ">
                                {{-- email subscription --}}
                                <div class="col-span-6 xs:col-span-12">
                                    <div class="flex justify-start items-center">
                                        <h1 class="font-bold text-sm">{{ __('Email Subscriptions') }}</h1>
                                    </div>
                                    <div class="grid gap-1 mt-2">
                                            @foreach ($users['userEmailsSubscriptions'] as $key => $emailSubscribeCount )
                                                <h1 class="text-sm">{{ $key }}{{ __(' : ') }}{{$emailSubscribeCount}}</h1>
                                            @endforeach
                                    </div>
                                </div>
                                {{-- how did you know us --}}
                                <div class=" col-span-6 xs:col-span-12">
                                    <div class="flex justify-start items-center">
                                        <h1 class="font-bold text-sm">{{ __('How did you know us') }}</h1>
                                    </div>
                                    <div class="grid gap-1 mt-2">
                                            @foreach ($accounts['knowus_sources'] as $source   )
                                                <h1 class="text-sm">{{ $source['sourceType'] }}{{ __(' : ') }}{{$source['sourceCount']}}</h1>
                                            @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row-span-1 bg-white rounded-[0.5rem] p-4">
                            <div class="flex justify-start items-center">
                                <h1 class="font-bold text-sm">{{ __('Support Tickets') }}</h1>
                            </div>
                            <div class=" grid justify-start items-center mt-1">
                                <h1 class="text-sm    ">{{ __('All:') }}{{ array_sum($tickets) }}</h1>
                                <div class="text-sm  mt-2">
                                    @foreach($tickets as $key => $value)
                                    <h1 class=" mt-1 text-{{ $colors[$key] }}"><span class="">{{ $key }}{{ __(' : ') }}</span>{{ $value  }}</h1>
                                    @endforeach
                              </div>
                            </div>

                        </div>
                    </div>
                    {{-- accounts chart --}}
                    <div wire:ignore class="col-span-6 xs:col-span-12   gap-1  bg-white rounded-[0.5rem] p-4 max-h-max">
                        <div class="flex justify-between items-center " >
                            <span class="text-sm" >{{__('Accounts Rate')  }}</span>
                            <a id="button-accounts_rate_chart" onclick="showLegend('accounts_rate_chart')" class="text-secondary_blue text-sm hover:cursor-pointer hover:no-underline">Hide labels</a>

                        </div>
                        <div  class="flex w-full justify-center  px-5 p-2 bg-btn text-white items-center">
                            {{-- <canvas id="allresponses_dates" class="w-full max-h-72"></canvas> --}}
                            <canvas id="accounts_rate_chart" class="w-full max-h-72"></canvas>
                        </div>
                    </div>
                    {{-- responses chart --}}
                    <div wire:ignore class="col-span-6 xs:col-span-12   gap-1  bg-white rounded-[0.5rem] p-4 max-h-max">
                        <div class="flex justify-between items-center " >
                            <span class="text-sm" >{{__('Responses Rate')  }}</span>
                            <a id="button-responses_rate_chart" onclick="showLegend('responses_rate_chart')" class="text-secondary_blue text-sm hover:cursor-pointer hover:no-underline">Hide labels</a>

                        </div>
                        <div  class="flex w-full justify-center  px-5 p-2 bg-btn text-white items-center">
                            {{-- <canvas id="allresponses_dates" class="w-full max-h-72"></canvas> --}}
                            <canvas id="responses_rate_chart" class="w-full max-h-72"></canvas>
                        </div>
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
    <script src="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js')}}"></script>

    <script>
        var chartInstances=[];

        var responsesPerKiosk;
        var colorArray=[  "#1E88E5","#E53935","#FDD835","#43A047","#546E7A","#FB8C00","#6D4C41","#8E24AA","#C0CA33","#00ACC1",
                          "#42A5F5","#EF5350","#FFEE58","#66BB6A","#78909C","#FFA726","#8D6E63","#AB47BC","#D4E157","#26C6DA",
                          "#90CAF9","#EF9A9A","#FFF59D","#A5D6A7","#B0BEC5","#FFCC80","#BCAAA4","#CE93D8","#E6EE9C","#80DEEA",
                          "#1565C0","#B71C1C","#F57F17","#1B5E20","#263238","#E65100","#3E2723","#4A148C","#827717","#006064",
                          "#E3F2FD","#FFEBEE","#FFFDE7","#E8F5E9","#ECEFF1","#FFF3E0","#D7CCC8","#F3E5F5","#F0F4C3","#B2EBF2",

         ];
        var accountsRateData = {!! json_encode($accounts['accountsRateData'], JSON_HEX_TAG) !!};
        var responsesRateData = {!! json_encode($responses['responsesRateData'], JSON_HEX_TAG) !!};
        drawAccountsRateChart(accountsRateData);
        drawResponsesRateChart(responsesRateData);
    // accounts rate chart
    function drawAccountsRateChart(accountsRateData){
        const data =
        {
            labels:accountsRateData['labels'],
            datasets:
            [{
                label:'Accounts/Date',
                data:accountsRateData['data'],
                backgroundColor:'#1E88E5',
                borderColor: 'rgba(54, 162, 235, 1)', // Set the border color
            backgroundColor: 'transparent',
                borderWidth: 1
            }]
        };

        // config
        const config =
        {
            type: 'line',
            data,
            options: {
                responsive: true,
                legend: {
                    position: 'top',
                },
                plugins: {

            },

        }}


        // render init block
        line_chart = new Chart(
        document.getElementById('accounts_rate_chart'),
        config
        );
        chartInstances['accounts_rate_chart']=line_chart;
    }
    // responses rate chart
    function drawResponsesRateChart(responsesRateData){
        const data =
        {
            labels:responsesRateData['labels'],
            datasets:
            [{
                label:'Responses/Date',
                data:responsesRateData['data'],
                backgroundColor:'#1E88E5',
                borderColor: 'rgba(54, 162, 235, 1)', // Set the border color
                backgroundColor: 'transparent',
                borderWidth: 1
            }]
        };

        // config
        const config =
        {
            type: 'line',
            data,
            options: {
                responsive: true,
                legend: {
                    position: 'top',
                },
                plugins: {

            },

        }}


        // render init block
        line_chart = new Chart(
        document.getElementById('responses_rate_chart'),
        config
        );
        chartInstances['responses_rate_chart']=line_chart;
    }
    function showLegend(id) {
        var chart = chartInstances[id]; // Replace with your chart instance
        var currentDisplay = chart.options.legend.display;
        chart.options.legend.display = !currentDisplay; // Toggle the display status
        chart.update(); // Update the chart to apply changes

        var button = document.getElementById(`button-${id}`); // Replace with your button's ID
        if (currentDisplay) {
            button.innerText = 'Show labels';
        } else {
            button.innerText = 'Hide labels';
        }
    }

    </script>



    {{-- menubar for each form in owl carousel  --}}



    @stack('scripts')
    @stack('modals')
</body>

</html>
