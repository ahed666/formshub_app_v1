<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Invoice;
use App\Models\Account;
use Illuminate\Support\Facades\Auth;
use \PDF;
use Dompdf\Dompdf;

use Carbon\Carbon;
class Billings extends Component
{    public $invoices;
    public $sortfield='invoice_no';
    public $sortdirection='asc';
    public $searchtext='';
    public $filtertext=null;

    public function mount()
    {
       $this->invoices=Invoice::whereaccount_id(Auth::user()->current_account_id)->orderBy('invoice_no', 'asc')
       ->orderBy('invoice_description', 'asc')
       ->orderBy('price_ex_tax', 'asc')->orderBy('invoice_date', 'asc')->get();

    }
    /* searching method*/


    /*sorting methods*/
    // invoiceno method
    public function sortBy($field)
    {
      if( $this->sortfield===$field)
      {
        $this->sortdirection=$this->sortdirection==='asc'?'desc':'asc';
      }
      else
      {
        $this->sortdirection='asc';
      }
      $this->sortfield=$field;
    }


    /*end of methods */
    // filter
    public function setfilter($filter)
    {
        $this->filtertext=$filter;
    }
    public function print($id){

        $invoice = Invoice::whereid($id)->first();
        $account=Account::whereid(Auth::user()->current_account_id)->first();

        // $pdf = PDF::loadView('pdf.invoice', compact('invoices'));


        // // return redirect()->route('invoicepdf',$id);
        // return response()->streamDownload(function () use($pdf) {
        //     echo $pdf->download('document.pdf');
        // }, 'report.pdf');
        // // return $pdf->download('document.pdf');

        $html = view('pdf.invoice', compact('invoice','account'))->render(); // Assuming you have a blade view file named 'page'

        // Generate the PDF file name
        $filename ='FHINV-'.$invoice->invoice_no;

        // Generate the PDF using Laravel-Dompdf
        $pdf = PDF::loadHTML($html);
        $pdf->setPaper('A4', 'portrait');

        // Download the PDF file
        return response()->streamDownload(function () use($pdf) {
                    echo $pdf->download('document.pdf');
                },$filename.'.pdf');
    }
    public function render()
    {
        if($this->filtertext!=null&&$this->searchtext=='')
        {$this->invoices=Invoice::whereaccount_id(Auth::user()->current_account_id)
        ->where('status',$this->filtertext)
        ->orderBy($this->sortfield,  $this->sortdirection)->get();}
        else
        {
            $this->invoices=Invoice::whereaccount_id(Auth::user()->current_account_id)
            ->where(function ($query)  {
                $query->where('invoice_no','like','%' .$this->searchtext.'%');
            })->orderBy($this->sortfield,  $this->sortdirection)->get();

        }
        return view('livewire.billings');
    }
}
