<?php

namespace App\Http\Livewire\Signpdf;

use Livewire\Component;
use App\Models\User;
use App\Models\Kiosk;
use Illuminate\Support\Facades\DB;
use App\Models\Questions;
use App\Models\QuestionTranslation;
use App\Models\Form;
use App\Models\Answers;
use App\Models\Logos;
use App\Models\FormTrnslations;
use App\Models\AnswersTranslation;
use App\Models\QuestionType;
use Illuminate\Support\Facades\File;
use App\Models\Pictures;
use App\Models\CustomQuestionTranslation;
use App\Models\CustomQuestion;
use App\Models\DeviceCode;
use App\Models\Account;
use App\Models\Responses;
use App\Models\ResponsedQuestions;
use App\models\ResponsedCustomersInfo;
use Carbon\Carbon;
use App\Models\Subscribe;
use App\Models\Fact;
use App\Models\SubscribePlan;
use App\Models\TypeSubscribe;
use App\Models\PdfFile;
use App\Models\SignFile;
use App\Models\PdfFileTranslation;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Notifications\ResponsesWarning;
use App\Notifications\ResponsesZeroWarning;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Jobs\RefreshKiosk;
use App\Jobs\RefreshSignatueAccount;

use \PDF;
use Dompdf\Dompdf;
use setasign\Fpdi\Fpdi;
use Illuminate\Support\Facades\Storage;
class SignPdfTemplate extends Component
{
    public $deviceinfo;
    public $currentkiosk;
    public $current_formid;
    public $formPdfFile;
    public $current_message;
    public $current_account_id;
    public $buttonsText;
    public $url;
    public $buttonsLang='{
        "en":{"clear":"Clear","finish":"Finish"},
        "ar":{"clear":"مسح","finish":"إنهاء"},
        "tl":{"clear":"malinaw","finish":"tapusin"},
        "ur":{"clear":"صاف","finish":"ختم"}
    }';
    public function getListeners()
    {
            return [
                "echo:refresh.{$this->currentkiosk->device_code_id},DeviceRefresh" => 'refreshpage',
                'saveAsPDF' => 'saveAsPDF',
                'timeout'=>'timeOut',
                'updatekioskstatus'=>'setPreviousStatusKiosk'


            ];
    }
    public function refreshpage($url)
    {

        Redirect::to($url['url']);
        // $this->dispatchBrowserEvent('ReloadPage');
    }
    public function mount()
    {
        $this->url=url()->current();

        $this->deviceinfo = explode('/', $this->url);
        $this->currentkiosk=Kiosk::wheredevice_code_id($this->deviceinfo[5])->first();

        $this->currentkiosk!=null?$this->current_account_id=$this->currentkiosk->account_id:null;
        $this->formPdfFile=PdfFile::whereaccount_id($this->current_account_id)->first();

        $this->current_message=PdfFileTranslation::wherefile_id($this->formPdfFile->id)->wherelocal($this->formPdfFile->language)->first();
        $this->buttonsText=json_decode($this->buttonsLang, true)[$this->formPdfFile->language];


        $this->dispatchBrowserEvent('fileFetched',['formPdfFile' =>$this->formPdfFile]);

    }
    public function saveAsPDF($dataUrl){
        // try
        // {
            $path = 'storage/accounts/account-' . Auth::user()->current_account_id . '/files/signatures/';
            $name="SignedFile_".$this->currentkiosk->id."_"."_".Carbon::now()->format('Ymd_His').".pdf";
            if (!file_exists($path)) {
                mkdir($path, 666, true);
            }
            $file = public_path($this->formPdfFile->path_file);
            $outputFile=$path.$name;
            $outputFilePath = public_path($outputFile);

            $fpdi = new FPDI;

            $count = $fpdi->setSourceFile($file);

            for ($i=1; $i<=$count; $i++) {

                $template = $fpdi->importPage($i);
                $size = $fpdi->getTemplateSize($template);
                $fpdi->AddPage($size['orientation'], array($size['width'], $size['height']));
                $fpdi->useTemplate($template);

                $fpdi->SetFont("helvetica", "", 15);
                $fpdi->SetTextColor(153,0,153);

            if($i==$this->formPdfFile->page_num){
                $start_x = $this->formPdfFile->start_x;  // Replace with your actual start_x
                $start_y = $this->formPdfFile->start_y;  // Replace with your actual start_y
                $end_x = $this->formPdfFile->end_x;   // Replace with your actual end_x
                $end_y = $this->formPdfFile->end_y;   // Replace with your actual end_y

                $imageWidth =abs($end_x-$start_x );
                $imageHeight = abs($end_y-$start_y);
                // Use the converted coordinates
                $start_x =$this->formPdfFile->start_x>$this->formPdfFile->end_x?
                $this->formPdfFile->end_x:$this->formPdfFile->start_x;  // Replace with your actual start_x
                $start_y =$this->formPdfFile->start_y>$this->formPdfFile->end_y?
                $this->formPdfFile->end_y:$this->formPdfFile->start_y;  // Replace with your actual start_y
                $imagePath=$this->saveImageDrawing($dataUrl);
                $fpdi->Image(public_path($imagePath), $start_x, $start_y,$imageWidth,$imageHeight);
            }
            }


            $fpdi->Output($outputFilePath, 'F');
            $singedFile=new SignFile();
            $singedFile->pdffile_id=$this->formPdfFile->id;
            $singedFile->path_file=$outputFile;
                //$user->timezone
            $singedFile->created_at=Carbon::now()->timezone('Asia/Dubai');
            $singedFile->save();


            $this->setPreviousStatusKiosk();

        // to increase count of signedpdf +1  in facts
            Fact::increseFactCount('signedpdf');

            try {
                RefreshSignatueAccount::dispatch($this->current_account_id);
            } catch (\Throwable $th) {
                //throw $th;
            }

            $this->dispatchBrowserEvent('submitted');


        // }
        // // catch (\Throwable $th) {

        // // }
    }
 // function to set status kiosk to previous status
    public function setPreviousStatusKiosk(){
        $this->currentkiosk->form_id=null;
        $this->currentkiosk->sign_kiosk=false;
        $this->currentkiosk->save();
        // $this->dispatchBrowserEvent('refreshkiosknow');
        // RefreshKiosk::dispatch($this->currentkiosk);
    }

    public function saveImageDrawing($dataUrl){
        list($type, $data) = explode(';', $dataUrl);
        list(, $data)      = explode(',', $data);
        $imageData = base64_decode($data);
        $folderPath = public_path('storage/images/drawing/');
        if (!file_exists($folderPath)) {
            mkdir($folderPath, 0777, true);
        }
        // Define the path to save the image

        $imageName = 'test.png'; // Name of the new image file
        $fileName = $folderPath .$imageName;
        // Save the image to the specified path
        file_put_contents($fileName, $imageData);
        return 'storage/images/drawing/'.$imageName;
    }
    public function timeOut(){

        $this->setPreviousStatusKiosk();
        //  RefreshKiosk::dispatch($this->currentkiosk);
        $this->dispatchBrowserEvent('refreshkiosknow');
    }
    public function render()
    {
        return view('livewire.signpdf.sign-pdf-template');
    }
}
