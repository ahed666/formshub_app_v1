
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>{{ $invoice->invoice_no }}</title>
        <link rel="stylesheet" href="{{ asset('https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css') }}">
        {{-- <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css" /> --}}
        <style>
            .border-custom {
              border-bottom: 2px solid #69AEE1; /* Replace with your custom color code */
            }
            .border-custom-thin {
              border-bottom: 5px solid #69AEE1; /* Replace with your custom color code */
            }
            .custom-color{
                color: #69AEE1;
            }
            .bg-custom-color-gray{
                background-color: #d3d3d3;
            }
            .custom-height {
                height: 120px; /* Replace with your desired height value */
            }
            .custom-bg {
                background-color: #82beec;
            }
            .panel-footer {
                display: flex;
                justify-content: space-between;
                }
            body {
            font-family: 'Calibri', sans-serif;
           }
           .invoice-table tr {
        margin-bottom: 2px;
    }
          </style>
    </head>
<body>

<div class=" w-100 custom-height   ">

    <div class="row">
        <div class="w-25     float-left ">
            <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('/images/logos/invoice_logo.png'))) }}" style="width: 80px; height: 45px;">


        </div>
        <div style="" class="w-25    float-right ">

             <h6><small>{{ __('Netcore IT Solutions - Sole Proprietorship L.L.C') }} </small></h6>
             <h6><small>{{ __('26 Al Twi st,Central District,Al Ain 30027') }}</small></h6>
             <h6><small>{{ __('TRN:10053094460003') }}</small></h6>

        </div>
    </div>





</div>
<div class="d-flex align-items-center border-custom" >
    <h4 class="justify-content-center text-center custom-color">TAX INVOICE</h4>
</div>

{{-- customer info --}}
<div class=" w-100 mb-5  ">
    <table class=" table table-borderless ">


        <tbody class="invoice-table" >



                {{-- <tr >
                    <td scope="col"  class="w-25 text-nowrap custom-color " ><small>{{ __('Invoice to:') }}</small></td>
                    <td scope="col" class="w-50"><small>{{$invoice->business_name }}</small></td>
                    <td scope="col"  class="w-25 ml-4 text-nowrap custom-color" ><small>{{ __('Date:') }}</small></td>
                    <td scope="col" class="w-25"><small>{{ $invoice->created_at->format('Y-m-d') }}</small></td>
                    <!-- Add more table cells as needed -->
                </tr>
                <tr >
                    <td scope="col"  class=" w-25 text-nowrap custom-color " ><small>{{ __('Attention:') }}</small></td>
                    <td scope="col" class="w-50"><small>{{ $invoice->account_name }}</small></td>
                    <td scope="col"  class="w-25 ml-4 text-nowrap custom-color" ><small>{{ __('Invoice No.:') }}</small></td>
                    <td scope="col" class="w-25"><small>{{ $invoice->invoice_no }}</small></td>
                    <!-- Add more table cells as needed -->
                </tr>
                <tr >
                    <td scope="col"  class=" w-25 text-nowrap custom-color " ><small>{{ __('Location:') }}</small></td>
                    <td scope="col" class="w-50"><small>{{ $invoice->location }}</small></td>
                    <td scope="col"  class=" w-25 ml-4 text-nowrap custom-color" ><small>{{ __('Customer TRN:') }}</small></td>
                    <td scope="col" class="w-25"><small>{{ $invoice->trn}}</small></td>
                    <!-- Add more table cells as needed -->
                </tr> --}}
                <tr >
                    <td scope="col" style="width: 65%"  class=" " >
                        <small class="text-nowrap custom-color ">{{ __('Business Name:') }}</small>
                        <small>{{$invoice->business_name }}</small>
                    </td>

                    <td scope="col" style="width: 35%"  class=" text-nowrap " >
                        <small class="text-nowrap custom-color">{{ __('Date:') }}</small>
                        <small>{{ $invoice->created_at->format('Y-m-d') }}</small>
                    </td>

                    <!-- Add more table cells as needed -->
                </tr>
                <tr >
                    <td scope="col" style="width: 65%"  class="  " >
                        <small class="text-nowrap custom-color">{{ __('Person Name:') }}</small>
                        <small>{{ $invoice->account_name }}</small>
                    </td>
                    <td scope="col" style="width: 35%" class=" text-nowrap " >
                        <small class="text-nowrap custom-color">{{ __('Invoice No.:') }}</small>
                        <small>{{ __('FHINV-') }}{{ $invoice->invoice_no }}</small>
                    </td>

                    <!-- Add more table cells as needed -->
                </tr>
                <tr >
                    <td scope="col"  style="width: 65%" class="  " >
                        <small class="text-nowrap custom-color ">{{ __('Location:') }}</small>
                        <small>{{ $invoice->location }}</small>
                    </td>
                    <td scope="col"  style="width: 35%" class="text-nowrap " >
                        <small class="text-nowrap custom-color">{{ __('Customer TRN:') }}</small>
                        <small>{{ $invoice->trn}}</small>
                    </td>
                    <!-- Add more table cells as needed -->
                </tr>


        </tbody>
    </table>




</div>
{{-- table of invoice --}}
<div class=" w-100 mt-5 ">
    <table class="table table-bordered  ">
        <thead >
            <tr class="bg-custom-color-gray" >
                <th class="text-center text-nowrap"><small>SN</small></th>
                <th class="text-center text-nowrap" ><small>Description</small></th>
                <th class="text-center text-nowrap"><small>Taxable Amount</small></th>
                <th class="text-center text-nowrap" style="color:rgb(243, 59, 59)"><small>5% TAX</small></th>
                <th class="text-center text-nowrap"><small>Total Amount</small></th>
                <!-- Add more table headers as needed -->
            </tr>
        </thead>
        <tbody >



                <tr >
                    <td class="text-center" ><small>{{ __('1') }}</small></td>
                    <td class="" ><small>{{ $invoice->invoice_description }}</small></td>
                    <td class="text-nowrap text-center" ><small>{{ __('AED ') }}{{ number_format($invoice->price_ex_tax , 2) }}</small></td>
                    <td class="text-nowrap text-center" style="color:rgb(243, 59, 59)"  ><small>{{ __('AED ') }}{{ number_format($invoice->price_ex_tax*($invoice->tax/100) , 2) }}
                       </small></td>
                    <td class="text-nowrap text-center" ><small>{{ __('AED ') }}{{ number_format($invoice->price_in_tax , 2) }}</small></td>
                    <!-- Add more table cells as needed -->
                </tr>


        </tbody>
    </table>

    <div  style="margin-top: 15px"  class=" float-right">
        <table class="table table-borderless">





            <tr>
                <td style="text-align: right"><small>{{ __('Total Exc. TAX:') }}</small></td>
                <td ><small>{{ __(' AED ') }}</small><small>{{ number_format($invoice->price_ex_tax, 2) }} </small></td>
            </tr>
            <tr>
                <td style="color:rgb(243, 59, 59);text-align: right"><small>{{ __('Total TAX:') }}</small></td>
                <td style="color:rgb(243, 59, 59)"><small>{{ __(' AED ') }}</small><small>{{ number_format($invoice->price_ex_tax*($invoice->tax/100) , 2) }}</small></td>

            </tr>
            <tr class="custom-bg">
                <td style="text-align: right"><small>{{ __('Due Amount:') }}</small></td>
                <td><small>{{ __(' AED ') }}</small><small>{{ number_format($invoice->price_in_tax , 2) }}</small></td>
            </tr>
            {{-- <tr style="border-bottom: 2px solid #000000;" >
                <td ><small>{{ __('AED ') }}{{ $invoice->price_ex_tax }}</small></td>
                <td style="color:rgb(243, 59, 59)"><small>{{ __('AED ') }}{{ $invoice->price_ex_tax*$invoice->tax }}</small></td>
                <td><small>{{ __('AED ') }}{{ $invoice->price_in_tax }}</small></td>

            </tr>

            <tr >
                    <td><small>{{ __('Total Exc. TAX') }}</small></td>
                    <td style="color:rgb(243, 59, 59)"><small>{{ __('Total TAX') }}</small></td>
                    <td><small>{{ __('Due Amount') }}</small></td>

            </tr> --}}


        </table>
    </div>

</div>
{{-- terms and conditions --}}

<div style="margin-top:200px" class=" w-100   ">
     <h6><small>{{ __('Account ID:') }}</small><small>{{ 'AC-'.$account->id }}</small></h6>
    <div class="border-custom-thin "></div>
    <div class="row pl-2">
        <h6><span class="mx-2">{{ __('>') }}</span><small>{{ __('This invoice is computer generated, no signature required.') }} </small></h6>
    </div>
</div>
{{-- <div style="margin-top:100px" class=" d-flex  align-items-center">
    <h5><span class="mx-2 justify-content-center">{{ __('*') }}</span><small>{{ __('End of Invoice') }} </small>{{ __('*') }}</h5>
</div> --}}
<div style="margin-top:200px" class="d-flex align-items-center " >
    <h6 class="justify-content-center text-center "><span class="mx-2 justify-content-center">{{ __('*') }}</span><small>{{ __('End of Invoice') }} </small>{{ __('*') }}</h6>
</div>

<script src="{{ asset('js/app.js') }}" type="text/js"></script>
</body>
</html>
