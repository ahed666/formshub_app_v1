<?php

namespace App\Http\Livewire\Forms\Templates;

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
use App\Models\ResponsedCustomersInfo;

use Carbon\Carbon;
use App\Models\Subscribe;
use App\Models\SubscribePlan;
use App\Models\TypeSubscribe;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Notifications\ResponsesWarning;
use App\Notifications\ResponsesZeroWarning;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
class TemplateFormQuestions extends Component
{

    public $form;
    public $account;
    public $logo;
    public $step;
    public $currentkiosk;
    public $formlanguages;
    public $questions;
    public $fullquestions;
    public $current_formid;
    public $current_question;
    public $deviceinfo;
    public $current_question_no=0;
    public $answerchecked=array();
    public $answercheckedcustom=array();
    public $url;
    public $validatedate;
    public $compareonexpiry;
    public $answer=null;
    public $comments;
    public  $current_message;
    // subscriptions settings

    public $current_subscribe;
    public $accountStatus;
    public $valid;
    public $terms;
    public $ControlButtons;
    public $errorMessage;
    public $problem=false;
    public $errorText;

    public $errors_permission='
    {
        "Free":{"num_forms":"You have reached the maximum limit allowed.","num_questions":"You have reached the maximum limit allowed.","num_responses":"You have reached the maximum limit allowed."},
        "Basic":{"num_forms":"You have reached the maximum limit allowed.","num_questions":"You have reached the maximum limit allowed.","num_responses":"You have reached the maximum limit allowed."},
        "Premium":{"num_forms":"You have reached the maximum limit allowed.","num_questions":"You have reached the maximum limit allowed.","num_responses":"You have reached the maximum limit allowed."},
        "Professional":{"num_forms":"You have reached the maximum limit allowed.","num_questions":"You have reached the maximum limit allowed.","num_responses":"You have reached the maximum limit allowed."},
        "Ultimate":{"num_forms":"You have reached the maximum limit allowed.","num_questions":"You have reached the maximum limit allowed.","num_responses":"You have reached the maximum limit allowed."}
    }
    ';

    // end subscriptions
    // public $questions_comments='[
    //     {"type":"yes_no","en":"","ar":"يمكنك الأجابة ب نعم او لا","ur":"","tl":""},
    //     {"type":"rating","en":"","ar":"","ur":"","tl":""},
    //     {"type":"satisfaction","en":"","ar":"","ur":"","tl":""},
    //     {"type":"mcq","en":"","ar":"","ur":"","tl":""},
    //     {"type":"mcq_pic","en":"","ar":"","ur":"","tl":""},
    //     {"type":"checkbox","en":"","ar":"","ur":"","tl":""},
    //     {"type":"checkbox_pic","en":"","ar":"","ur":"","tl":""},
    //     {"type":"custom_rating","en":"","ar":"","ur":"","tl":""},
    //     {"type":"custom_satisfaction","en":"","ar":"","ur":"","tl":""},
    //     {"type":"list","en":"","ar":"","ur":"","tl":""},
    //     {"type":"like_dislike","en":"","ar":"","ur":"","tl":""},
    //     {"type":"Agree_Disagree","en":"","ar":"","ur":"","tl":""},
    //     {"type":"short_text_question","en":"","ar":"","ur":"","tl":""},
    //     {"type":"email","en":"","ar":"","ur":"","tl":""},
    //     {"type":"long_text_question","en":"","ar":"","ur":"","tl":""},
    //     {"type":"date_question","en":"","ar":"","ur":"","tl":""},
    //     {"type":"number","en":"","ar":"","ur":"","tl":""}


    // ]';
    public $questions_comments='[
        {
        "yes_no":{"en":"","ar":"يمكنك الأجابة ب نعم او لا","ur":"","tl":""},
        "rating":{"en":"","ar":"","ur":"","tl":""},
        "satisfaction":{"en":"","ar":"","ur":"","tl":""},
        "mcq":{"en":"","ar":"","ur":"","tl":""},
        "mcq_pic":{"en":"","ar":"","ur":"","tl":""},
        "checkbox":{"en":"","ar":"","ur":"","tl":""},
        "checkbox_pic":{"en":"","ar":"","ur":"","tl":""},
        "custom_rating":{"en":"","ar":"","ur":"","tl":""},
        "custom_satisfaction":{"en":"","ar":"","ur":"","tl":""},
        "list":{"en":"","ar":"","ur":"","tl":""},
        "like_dislike":{"en":"","ar":"","ur":"","tl":""},
        "Agree_Disagree":{"en":"","ar":"","ur":"","tl":""},
        "short_text_question":{"en":"","ar":"","ur":"","tl":""},
        "email":{"en":"","ar":"","ur":"","tl":""},
        "long_text_question":{"en":"","ar":"","ur":"","tl":""},
        "date_question":{"en":"","ar":"","ur":"","tl":""},
        "number":{"en":"","ar":"","ur":"","tl":""}
         }
      ]';
    //  main languages of form
    public $main_lang = '[
        { "id": 1,"code":"en", "name": "English","trans":"en"},
        { "id": 2,"code":"ar" ,"name": "Arabic","trans":"ar"},
        { "id": 3, "code":"ur","name": "Urdu","trans":"ur"},
        { "id": 4, "code":"tl","name": "Tagalog","trans":"fil"}
    ]';
    public $start_buttons='[
        { "id": 1,"code":"en", "text": "Start","flag":"images/flags/gb.svg"},
        { "id": 2,"code":"ar" ,"text": "إبدأ","flag":"images/flags/sa.svg"},
        { "id": 3, "code":"ur","text": "شروع کریں۔","flag":"images/flags/pk.svg"},
        { "id": 4, "code":"tl","text": "simulan","flag":"images/flags/ph.svg"}
    ]';
    public $control_buttons='{
        "en":{"skip":"Skip","next":"Next","back":"Back","score":"Your Score","accept":"Accept & Continue","cancel":"Cancel"},
        "ar":{"skip":"تخطي","next":"التالي","back":"رجوع","score":"درجتك","accept":"قبول ومتابعة","cancel":"إلغاء"},
        "ur":{"skip":"چھوڑ دو","next":"اگلے","back":"پیچھے","score":"آپ کا سکور","accept":"قبول کریں اور جاری رکھیں","cancel":"منسوخ"},
        "tl":{"skip":"Laktawan","next":"Susunod","back":"Pabalik","score":"ang iyong iskor","accept":"Tanggapin at Magpatuloy","cancel":"Kanselahin"}
    }';
    public $buttons;
    public $main_languages;
    public $current_lang;
    public $progressbarvalue;
    // public $inService;
    public $submitedquestions=[];
    public $countanswerchecked=0;


//
    public function getListeners()
    {
            return [
                "echo:refresh.{$this->currentkiosk->device_code_id},DeviceRefresh" => 'refreshpage',
                'updatedanswer' => 'updatedanswer',
                'saveResponse' => 'saveResponse',
                'startform'=>'startform',

            ];
    }
        public function refreshpage($url)
        {

            Redirect::to($url['url']);
            // $this->dispatchBrowserEvent('ReloadPage');
        }

    public function mount()
    {

        // json decode for main languages
        $this->main_languages = json_decode($this->main_lang, true);
        // json decode for start buttons
        $this->buttons = json_decode($this->start_buttons, true);
        $this->ControlButtons= json_decode($this->control_buttons, true);
        // get device info from url

        $this->url=url()->current();

        $this->deviceinfo = explode('/', $this->url);
        $this->comments=json_decode($this->questions_comments, true);
        $this->currentkiosk=Kiosk::wheredevice_code_id($this->deviceinfo[5])->first();
        $this->current_formid=$this->currentkiosk==null?null:$this->currentkiosk->form_id;
        // $this->inService=$this->currentkiosk->in_service;
        if($this->current_formid!=null){
        $this->form=Form::whereid( $this->current_formid)->first();
        $expiry_date = Carbon::parse( $this->form->expiry_date)->format('d-m-Y');
        // $this->validtedate=var_dump($expiry_date->lessThan(Carbon::now()->format('d-m-Y')));
        $formexpiry = Carbon::createFromFormat('d-m-Y',$expiry_date);
        $today = Carbon::createFromFormat('d-m-Y',Carbon::now()->format('d-m-Y'));
        $this->validatedate=$formexpiry->lte($today);

        $this->compareonexpiry=(bool)$this->form->expiry;
        $this->account=Account::whereid($this->form->account_id)->first();
        $this->logo=Logos::whereid($this->form->logo_id)->first();
        $this->formlanguages = $this->getLocalesOfForm( $this->current_formid);
        $this->messages = FormTrnslations::whereform_id(  $this->current_formid)->get();


        $this->step=1;
        // subscribe


        $this->current_subscribe=SubscribePlan::getCurrentSubscription($this->form->account_id);



        $this->accountStatus=SubscribePlan::getCurrentAccountStatus($this->form->account_id);

       $forms=Form::whereaccount_id($this->form->account_id)->get();
        //    $permissions= json_decode($this->plans_permission, true);
       $errors= json_decode($this->errors_permission, true);






    }

        //    check if device in serivce
        // if($this->inService==false){
        //     $this->problem=true;
        //     $this->errorText="Device is out of service";
        //     $this->errorMessage="This device is set as out of service by the admin, please come back later.";
        // }
         // check if there is servey
        if($this->form==null){
            $this->problem=true;
            $this->errorText="No form associated";
            $this->errorMessage="There is no form associated to this device, please come back later.";
        }
        //    check if account is active
        elseif($this->account->active==false){
            $this->problem=true;
            $this->errorText="This account has been suspended.";
            $this->errorMessage="This may be due to overdue payment or a violation of acceptable use terms.";
        }

        // check if servey is active
        elseif($this->form!=null&&$this->form->active==false){
            $this->problem=true;
            $this->errorText="Inactive form";
            $this->errorMessage="The form linked to this device is inactive, please come back later.";
        }

        // check if account have responses
        elseif($this->current_subscribe->num_of_responses<=0){
            $this->problem=true;
            $this->errorText="Out of responses";
            $this->errorMessage="You have reached the maximum responses for your account, visit your web app to manage.";
        }
        // check if account not expiry
        elseif($this->current_subscribe->valid==false ){
            $this->problem=true;
            $this->errorText="Subscription has expired";
            $this->errorMessage="Your account subscription has expired or suspended, visit your web app to manage.";
        }
        // check the num of questions
        elseif(count(Questions::whereform_id($this->current_formid)->whereshow(true)->get())==0){
            $this->problem=true;
            $this->errorText="No question added";
            $this->errorMessage="There are no questions added to this form, visit your web app to manage.";
        }

    }


// get answers for each question and convert it to json
    public function questionsWithAnswers($questions){

        $fullquestions=[];
      foreach($questions as $question)
      {   if($question['show']==1){

           if($question['type']=="number"||$question['type']=="date_question"||$question['type']=="long_text_question"||$question['type']=="email"||$question['type']=="short_text_question")
            {
                $answers=null;
            }
            elseif($question['type']=='mcq_pic'||$question['type']=='checkbox_pic')
                {
                $answers=Answers::join('answer_translations','answers.id','=','answer_translations.answer_id')->
                join('pictures','pictures.id','=','answers.picture_id')->where('answers.question_id','=',$question['id'])->
                where('answers.hide','=',false)->where('answer_translations.answer_local','=',$this->current_lang)->select('answers.*','answer_translations.answer_details as answer_details','pictures.pic_url as picture')->get();

                }
            else{
                    $answers=Answers::join('answer_translations','answers.id','=','answer_translations.answer_id')->
                    where('answers.question_id','=',$question['id'])->where('answers.hide','=',false)
                    ->where('answer_translations.answer_local','=',$this->current_lang)->select('answers.*','answer_translations.answer_details as answer_details')->get();

                }
            $collect=collect(
                ["question_id"=>$question['id'],
                    "question_details"=>$question['details'],
                    "type_id"=>$question['type_of_question_id'],
                    "type"=>$question['type'],
                    "order"=>$question['question_order'],
                    "optional"=>$question['optional'],
                    "question_image"=>$question['question_image'],
                    "answers"=>$answers,
                ]
            );
            array_push($fullquestions,$collect);
          }}
       //    }
       return $fullquestions;
    }

    //    to get all questions by id of form
    public function getquestions($id)
    {

        //  custom questions


        //   another type of question
        $questions2 = Questions::join('question_translations', 'questions.id', '=', 'question_translations.question_id')->
            join('type_of_questions', 'type_of_questions.id', '=', 'questions.type_of_question_id')->
            leftjoin('pictures','questions.picture_id','=','pictures.id')->
            // ->join('answer_translations','answer_translations.answer_id','=','answers.id')->
            // where('answer_translations.answer_local', '=', $this->current_lang)->
            // whereNotIn('questions.type_of_question_id', [8, 9])->
            where('questions.form_id', '=', $id)->where('question_translations.question_local', '=', $this->current_lang)->

            select('questions.*', 'question_translations.question_details As details', 'question_translations.question_local As local',
             'type_of_questions.question_type as type','pictures.pic_url as question_image')->

            orderby('questions.question_order')->get();

        // $questions = array_merge(json_decode($questions1, true), json_decode($questions2, true));
        $questions = json_decode($questions2, true);

        usort($questions, function ($a, $b) {
            return $a['question_order'] - $b['question_order'];
        });

        return $questions;

    }

    // start form after detect language
    public function startform($langCode)
    {
        try
        {
            $this->current_formid=Kiosk::wheredevice_code_id($this->deviceinfo[5])->first()->form_id;
            $this->current_lang=$langCode;
            $this->questions=$this->getquestions( $this->current_formid);
            $this->fullquestions=$this->questionsWithAnswers($this->questions);

            $this->ControlButtons= json_decode($this->control_buttons, true);
            $this->current_subscribe=SubscribePlan::getCurrentSubscription($this->form->account_id);


            $form_trans=FormTrnslations::whereform_id( $this->current_formid)->whereform_local($this->current_lang)->first();

            if($this->form->terms&&$this->current_subscribe->form_terms)
            {
                $this->step=2;

                $this->terms=FormTrnslations::whereform_id(  $this->current_formid)->whereform_local($this->current_lang)->first()->terms;
            }
            else
            $this->step=3;

            $this->current_message=FormTrnslations::whereform_id($this->current_formid)->whereform_local($this->current_lang)->first();

            $this->dispatchBrowserEvent('startform',['questions'=>$this->fullquestions,'ControlButtons'=>$this->ControlButtons,'score'=>(bool)$this->form->score,'step'=>$this->step,'lang'=>$this->current_lang,'current_message'=>$this->current_message,'comments'=>$this->comments[0]]);
        }
        catch (\Throwable $th)
        {
            $this->emit('ReloadPage');
        }

    }
    // get locales of form
    public function getLocalesOfForm($id)
    {
        $locales = FormTrnslations::
            where('form_id', '=', $id)->
            select('form_translations.form_local As local')->get();

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
    public function saveImageDrawing($dataUrl,$response_id,$question_id){
        list($type, $data) = explode(';', $dataUrl);
        list(, $data)      = explode(',', $data);
        $imageData = base64_decode($data);
        $folderPath = public_path('storage/images/drawing/');
        if (!file_exists($folderPath)) {
            mkdir($folderPath, 0777, true);
        }
        // Define the path to save the image

        $imageName = 'drawing_response'.$response_id.'_question'.$question_id.'.png'; // Name of the new image file
        $fileName = $folderPath .$imageName;
        // Save the image to the specified path
        file_put_contents($fileName, $imageData);
             return 'storage/images/drawing/'.$imageName;
    }
    // save response
    public function saveResponse($response_items,$score)
    {


        $numOfAnsweredQuestions=[];
        $response=new Responses();
        $response->form_id=$this->current_formid;

        $response->response_source=$this->currentkiosk?$this->currentkiosk->device_code_id:"share";
        $response->score=$score;
        $user=User::join('accounts','accounts.user_id','=','users.id')->join('forms','forms.account_id','=','accounts.id')->where('forms.id','=',$this->current_formid)->first();
        //$user->timezone
         $response->reviewed_at=Carbon::now();
        $response->response_language=$this->current_lang;

        $response->save();

        $this->current_subscribe->num_of_responses-=1;
        // $user = User::find($user->id);

        $this->current_subscribe->save();
        // start save each response item

        foreach ($response_items as $key => $item)
        {
            //  if type of question is text =>save it in question customer info table
            if($item['type']=="number"||$item['type']=="date_question"||$item['type']=="email"||$item['type']=="short_text_question"||$item['type']=="long_text_question")
            {
                try {
                    $question=new ResponsedCustomersInfo();
                    $question->question_id=$item['question_id'];
                    if( count($item['answerchecked'])>0)
                    $question->answer=$item['answerchecked'][0];
                    else
                    {
                        $item['skipbyuser']==true?$question->type_skip="user":"";
                        $item['skipbyanswer']==true?$question->type_skip="answer":"";
                    }
                    $question->response_id=$response->id;
                    $question->save();
                } catch (\Throwable $th) {
                    //throw $th;
                }

            }
            elseif($item['type']=="drawing"){

                try {
                    $question=new ResponsedCustomersInfo();
                    $question->question_id=$item['question_id'];

                    if(count($item['answerchecked'])>0)
                    {
                        $question->answer=$this->saveImageDrawing($item['answerchecked'][0],$response->id,$item['question_id']);

                    }
                    else
                    {
                        $item['skipbyuser']==true?$question->type_skip="user":"";
                        $item['skipbyanswer']==true?$question->type_skip="answer":"";
                    }
                    $question->response_id=$response->id;
                    $question->save();

                } catch (\Throwable $th) {
                    //throw $th;
                }
            }
            else//another type of question
            {
            /* if($item['type']=="custom_rating"||$item['type']=="custom_satisfaction")
                {
                    foreach($item['childs'] as $key => $child ){
                    if($child['answerchecked']!=null)//child question answered
                    {
                            $question=new ResponsedQuestions();
                            $question->question_id=$child['question_id'];
                            $question->answer_id=$child['answerchecked']['answer'];
                            $question->response_id=$response->id;
                            $question->save();
                    }
                    else// child question not answered
                    {
                            $question=new ResponsedQuestions();
                            $question->question_id=$child['question_id'];
                            $question->response_id=$response->id;
                            $question->type_skip="not answered";
                            $question->save();
                    }
                    }

                }
                else
                {*/
                    // if question is not skipped
                    if( count($item['answerchecked'])>0){
                        foreach ($item['answerchecked'] as $key => $value) {
                            $question=new ResponsedQuestions();
                            $question->question_id=$item['question_id'];
                            $question->answer_id=$value['answer_id'];
                            $question->response_id=$response->id;
                            $question->save();
                        }

                    }
                    else
                    {
                        $question=new ResponsedQuestions();
                        $question->question_id=$item['question_id'];
                        $item['skipbyuser']==true?$question->type_skip="user":"";
                        $item['skipbyanswer']==true?$question->type_skip="answer":"";
                        $question->response_id=$response->id;
                        $question->save();


                    }
                // }


            }
            // check if questions answere or not
            if( $item['skipbyanswer']==false&&$item['skipbyuser']==false&&count($item['answerchecked'])>0){

                if(!in_array($item['question_id'],$numOfAnsweredQuestions))
                $numOfAnsweredQuestions[] = $item['question_id'];
            }
        }

        // calcualte and save the complet percent of questions
        $response->complet_percent=round((count($numOfAnsweredQuestions)*100)/count($this->questions),1);

        $response->save();
        try {


        // check on num of responses
        if($this->current_subscribe->num_of_responses==100&&$user->email_sub_payment_subscriptions)
        {

             $user->notify(new ResponsesWarning($user));

        }
        elseif($this->current_subscribe->num_of_responses==0&&$user->email_sub_payment_subscriptions){
            $user->notify(new ResponsesZeroWarning($user));
        }
        } catch (\Throwable $th) {
            //throw $th;
        }
        $this->dispatchBrowserEvent('submitted');
    }
    public function render()
    {
        return view('livewire.forms.templates.template-form-questions');
    }
}
