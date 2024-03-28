<?php

namespace App\Http\Livewire\Signpdf;

use Livewire\Component;
use App\Models\Logos;
use App\Models\Pictures;
use App\Models\Questions;
use App\Models\QuestionTranslation;
use App\Models\QuestionType;
use App\Models\Form;
use App\Models\FormTrnslations;
use App\Models\Responses;
use App\Models\Kiosk;
use App\Models\ResponsedQuestions;
use App\models\ResponsedCustomersInfo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Answers;
use App\Models\AnswersTranslation;
use Illuminate\Support\Facades\File;
use App\Models\CustomQuestionTranslation;
use App\Models\CustomQuestion;
use App\Models\DeviceCode;
use App\Models\Account;
use App\Models\AccountUser;
use App\Models\SignFile;
use App\Models\PdfFile;
use Smalot\PdfParser\Parser;

use Carbon\Carbon;
use App\Models\ToDo;
use App\Models\SubscribePlan;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Redirect;
use Laravel\Jetstream\Jetstream;
use setasign\Fpdi\Fpdi;
class SignPdfIndex extends Component
{
    public $totalSignatures;

    public $current_form_id;
    public $current_form;
    public $signature;
    public $accountStatus;
    public $current_subscribe;
    public $main_languages;
    public $account_id;
    public $uploadedFileInfo;
    public $main_lang='{
        "en":{ "id": 1,"code":"en", "name": "English","trans":"en"},
        "ar":{ "id": 2,"code":"ar" ,"name": "Arabic","trans":"ar"},
        "ur":{ "id": 3, "code":"ur","name": "Urdu","trans":"ur"},
        "tl":{ "id": 4, "code":"tl","name": "Tagalog","trans":"fil"}
    }';
    public $languages;

    public function getListeners()
    {
            return [
                "echo:refresh.{$this->account_id},RefreshSignatue" => 'getPrevFile',

                 "getprevfile"=>"getPrevFile",


            ];
    }
    public function mount()
    {

        $this->signature=SignFile::getLastSignature(Auth::user()->current_account_id);

        $this->account_id=Auth::user()->current_account_id;

        $this->accountStatus=SubscribePlan::getCurrentAccountStatus(Auth::user()->current_account_id);
        $this->current_subscribe=SubscribePlan::getCurrentSubscription(Auth::user()->current_account_id);
        $this->main_languages=json_decode($this->main_lang, true);


    }
    public function getPrevFile(){
        $this->accountStatus=SubscribePlan::getCurrentAccountStatus(Auth::user()->current_account_id);
        $this->current_subscribe=SubscribePlan::getCurrentSubscription(Auth::user()->current_account_id);
        $this->main_languages=json_decode($this->main_lang, true);
        $this->signature=SignFile::getLastSignature(Auth::user()->current_account_id);
        $PdfFile=PdfFile::whereaccount_id(Auth::user()->current_account_id)->first();
        if($PdfFile){
        $testSizeResult=$this->testFileSize(public_path($PdfFile->path_file));


        if($testSizeResult['result']==true&& $this->signature){
        $this->uploadedFileInfo = [

            'path' =>$this->signature->path_file,

            'pageNum'=>$PdfFile->page_num,
            'size'=>$testSizeResult['message'],
        ];

        $this->dispatchBrowserEvent('prevfile-uploaded',['uploadedFileInfo' => $this->uploadedFileInfo]);

    }
        }
        }


    public function testFileSize($pdfPath){



        try
        {
            $fpdi = new FPDI;

            $count = $fpdi->setSourceFile($pdfPath);
            try
            {


                $parser = new Parser();

                // Parse the PDF file
                // $pdf = $parser->parseFile($pdfPath);

                // Initialize variables for the maximum width and height
                $maxWidth = 0;
                $maxHeight = 0;
                $pdf = $parser->parseContent(file_get_contents($pdfPath));
                $pages = $pdf->getPages();
                // this variable will contain the height and width of each page of the given PDF

                foreach ($pages as $page) {
                    $details = $page->getDetails();

                        $width = $details['MediaBox'][2];
                        $height = $details['MediaBox'][3];
                        // Update the maximum width and height if the current page is larger
                        $maxWidth = max($maxWidth, $width);
                        $maxHeight = max($maxHeight, $height);
                }
                $size=['height'=>$maxHeight,'width'=>$maxWidth];

                return ['result'=>true, 'message' => $size];


            }
            catch (\Throwable $th)
            {
                return ['result'=>false,'title'=>trans('main.filesizenotcaptured_title') , 'message' => trans('main.filesizenotcaptured')];

            }
        } catch (\Throwable $th) {

            return ['result'=>false,'title'=>trans('main.unsupportedfile_title') , 'message' => trans('main.unsupportedfile')];
         }

    }
    public function download()
    {
        $this->signature=SignFile::getLastSignature(Auth::user()->current_account_id);
        $path = public_path($this->signature->path_file);
        $filename = 'signature.pdf';
         $this->mount();
        return response()->download($path, $filename);
    }

    public function DeletePdf($file_id){
        $file=SignFile::whereid($file_id)->first();
        File::delete(public_path($file->path_file));
        $file->delete();
        $this->mount();
    }
    public function refreshsignature()
    {
        $this->mount();
    }


    public function render()
    {
        return view('livewire.signpdf.sign-pdf-index');
    }
}
