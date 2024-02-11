<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
use App\Models\ResponsedCustomersInfo;
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
use App\Models\ToDo;
use App\Models\Signfile;
use App\Models\PdfFile;

use Carbon\Carbon;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Redirect;
use Laravel\Jetstream\Jetstream;
use App\Models\Subscribe;
use App\Models\SubscribePlan;
use App\Models\TypeSubscribe;
use Illuminate\Pagination\Paginator;
use \PDF;
use Dompdf\Dompdf;
class PDFController extends Controller
{

    public function initialResponses($id,$langView){

        $response=Responses::whereid($id)->first();



            $questions1=ResponsedQuestions::where('response_id','=',$response->id)

            ->join('question_translations','question_translations.question_id','=','responsed_questions.question_id')
            ->leftJoin('answer_translations',function($join)use($response,$langView){
                $join->on('answer_translations.answer_id','=','responsed_questions.answer_id')
                ->where('answer_translations.answer_local', '=',$langView);})
                ->join('questions','questions.id','=','responsed_questions.question_id')
            ->join('type_of_questions','type_of_questions.id','=','questions.type_of_question_id')
            ->where('question_translations.question_local','=',$langView)
            ->select('responsed_questions.*','question_translations.question_details','type_of_questions.question_type','answer_translations.answer_details as answer')->get();

            $questions2=ResponsedCustomersInfo::where('response_id','=',$response->id)
            ->join('question_translations','question_translations.question_id','=','responsed_customers_info.question_id')
            ->join('questions','questions.id','=','responsed_customers_info.question_id')
            ->join('type_of_questions','type_of_questions.id','=','questions.type_of_question_id')
            ->where('question_translations.question_local','=',$langView)
            ->select('responsed_customers_info.*','type_of_questions.question_type','question_translations.question_details')->get();

            $questions = array_merge(json_decode($questions1, true), json_decode($questions2, true));
            $response->reviewed_at =date_create($response->reviewed_at);
            $response->reviewed_at =date_format($response->reviewed_at,'Y-m-d H:i');

            $collect=collect(
                    ["id"=>$response->id,
                    "id_view"=>$response->id_view,
                    "todo"=>(bool)$response->todo,
                    "form_id"=>$response->form_id,
                    "score"=>$response->score,
                    "device_id"=>$response->device_id,
                    "lang"=>$response->response_language,
                    "viewed"=>$response->viewed,
                    "complet_percent"=>$response->complet_percent,
                    "reviewed_at"=>date($response->reviewed_at),
                    "questions"=>$questions,

                    ]
                );

           return $collect;

    }
    public function response($id,$lang){

        $response=$this->initialResponses($id,$lang);

        $questions= $this->questions=Questions::where('questions.form_id','=',$response['form_id'])
        ->join('type_of_questions','type_of_questions.id','=','questions.type_of_question_id')
        ->join('question_translations','question_translations.question_id','=','questions.id')->where('question_translations.question_local','=',$lang)
        ->select('questions.*','type_of_questions.question_type','question_translations.question_details','question_translations.question_local')->orderBy('questions.question_order')->get();
        $form=Form::where('forms.id','=',$response['form_id'])->leftJoin('logos','logos.id','=','forms.logo_id')->select('forms.*','logos.logo_url')->first();
       
        return  view('pdf.response',compact('response','questions','lang','form'));

    }
    public function viewPdf($id)
    {

        $file=Signfile::find($id);
        if($file)
        {
             // check if this file for current account
           $current_account_file=PdfFile::whereaccount_id(Auth::user()->current_account_id)->first();

            if($file->pdffile_id==$current_account_file->id)

            {  $filePath = public_path($file->path_file); // Adjust the path as needed
                $headers = ['Content-Type: application/pdf'];

                return response()->file($filePath, $headers);
            }
          else
          abort(403, 'Unauthorized action.');
        }
        else
          abort(403, 'Unauthorized action.');


    }
    public function downloadPdf($id)
    {
        $file=Signfile::find($id);
        if($file)
        {
            // check if this file for current account
           $current_account_file=PdfFile::whereaccount_id(Auth::user()->current_account_id)->first();
            if($file->pdffile_id==$current_account_file->id)

            {  $filePath = public_path($file->path_file); // Adjust the path as needed


                return response()->download($filePath);
            }
          else
          abort(403, 'Unauthorized action.');
        }
        else
          abort(403, 'Unauthorized action.');


    }
}
