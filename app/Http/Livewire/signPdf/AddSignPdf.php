<?php

namespace App\Http\Livewire\Signpdf;

use Livewire\Component;
use App\Models\Answers;
use App\Models\AnswersTranslation;
use App\Models\CustomQuestion;
use App\Models\Kiosk;
use App\Models\Logos;
use App\Models\Pictures;
use App\Models\Questions;
use App\Models\QuestionTranslation;
use App\Models\QuestionType;
use App\Models\Form;
use App\Models\PdfFileTranslation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use App\Events\DeviceRefresh;
use App\Models\Subscribe;
use App\Models\SubscribePlan;
use App\Models\TypeSubscribe;
use App\Models\PdfFile;
use App\Models\SignFile;
use Carbon\Carbon;
use App\Jobs\RefreshKiosks;
use App\Jobs\RefreshKiosk;
// google translate api
use Stichoza\GoogleTranslate\GoogleTranslate;
use Livewire\WithFileUploads;
use setasign\Fpdi\Fpdi;
use Illuminate\Support\Facades\Validator;
use Spatie\PdfToText\Pdf;

use Smalot\PdfParser\Parser;
use Illuminate\Support\Facades\Storage;

use Spatie\Pdf\Pdf as SpatiePdf;
use Spatie\Pdf\Text;
class AddSignPdf extends Component
{   use WithFileUploads;

    public $currentFile;
    public $uploadedFileInfo;
    public $PdfFile;

    public $current_form_id;
    public $fileMessages;

    public $current_form;
    public $languages;
    public $current_form_kiosks;
    public $allKiosks;
    public $selectedKiosk;
    public $selectedLanguage="en";

    //    to set the id of form that want user delete it
    public $form_delete_id;
    // add form details
    public $form_logo;

    public $logo;
    public $form_BusinessName;
    public $form_Name;
    public $modal = false;
    // end add form details
    public $current_languages;
    public $main_languages;
    //    edit question
    public $questionediting;
    public $current_questions;
    public $modalopen = false;


    //    form options
    public $formexpiry = false;
    public $formexpirydate = null;
    public $service = false;
    public $score=false;
    public $terms=false;

    // end of form options
    //subscribe
    public $validAccount;
    public $current_subscribe;
    public $accountStatus;
    //end of subscribe
    //    messages of form
    public $current_message;
    public $tempFile;
    // end messages of form
    public $lang =
        '[
           { "id": 1,"code":"en", "name": "English"},
           { "id": 2,"code":"ar" ,"name": "Arabic"},
           { "id": 3, "code":"ur","name": "Urdu"}
    ]';
    public $main_lang = '[
        { "id": 1,"code":"en", "name": "English","trans":"en"},
        { "id": 2,"code":"ar" ,"name": "Arabic","trans":"ar"},
        { "id": 3, "code":"ur","name": "Urdu","trans":"ur"},
        { "id": 4, "code":"tl","name": "Tagalog","trans":"fil"}
    ]';
    public $questions;
    public $answers_json_text='[
        {"type":"yes_no",
            "en":{"0":"Yes","1":"No"},
            "ar":{"0":"نعم",
                   "1":"لا"},
            "tl":{"0":"Oo","1":"Hindi"},
            "ur":{"0":"جی ہاں",
                "1":"نہیں"}
        },
        {"type":"like_dislike",
            "en":{"0":"Like","1":"Dislike"},
            "ar":{"0":"اعحبني",
                "1":"لم يعجبني"},
            "tl":{"0":"Gaya ng","1":"Ayaw"},
            "ur":{"0":"پسند",
                "1":"ناپسندیدگی"}
        },
        {"type":"Agree_Disagree",
            "en":{"0":"Agree","1":"Disagree"},
            "ar":{"0":"أوافق",
                "1":"لا أوافق"},
            "tl":{"0":"Sumang-ayon","1":"Hindi Sumasang-ayon"},
            "ur":{"0":"متفق",
                "1":"متفق نہیں"}
        }
    ]';
    public $answers_json_text_satisfaction='
    {"type":"satisfaction","custom_type":"custom_satisfaction",
    "ar":{"0":"راضي تماماٌ",
        "1":"راضي",
        "2":"محايد",
        "3":"غير راضي",
        "4":"غير راضي تماماٌ"},
        "en":{"0":"Very Satisfied","1":"Satisfied","2":"Natural","3":"Unsatisfied","4":"Very Unsatisfied"},
        "ur":{"0":"مکمل طور پر مطمئن",
            "1":"مطمئن",
            "2":"غیر جانبدار",
            "3":"غیر مطمئن",
            "4":"مکمل طور پر غیر مطمئن"},
        "tl":{"0":"Ganap na Nasiyahan","1":"Nasiyahan","2":"Natural","3":"Hindi Nasisiyahan","4":"Ganap na Hindi Nasisiyahan"}
    }
';
public $answers_json_text_rating='
 {"type":"rating","custom_type":"custom_rating","0":"5","1":"4","2":"3","3":"2","4":"1"}
';

    protected $listeners = [
        "signPdf"=>"signPdf",
        "checkPrevFile"=>"checkPrevFile",

    ];




    protected $rules = [
        'selectedKiosk' => 'required',
        'selectedLanguage' => 'required',
    ];
      public function __construct() {
        $this->messages = [
            'selectedKiosk.required' => trans('main.selectkioskwarning'),
            'selectedLanguage.required' => 'Please select one Language.',
            // Add other custom messages as needed
        ];
    }






    public function mount()
    {

        // $url=url()->current();
        // $forminfo = explode('/', $url);

        $this->PdfFile=PdfFile::whereaccount_id(Auth::user()->current_account_id)->first();
        // if first time atttemp to add signature the add ne pdf file to this account
        if($this->PdfFile==null)
        {   $this->PdfFile=new PdfFile();
            $this->PdfFile->account_id=Auth::user()->current_account_id;

            $this->PdfFile->save();
            PdfFileTranslation::addMessages($this->PdfFile->id);
        }
        $this->fileMessages=PdfFileTranslation::getMessages($this->PdfFile->id);


        // subscirbe info and settings
        $this->current_subscribe=SubscribePlan::getCurrentSubscription(Auth::user()->current_account_id);

        $this->accountStatus=SubscribePlan::getCurrentAccountStatus(Auth::user()->current_account_id);

        //end of subscribe info



        $this->main_languages = json_decode($this->main_lang, true);

        // get kiosks of this account that ready to signature
        $this->allKiosks = Kiosk::getReadySignatureKiosks(Auth::user()->current_account_id);


        Kiosk::whereaccount_id(Auth::user()->current_account_id)->get();


        $this->current_languages = $this->getLocales();





        //    $this->form_logo="images/logo_1_transparent_dark.png";
        //    $this->logo="images/logo_1_transparent_dark.png";
        //    $this->modal=false;

        // $this->questionediting=new Questions();

    }
    // check if there is prev file then load it
    public function checkPrevFile(){

        if($this->PdfFile&&$this->PdfFile->path_file!=null)$this->getPrevFile();
        $this->mount($this->current_form_id);
    }
    // load new file
    public function updatedcurrentFile(){


         try
         {

            $testSizeResult=$this->testFileSize($this->currentFile->path());

         if($testSizeResult['result']==true){
        // $temporaryPath = $this->currentFile->storeAs('files/temp', $this->currentFile->getClientOriginalName(), 'public');
        $temporaryPath = $this->currentFile->storeAs('storage/files/temp', $this->currentFile->getClientOriginalName(), 'public');

            // Get the URL to the stored file
        // $url = Storage::url($temporaryPath);


        // Save the PDF file to the specified path
        // File::put($storagePath . $filename, $pdfBinary);
        $this->uploadedFileInfo = [
            'name' => $this->currentFile->getClientOriginalName(),
            'path' =>$temporaryPath,
            'size'=>$testSizeResult['message'],
        ];

        $this->dispatchBrowserEvent('file-uploaded',['uploadedFileInfo' => $this->uploadedFileInfo]);
        }
        else
     $this->dispatchBrowserEvent('error',['title' => $testSizeResult['title'],'message' => $testSizeResult['message']]);

        }catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function testFileSize($pdfPath){



        try
        {
            $fpdi = new FPDI;

            $count = $fpdi->setSourceFile($pdfPath);
            try
            {
                //code...

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
    // load prev file
    public function getPrevFile(){
        $testSizeResult=$this->testFileSize(public_path($this->PdfFile->path_file));

        if($testSizeResult['result']==true){
        $this->uploadedFileInfo = [

            'path' =>$this->PdfFile->path_file,
            'start_cx'=>$this->PdfFile->start_cx,
            'start_cy'=>$this->PdfFile->start_cy,
            'end_cx'=>$this->PdfFile->end_cx,
            'end_cy'=>$this->PdfFile->end_cy,
            'pageNum'=>$this->PdfFile->page_num,
            'size'=>$testSizeResult['message'],
        ];
        $this->dispatchBrowserEvent('prevfile-uploaded',['uploadedFileInfo' => $this->uploadedFileInfo]);
     }
    }

    // get locales of form
    public function getLocales()
    {
        $locales = PdfFileTranslation::
            where('file_id', '=', $this->PdfFile->id)->
            select('pdf_files_translations.local')->get();
        $locales = json_decode($locales, true);
        $formlocales = [];
        foreach ($locales as $i => $local) {foreach ($this->main_languages as $main) {
            if ($local['local'] == $main['code']) {
                $collect = collect(
                    ["id" => $main['id'],
                        "code" => $local['local'],
                        "name" => $main['name'],
                        "trans" => $main['trans'],

                    ]
                );

                array_push($formlocales, $collect);
            }
        }

        }

        return $formlocales;

    }
    // get selected kiosks;
    public function changeStatusSelectedKiosk($kioskid){
        $updatedKiosk;

            $kiosk = Kiosk::find($kioskid);
            if ($kiosk) {

                $kiosk->form_id = null;
                $kiosk->sign_kiosk = true;
                $kiosk->save();
                $updatedKiosk = $kiosk;
            }


      return $updatedKiosk;
    }
    public function validateMessages($fileMessages){
        $rules["fileMessages.*.message"] = 'required';
        $validator = Validator::make($fileMessages, $rules);


    }
    // save fileMessages
    public function editMessages(){
         $this->validateMessages($this->fileMessages);
         try {

        foreach ($this->fileMessages as $key => $message) {
           $msg=PdfFileTranslation::find($message['id']);
           if($msg)
            {$msg->message=$message['message'];
                $msg->save();}
        }
        return redirect()->route('signpdf.add')->with('success_message_messagessaved',trans('main.success_message_messagessaved_text'));
       } catch (\Throwable $th) {

        }

    }
    // send pdf to sign it
    public function signPdf($start_x,$start_y,$end_x,$end_y,$start_cx,$start_cy,$end_cx,$end_cy,$page_num){

        $this->validate();
        if($this->PdfFile!=null&&$this->uploadedFileInfo!=null){
            // if there is file for first time attempt
            if($this->PdfFile->path_file!=null||$this->uploadedFileInfo['path']!=null){
            try {

                // delete previous file
                if($this->uploadedFileInfo['path']!=$this->PdfFile->path_file)
                    {
                        $path = 'storage/accounts/account-' . Auth::user()->current_account_id . '/files/';
                        if (!file_exists($path)) {
                            mkdir($path, 0755, true);
                        }
                        $newPath = $path .'tosignpdf.pdf';
                        file::move( $this->uploadedFileInfo['path'], $newPath);
                        $this->uploadedFileInfo['path']= $newPath;

                    }

                // delete previous signed pdf
                SignFile::deleteLastSignature(Auth::user()->current_account_id);



                $this->PdfFile->language=$this->selectedLanguage;
                $this->PdfFile->start_x=$start_x;
                $this->PdfFile->start_y=$start_y;
                $this->PdfFile->end_x=$end_x;
                $this->PdfFile->end_y=$end_y;
                $this->PdfFile->page_num=$page_num;
                $this->PdfFile->start_cx=$start_cx;
                $this->PdfFile->start_cy=$start_cy;
                $this->PdfFile->end_cx=$end_cx;
                $this->PdfFile->end_cy=$end_cy;
                $this->PdfFile->path_file=$this->uploadedFileInfo['path'];
                $this->PdfFile->save();
                $kiosk=$this->changeStatusSelectedKiosk($this->selectedKiosk);
                RefreshKiosk::dispatch($kiosk);
                // $this->dispatchBrowserEvent('close_modal_addkiosks');
                return redirect()->route('signpdf.index')->with('success_message_signed','signed');

                //code...
                } catch (\Throwable $th) {
                    $this->dispatchBrowserEvent('error',['title'=>trans('main.errorwhileupload_title') ,'message'=>trans('main.errorwhileupload')]);

                }
            }
            else{
                $this->dispatchBrowserEvent('error',['title'=>trans('main.errornopdf') ,'message'=>trans('main.errornopdf')]);
            }
        }
        else{
            $this->dispatchBrowserEvent('error',['title'=>trans('main.errornopdf') ,'message'=>trans('main.errornopdf')]);
        }
    }

    public function render()
    {
        return view('livewire.signpdf.add-sign-pdf');
    }
}
