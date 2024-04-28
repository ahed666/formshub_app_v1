<?php

namespace App\Http\Livewire\Forms\Edit;

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
use App\Models\FormTrnslations;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use App\Events\DeviceRefresh;
use App\Models\Subscribe;
use App\Models\SubscribePlan;
use App\Models\TypeSubscribe;
use Carbon\Carbon;
use App\Jobs\RefreshKiosks;
// google translate api
use Stichoza\GoogleTranslate\GoogleTranslate;
class EditFormQuestions extends Component
{
    public $current_form_id;
    public $question_delete_id;
    public $language_delete_id;
    public $terms_form_delete_id;
    public $current_form;
    public $languages;
    public $current_form_kiosks;
    //    to set the id of form that want user delete it
    public $form_delete_id;
    // add form details
    public $form_logo;
    public $logosrc;
    public $logo;
    public $form_BusinessName;
    public $form_Name;
    public $modal = false;
    // end add form details
    public $formlanguages;
    public $main_languages;
    //    edit question
    public $questionediting;
    public $current_questions;
    public $modalopen = false;

    public $local = "en";
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
    public $messages_defult =
        '[
        {"local":"en","start_header":"Hi there, your opinion matters!",
            "start_text":"Please select the language to begin",
            "end_header":"Thank you for your time","end_text":"We are glad to hear from you, Have a great day!",
            "terms":"Insert your terms and conditions here."},
       {"local":"ar",
        "start_header":"مرحبا بك، رأيك يهمنا!",
        "start_text":"الرجاء إختيار اللغة للبدء",
        "end_header":"شكراً على وقتك","end_text":"!يسعدنا دائما السماع منك, يوما سعيداً",
        "terms":"َضع الشروط والأحكام الخاصة بك هنا."},
       {"local":"tl","start_header":"Kumusta, ang iyong opinyon ay mahalaga!",
        "start_text":"Mangyaring piliin ang wika upang magsimula",
        "end_header":"Salamat sa iyong oras","end_text":"Natutuwa kaming makarinig mula sa iyo, Magkaroon ng magandang araw!",
        "terms":"Ipasok ang iyong mga tuntunin at kundisyon dito."},
       {"local":"ur","start_header":"!ہیلو، آپ کی رائے اہم ہے",
        "start_text":"براہ کرم شروع کرنے کے لیے زبان منتخب کریں۔",
        "end_header":"اپ کے وقت کا شکریہ","end_text":"!ہمیں آپ سے سن کر خوشی ہوئی، آپ کا دن اچھا گزرے",
        "terms":"اپنی شرائط و ضوابط یہاں داخل کریں۔"}
       ]';
    public $messages;
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
        // to update form every second
        'updatecurrentform' => 'update_formkiosks',
         //select form
         'selectform'=>'selectform',
        // to delete question
        'deleteQuestionConfirmed' => 'deletequestion',
        // to delete terms
        'deleteTermsConfirmed' => 'deleteterms',
        // to delete language
        'deleteLanguageConfirmed' => 'deletelang',
        //  to refresh after edit message
        'messageeditsuccess' => 'messageeditsuccess',
        //  to refresh after edit terms
        'termseditsuccess' => 'termseditsuccess',
        //    to refresh after edit form
        'formeditsuccess' => 'formeditsuccess',

        //  to refresh after edit question
        'questioneditsuccess' => 'questioneditsuccess',
        //  to refresh after add question
        'questionaddsuccess' => 'questionaddsuccess',
        'updateKiosks'=>'updateformonkiosks',

        'hidetranslationalert'=>'hideTranslationAlert'


    ];
    // set alert translation notifiaction to false
    public function hideTranslationAlert(){

            $form=Form::findOrFail($this->current_form_id);
            $form->trans_notification=false;$form->save();

        $this->update_currentform();
    }
    // update form on kiosks:
    public function update_formkiosks(){
                RefreshKiosks::dispatch($this->current_form_kiosks->toArray());

    }
     // after edit form
     public function formeditsuccess($id)
     {





         $this->dispatchBrowserEvent('close_modal_add_form');
        //  $this->mount();

     }

//   if message edit success
    public function messageeditsuccess($id)
    {

        $this->current_questions = $this->getquestions($id);

        $this->current_form = Form::join('logos', 'logos.id', '=', 'forms.logo_id')
            ->where('forms.account_id', Auth::user()->current_account_id)->where('forms.id', $this->current_form_id)->select('forms.id as form_id', 'forms.*', 'logos.logo_url')->first();
        if ($this->current_form != null) {
            $this->current_form_id = $this->current_form->form_id;
        } else {
            $this->current_form = Form::where('forms.account_id', Auth::user()->current_account_id)->where('forms.id', $this->current_form_id)->first();
            $this->current_form_id = $this->current_form->id;
        }
        $this->current_form_kiosks = Kiosk::whereform_id($this->current_form_id)->get();
        $this->dispatchBrowserEvent('contentChanged');

    }
    //   if message edit success
    public function termseditsuccess($id)
    {


        $this->dispatchBrowserEvent('close_modal_edit_terms');
        // $this->mount();

    }

    //   if question edit success
    public function questioneditsuccess($id)
    {

        $this->current_questions = $this->getquestions($id);
        $this->current_form = Form::join('logos', 'logos.id', '=', 'forms.logo_id')
            ->where('forms.account_id', Auth::user()->current_account_id)->where('forms.id', $this->current_form_id)->select('forms.id as form_id', 'forms.*', 'logos.logo_url')->first();
        if ($this->current_form != null) {
            $this->current_form_id = $this->current_form->form_id;
        } else {
            $this->current_form = Form::where('forms.account_id', Auth::user()->current_account_id)->where('forms.id', $this->current_form_id)->first();
            $this->current_form_id = $this->current_form->id;
        }
        $this->current_form_kiosks = Kiosk::whereform_id($this->current_form_id)->get();

        $this->dispatchBrowserEvent('close_modal_edit_question');


    }
    //   if question add success
    public function questionaddsuccess($id)
    {

        $this->current_questions = $this->getquestions($id);
        $this->current_form = Form::join('logos', 'logos.id', '=', 'forms.logo_id')
            ->where('forms.account_id', Auth::user()->current_account_id)->where('forms.id', $this->current_form_id)->select('forms.id as form_id', 'forms.*', 'logos.logo_url')->first();
        if ($this->current_form != null) {
            $this->current_form_id = $this->current_form->form_id;
        } else {
            $this->current_form = Form::where('forms.account_id', Auth::user()->current_account_id)->where('forms.id', $this->current_form_id)->first();
            $this->current_form_id = $this->current_form->id;
        }


        $this->dispatchBrowserEvent('close_modal_add_question');


    }


    // updateing form on all kiosks
    public function updateformonkiosks()
    {


        RefreshKiosks::dispatch($this->current_form_kiosks->toArray());
        $form=Form::whereid($this->current_form->id)->first();
        $form->updating=false;
        $form->save();
        $this->update_currentform();

    }
    // set show or not of question
    public function setQuestionShow($value,$id)
    {   $question=Questions::whereid($id)->first();

        $value==1?$question->show=false:$question->show=true;
        $question->save();
        $this->update_currentform();
        $this->dispatchBrowserEvent('contentChanged');


    }
    // update current form after change
    public function update_currentform()
    {
        $this->current_form=Form::join('logos', 'logos.id', '=', 'forms.logo_id')->where('forms.account_id', Auth::user()->current_account_id)->where('forms.id', $this->current_form_id)->select('forms.id as form_id', 'forms.*', 'logos.logo_url')->first();

        if ($this->current_form != null) {$this->current_form_id = $this->current_form->form_id;
            $this->service = (bool) $this->current_form->active;
            $this->score = (bool) $this->current_form->score;
            $this->formexpiry = (bool) $this->current_form->expiry;
            $this->formexpirydate = $this->current_form->expiry_date;}
                else {
            $this->current_form = Form::where('forms.account_id', Auth::user()->current_account_id)->where('forms.id', $this->current_form_id)->get()->first();
            $this->current_form_id = $this->current_form->id;
            $this->service = (bool) $this->current_form->active;
            $this->score = (bool) $this->current_form->score;
            $this->terms = (bool) $this->current_form->terms;
            $this->formexpiry = (bool) $this->current_form->expiry;
            $this->formexpirydate = $this->current_form->expiry_date;
        }
        $this->forms = Form::whereaccount_id(Auth::user()->current_account_id)->get();
        $this->main_languages = json_decode($this->main_lang, true);
        $this->messages = json_decode($this->messages_defult, true);

        $this->current_form_kiosks=Kiosk::leftjoin('device_codes','device_codes.id','=','devices.device_code_id')
        ->where('devices.form_id',$this->current_form_id)
        ->select('devices.*','device_codes.device_code as device_code')->get();

        $this->formlanguages = $this->getLocalesOfForm($this->current_form_id);
        $this->current_message = FormTrnslations::whereform_id($this->current_form_id)->whereform_local($this->local)->first();
        $this->current_questions = $this->getquestions($this->current_form_id);
        $this->current_subscribe=SubscribePlan::getCurrentSubscription(Auth::user()->current_account_id);

        $this->accountStatus=SubscribePlan::getCurrentAccountStatus(Auth::user()->current_account_id);


        $this->dispatchBrowserEvent('RebuildCarousel');


    }

    // service
    public function updatedservice()
    {

        $form = Form::whereid($this->current_form_id)->first();
        $form->active = $this->service;
        $form->save();
        //  to enable updating of form on each change or action
        $form=Form::whereid($this->current_form_id)->first();
        $form->updating=true;$form->save();
        $this->update_currentform();
        $this->dispatchBrowserEvent('contentChanged');
    }
    // terms
    public function updatedterms()
    {
        $this->current_subscribe=SubscribePlan::getCurrentSubscription(Auth::user()->current_account_id);


        if($this->current_subscribe->form_terms!==false){
        $form = Form::whereid($this->current_form_id)->first();
        $form->terms = $this->terms;
        $form->save();
        //  to enable updating of form on each change or action
        $form=Form::whereid($this->current_form_id)->first();
        $form->updating=true;$form->save();
        $this->update_currentform();
        $this->dispatchBrowserEvent('contentChanged');
        }
        else{
            $this->update_currentform();
            $this->dispatchBrowserEvent('notAllowed');

        }

    }
        // score
    public function updatedscore()
    {
        $form = Form::whereid($this->current_form_id)->first();
        $form->score = $this->score;
        $form->save();
        //  to enable updating of form on each change or action
        $form=Form::whereid($this->current_form_id)->first();
        $form->updating=true;$form->save();
        $this->update_currentform();
        $this->dispatchBrowserEvent('contentChanged');



    }
    // expiry
    public function updatedformexpiry()
    {
        $form = Form::whereid($this->current_form_id)->first();
        $form->expiry = $this->formexpiry;
        $form->save();
        //  to enable updating of form on each change or action
        $form=Form::whereid($this->current_form_id)->first();
        $form->updating=true;$form->save();
        $this->update_currentform();
        $this->dispatchBrowserEvent('contentChanged');



    }
    // expiry date
    public function updatedformexpirydate()
    {

        $form = Form::whereid($this->current_form_id)->first();
        $form->expiry_date = $this->formexpirydate;
        $form->save();
        //  to enable updating of form on each change or action
        $form=Form::whereid($this->current_form_id)->first();
        $form->updating=true;$form->save();
        $this->update_currentform();
        $this->dispatchBrowserEvent('contentChanged');


    }
     // **  edit web option of form
        //  select the question to edit it
    public function selecteditquestion($id)
    {

        $this->questionediting = Questions::whereid($id)->first();

        // $this->emitTo('edit',$this->questionediting,$this->local,$this->formlanguages,true);

        $this->dispatchBrowserEvent('contentChanged');
        return $this->questionediting;

    }
    //    to check if this language in languages of form or not
    public function formlang($id)
    {
        foreach ($this->formlanguages as $lang) {if ($lang['id'] == $id) {
            return true;
        }

        }
        return false;
    }
    //  to delete language
    public function deletelang()
    {

        foreach ($this->formlanguages as $key => $lang) {
            if ($lang['id'] == $this->language_delete_id) {unset($this->formlanguages[$key]);
                FormTrnslations::whereform_id($this->current_form_id)->whereform_local($lang['code'])->delete();
                foreach ($this->getquestions($this->current_form_id) as $question) {

                        $answers = Answers::wherequestion_id($question['id'])->get();

                         // if the languages count =0(no langauges) delete images of answers else then no delete images
                        if(count($this->formlanguages)==0)
                        {

                            foreach ($answers as $answer)
                            {
                                if ($answer->picture_id != null)
                                {
                                    $imagepath = Pictures::whereid($answer->picture_id)->first()->pic_url;
                                    if (str_contains($imagepath, 'storage/images/temp/') || str_contains($imagepath, 'storage/images/drawing/')|| str_contains($imagepath, 'storage/images/upload/')) {File::delete(public_path($imagepath));}
                                    Pictures::whereid($answer['picture_id'])->delete();
                                }
                            }
                            if($question['type_of_question_id']==19||$question['type_of_question_id']==20)
                            {
                                $imagepath = Pictures::whereid($question['picture_id'])->first()->pic_url;
                                if (str_contains($imagepath, 'storage/images/temp/') || str_contains($imagepath, 'storage/images/upload/'))
                                {File::delete(public_path($imagepath));}
                                Pictures::whereid($question['picture_id'])->delete();
                            }

                        }
                        foreach ($answers as $answer)
                        {
                            AnswersTranslation::whereanswer_id($answer->id)->whereanswer_local($lang['code'])->delete();
                        }

                        QuestionTranslation::wherequestion_id($question['id'])->wherequestion_local($lang['code'])->delete();



                    // }
                }

            }

        }

        $local = reset($this->formlanguages);
        $this->changelocal($local['id']);
        //  to enable updating of form on each change or action
        $form=Form::whereid($this->current_form_id)->first();
        $form->updating=true;$form->save();

        $this->dispatchBrowserEvent('languagesChanged');
        $this->dispatchBrowserEvent('contentChanged');

    }

    // add lnaguage to form
    public function addlang($code)
    {

        if(count(FormTrnslations::whereform_id($this->current_form_id)->get())==4)
           {
            $this->update_currentform();
            $this->dispatchBrowserEvent('languagesChanged');
            return;
           }
        if(FormTrnslations::whereform_id($this->current_form_id)->whereform_local($code)->first())
          {
            $this->update_currentform();
            $this->dispatchBrowserEvent('languagesChanged');
            return;
         }
        foreach ($this->main_languages as $lang)
        {
            if ($lang['code'] == $code) {
                $lan = $lang;
                break;
            }
        }

        $this->local = $lan['code'];

        // add defult messages
        $form_trans = new FormTrnslations();
        foreach ($this->messages as $message)
        {
            if ($message['local'] == $this->local) {
                $form_trans->form_start_header = $message['start_header'];
                $form_trans->form_start_text = $message['start_text'];
                $form_trans->form_end_header = $message['end_header'];
                $form_trans->form_end_text = $message['end_text'];
                $form_trans->terms = $message['terms'];
                $form_trans->form_id = $this->current_form_id;
                $form_trans->form_local = $this->local;
                $form_trans->save();
                break;

            }

        }
        //  end of add defult messages

        //  add question and answers
        // ***
        //  detect the source of trnslation
        $source = "";
        $destination = "";
        foreach ($this->formlanguages as $lang)
        {if ($lang['code'] == $this->local) {
                $destination = $lang['trans'];
            } else { $source = $lang['trans'];
                $source_code = $lang['code'];
        }

        }

        foreach ($this->current_questions as $question) {
           $type= QuestionType::whereid($question['type_of_question_id'])->first()->question_type;

                $question_trans =$question['details'];
                DB::insert('insert into question_translations (question_details, question_local,question_id) values (?, ?,?)', [$question_trans, $this->local, $question['id']]);
                $answers = Answers::where('question_id', '=', $question['id'])->get();

                if($type=="yes_no"||$type=="like_dislike"||$type=="Agree_Disagree")
                {
                    $answers_text=json_decode($this->answers_json_text, true);

                    $textofanswers="";
                    foreach($answers_text as $i=>$answer_text)
                    $answer_text['type']==$type?$textofanswers=$answer_text:"";
                    $text=$textofanswers[$this->local];

                    foreach ($answers as $i=> $answer) {
                    $answer_details=$text[$i];
                    DB::insert('insert into answer_translations (answer_details, answer_local,answer_id) values (?, ?,?)', [$answer_details, $this->local, $answer->id]);
                    }
                }
                elseif($type=="rating"){
                    $answers_text=json_decode($this->answers_json_text_rating, true);
                    foreach ($answers as $i=> $answer) {
                         DB::insert('insert into answer_translations (answer_details, answer_local,answer_id) values (?, ?,?)', [$answers_text[$i], $this->local, $answer->id]);
                    }

                }
                elseif($type=="satisfaction"){
                    $answers_text=json_decode($this->answers_json_text_satisfaction, true);
                    $text=$answers_text[$this->local];
                    foreach ($answers as $i=> $answer) {
                        DB::insert('insert into answer_translations (answer_details, answer_local,answer_id) values (?, ?,?)', [$text[$i], $this->local, $answer->id]);
                   }
                }
                else
                {


                foreach ($answers as $answer) {
                    $answer_trans = AnswersTranslation::whereanswer_id($answer->id)->whereanswer_local($source_code)->first();
                    if($answer_trans!=null){
                //    try {
                //     $tr = new GoogleTranslate();
                //     $answer_details = $tr->setSource($source)->setTarget($destination)->translate($answer_trans->answer_details);

                //    } catch (\Throwable $th) {

                //     $answer_details=$answer_trans->answer_details;
                //    }
                   $answer_details=$answer_trans->answer_details;

                    DB::insert('insert into answer_translations (answer_details, answer_local,answer_id) values (?, ?,?)', [$answer_details, $this->local, $answer->id]);
                }}
                }
            }

        // }
        // ***
        // end of add question and it answers

        // if there is more than one lang and form have question then set translation notification for this form as true to show translation notification
        if(count(FormTrnslations::whereform_id($this->current_form_id)->get())>1&&count($this->current_questions)>0)
        {
            $form=Form::findOrFail($this->current_form_id);
            $form->trans_notification=true;$form->save();
        }
        $this->update_currentform();
        $this->dispatchBrowserEvent('languagesChanged');
        $this->dispatchBrowserEvent('contentChanged');


    }

    //  to change local of show survformey when click on tab
    public function changelocal($local_id)
    {

        foreach ($this->formlanguages as $lang) {
            if ($lang['id'] == $local_id) {
                $local = $lang['code'];
            }
        }

        $this->local = $local;

        $this->update_currentform();
        $this->dispatchBrowserEvent('languagesChanged');


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
    //    to get all questions by id of form
    public function getquestions($id)
    {


        //   another type of question
        $questions1 = Questions::join('question_translations', 'questions.id', '=', 'question_translations.question_id')->
            join('type_of_questions', 'type_of_questions.id', '=', 'questions.type_of_question_id')->
            select('questions.*', 'question_translations.question_details As details', 'question_translations.question_local As local', 'type_of_questions.question_type_details as type')->
            where('questions.form_id', '=', $id)->where('question_translations.question_local', '=', $this->local)->orderby('questions.question_order')->get();
        // $questions = array_merge(json_decode($questions1, true), json_decode($questions2, true));

        $questions=json_decode($questions1, true);
        usort($questions, function ($a, $b) {
            return $a['question_order'] - $b['question_order'];
        });

        return $questions;

    }

    //   to update when user re order the questions list
    public function updateQuestionOrder($questions)
    {

        foreach ($questions as $question) {
            // foreach($this->current_questions as $i=>$curr_ques){
            //     if($curr_ques['id']==$question['value'])
            //     $this->current_questions[$i]['question_order']=$question['order'];
            // }
            $ques = Questions::find($question['value']);
            // if ($ques->type_of_question_id == 8 || $ques->type_of_question_id == 9) {
            //     $parentid = Questions::join('custom_questions', 'Questions.id', '=', 'custom_questions.question_id')->
            //         where('Questions.id', '=', $ques->id)->select('custom_questions.*')->first();
            //     //  $parentid->custom_question_id
            //     $custom_questions = Questions::join('custom_questions', 'Questions.id', '=', 'custom_questions.question_id')->
            //         where('custom_questions.custom_question_id', '=', $parentid->custom_question_id)->where('custom_questions.question_id', '!=', $parentid->question_id)->select('custom_questions.*')->get();

            //     foreach ($custom_questions as $custom_question)
            //     {
            //         $custom_ques = Questions::find($custom_question->question_id);
            //         $custom_ques->question_order = $question['order'];
            //         $custom_ques->update();
            //     }

            //     $ques->question_order = $question['order'];
            //     $ques->update();
            // }
            // else {
                $ques->question_order = $question['order'];
                $ques->update();
            // }

        }


        $this->update_currentform();
        $this->dispatchBrowserEvent('contentChanged');

    }




    public function mount($id,$lastLocal)
    {

        // $url=url()->current();
        // $forminfo = explode('/', $url);
        $this->current_form_id=$id;

        // subscirbe info and settings
        $this->current_subscribe=SubscribePlan::getCurrentSubscription(Auth::user()->current_account_id);

        $this->accountStatus=SubscribePlan::getCurrentAccountStatus(Auth::user()->current_account_id);

        //end of subscribe info

        $this->current_form = Form::leftJoin('logos', 'logos.id', '=', 'forms.logo_id')
        ->where('forms.id','=',$this->current_form_id)->select('forms.id as form_id', 'forms.*', 'logos.logo_url')->first();


        if ($this->current_form != null) {$this->current_form_id = $this->current_form->form_id;
            $this->service = (bool) $this->current_form->active;
            $this->score = (bool) $this->current_form->score;
            $this->terms = (bool) $this->current_form->terms;
            $this->formexpiry = (bool) $this->current_form->expiry;
            $this->formexpirydate = $this->current_form->expiry_date;
        }




        $this->main_languages = json_decode($this->main_lang, true);
        $this->current_form_kiosks=Kiosk::leftjoin('device_codes','device_codes.id','=','devices.device_code_id')
        ->where('devices.form_id',$this->current_form_id)
        ->select('devices.*','device_codes.device_code as device_code')->get();

        $this->messages = json_decode($this->messages_defult, true);

        $this->formlanguages = $this->getLocalesOfForm($this->current_form_id);
        if($lastLocal!=null)
        {$this->local=$lastLocal;}

        elseif ($this->formlanguages != null) {
            $this->local = $this->formlanguages[0]['code'];
        }

        $this->current_message = FormTrnslations::whereform_id($this->current_form_id)->whereform_local($this->local)->first();

        $this->current_questions = $this->getquestions($this->current_form_id);


        //    $this->form_logo="images/logo_1_transparent_dark.png";
        //    $this->logo="images/logo_1_transparent_dark.png";
        //    $this->modal=false;

        // $this->questionediting=new Questions();


    }
    public function updatedlogo()
    {
        $this->modal = true;
        $this->logosrc = $this->logo->temporaryUrl();
        $this->dispatchBrowserEvent('form-image-updated', ['image' => $this->logo]);

    }
    // save image after crop it
    public function cropingimage()
    {
        $this->dispatchBrowserEvent('saving');

    }
    // to close the crop modal if user click close button or icon
    public function closemodal()
    {
        $this->form_logo = "images/logo_1_transparent_dark.png";
        $this->modal = false;
    }

    // t oclose crop modal if user click save
    public function closemodalwithsave()
    {

        $this->modal = false;
    }
    // save image after crop it
    public function SavImage($image)
    {
        $folderPath = public_path('storage/images/temp/');
        if (!file_exists($folderPath)) {
            mkdir($folderPath, 0777, true);
        }
        $image_parts = explode(";base64,", $image);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);

        $name = uniqid() . '.jpg';
        $file = $folderPath . $name;
        $this->modal = false;

        if (str_contains($this->form_logo, '/storage/images/temp/') || str_contains($this->form_logo, '/storage/images/upload/')) {
            File::delete(public_path($this->form_logo));}
        $this->form_logo = "/storage/images/temp/" . $name;
        file_put_contents($file, $image_base64);

    }
    //    select form
    public function selectform($id)
    {
        $this->current_form_id = $id;
        $this->current_questions = [];
        $this->current_form = null;
        $this->formlanguages = $this->getLocalesOfForm($this->current_form_id);
        $this->local = $this->formlanguages[0]['code'];
        $this->current_message = FormTrnslations::whereform_id($this->current_form_id)->whereform_local($this->local)->first();
        $this->current_questions = $this->getquestions($this->current_form_id);

        $this->current_form = Form::join('logos', 'logos.id', '=', 'forms.logo_id')
            ->where('forms.account_id', Auth::user()->current_account_id)->where('forms.id', $this->current_form_id)->select('forms.id as form_id', 'forms.*', 'logos.logo_url')->first();
        if ($this->current_form != null) {$this->current_form_id = $this->current_form->form_id;
            $this->service = (bool) $this->current_form->active;
            $this->score = (bool) $this->current_form->score;
            $this->terms = (bool) $this->current_form->terms;
            $this->formexpiry = (bool) $this->current_form->expiry;
            $this->formexpirydate = $this->current_form->expiry_date;
        } else {
            $this->current_form = Form::where('forms.account_id', Auth::user()->current_account_id)->where('forms.id', $this->current_form_id)->get()->first();
            $this->current_form_id = $this->current_form->id;
            $this->service = (bool) $this->current_form->active;
            $this->score = (bool) $this->current_form->score;
            $this->terms = (bool) $this->current_form->terms;
            $this->formexpiry = (bool) $this->current_form->expiry;
            $this->formexpirydate = $this->current_form->expiry_date;
        }
        // $this->current_form=Form::whereuser_id(Auth::user()->id)->whereid($this->current_form_id)->first();
        $this->current_form_kiosks = Kiosk::whereform_id($this->current_form_id)->get();

        $this->dispatchBrowserEvent('contentChanged');

    }



    //   delete question confirmation
    public function deletequestionConfirmation($id)
    {
        $this->question_delete_id = $id;
        $this->dispatchBrowserEvent('show-question-delete-confirmation');
        //    to re select the current form
        $this->update_currentform();
    }
    //   delete terms confirmation by form id
    public function deletetermsConfirmation($id)
    {
        $this->terms_form_delete_id = $id;

        $this->dispatchBrowserEvent('show-terms-delete-confirmation');
        //    to re select the current form
        $this->update_currentform();
    }
    // end of  delete question confirmation
    //   *****************
    //   delete language confirmation
    public function deletelanguageConfirmation($id)
    {
        $this->language_delete_id = $id;
        $this->dispatchBrowserEvent('show-language-delete-confirmation');
        //    to re select the current form
        $this->update_currentform();
    }
    //  end of delete language confirmation
    public function questions_count($id)
    {
        $count1 = questions::where('form_id', '=', $id)->whereNotIn('type_of_question_id', [8, 9])->get();
        // $count2 = DB::table('questions')
        //     ->join('custom_questions', 'questions.id', '=', 'custom_questions.question_id')
        //     ->where('questions.form_id', '=', $id)
        //     ->groupBy('custom_questions.custom_question_id')
        //     ->select('questions.*')
        //     ->get();
        //  + count($count2)
        $count = count($count1);

        return $count;
    }

    // function to delete question
    //         use App\Models\Questions;
    // use App\Models\QuestionTranslation;
    // use App\Models\Form;
    // use App\Models\Answers;
    // use App\Models\Logos;
    // use App\Models\FormTrnslations;
    // use App\Models\AnswersTranslation;
    public function deletequestion()
    {
        $question = Questions::whereid($this->question_delete_id)->first();

            // delete question
            //delete question translation
            //delete answers
            //delte answers translation
            $answers = Answers::wherequestion_id($this->question_delete_id)->get();
            foreach ($answers as $answer) {
                if ($answer->picture_id != null) {
                    $imagepath = Pictures::whereid($answer->picture_id)->first()->pic_url;
                    if (str_contains($imagepath, 'storage/images/temp/') || str_contains($imagepath, 'storage/images/upload/')||str_contains($imagepath, 'storage/images/drawing/'))
                    {File::delete(public_path($imagepath));}
                    Pictures::whereid($answer['picture_id'])->delete();
                }
                AnswersTranslation::whereanswer_id($answer->id)->delete();
                Answers::whereid($answer->id)->delete();

            }
            QuestionTranslation::wherequestion_id($this->question_delete_id)->delete();
            Questions::whereid($this->question_delete_id)->delete();
        // }

        $this->current_questions = $this->getquestions($this->current_form_id);
        // re order the questions
        foreach ($this->current_questions as $ques) {
            $q = Questions::whereid($ques['id'])->first();
            if ($q->question_order > $question->question_order) {
                $q->question_order -= 1;
            }

            $q->save();
        }
        $this->current_form = Form::join('logos', 'logos.id', '=', 'forms.logo_id')
            ->where('forms.account_id', Auth::user()->current_account_id)->where('forms.id', $this->current_form_id)->select('forms.id as form_id', 'forms.*', 'logos.logo_url')->first();
        if ($this->current_form != null)
        {
            $this->current_form_id = $this->current_form->form_id;
        }
        else
        {
            $this->current_form = Form::where('forms.account_id', Auth::user()->current_account_id)->where('forms.id', $this->current_form_id)->get()->first();
            $this->current_form_id = $this->current_form->id;
        }
        $this->current_form_kiosks = Kiosk::whereform_id($this->current_form_id)->get();

        //  to enable updating of form on each change or action
        $form=Form::whereid($this->current_form_id)->first();
        $form->updating=true;$form->save();
        $this->update_currentform();
        $this->dispatchBrowserEvent('contentChanged');
    }
    // delete terms
    public function deleteterms()
    {
        $form_trans_terms=FormTrnslations::whereform_id($this->terms_form_delete_id)->get();
         foreach($form_trans_terms as $form_trans)
          {  $form_trans->terms=null;
            $form_trans->save();}
        $this->current_questions = $this->getquestions($this->current_form_id);
        // re order the questions

        $this->current_form = Form::join('logos', 'logos.id', '=', 'forms.logo_id')
            ->where('forms.account_id', Auth::user()->current_account_id)->where('forms.id', $this->current_form_id)->select('forms.id as form_id', 'forms.*', 'logos.logo_url')->first();
        if ($this->current_form != null)
        {
            $this->current_form_id = $this->current_form->form_id;
        }
        else
        {
            $this->current_form = Form::where('forms.account_id', Auth::user()->current_account_id)->where('forms.id', $this->current_form_id)->first();
            $this->current_form_id = $this->current_form->id;
        }
        $this->current_form_kiosks = Kiosk::whereform_id($this->current_form_id)->get();
        $this->dispatchBrowserEvent('contentChanged');
        //  to enable updating of form on each change or action
        $form=Form::whereid($this->current_form_id)->first();
        $form->updating=true;$form->save();
        $this->current_message = FormTrnslations::whereform_id($this->current_form_id)->whereform_local($this->local)->first();


    }

    public function render()
    {
        return view('livewire.forms.edit.edit-form-questions');
    }
}
