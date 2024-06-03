<?php

namespace App\Http\Livewire;

use Livewire\Component;
// google translate api
use Stichoza\GoogleTranslate\GoogleTranslate;
use Illuminate\Support\Facades\Validator;
// use Illuminate\Validation\Rules;
use Illuminate\Support\Collection;
use Livewire\WithFileUploads;
use App\Models\QuestionType;
use App\Models\Form;
use Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use App\Models\Questions;
use App\Models\QuestionTranslation;
use App\Models\Answers;
use App\Models\AnswersTranslation;
use App\Models\Pictures;
use App\Models\CustomQuestionTranslation;
use App\Models\CustomQuestion;
use Illuminate\Support\Facades\Auth;
use App\Models\CategoryType;
use App\Models\Subscribe;
use App\Models\SubscribePlan;
use App\Models\TypeSubscribe;
use App\Models\FormTrnslations;
use Carbon\Carbon;


use Intervention\Image\ImageManagerStatic as Image;

class AddQuestion extends Component

{ use WithFileUploads;
    public $step=1;
    public $modal=false;
    public $stepanswer=0;
    public $type=null;
    public $type_detail;
    public $question_text;
    public $stepimage;
    public $currentanswer=null;
    public $answers=[];
    public $current_image;
    public $imagesrc;
    public $show=false;
    public $numofanswers;
    public $deleteaction="deleteanswer";
    public $count=0;
    public $image;
    public $languages;
    public $imagedefultsrc;
    public $is_mandetory_question=null;
    public $selectedTypeId=null;
    // category of types
    public $category_types;

    // end category of types
    //subscribe
    public $valid=false;
    public $validAccount;
    public $current_subscribe;
    public $error;
    public $accountStatus;

    public $languageNamesByCode;
    public $main_languages;
    public $maxAnswersNum=50;
    public $Chars=["A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z",
    "AA","AB","AC","AD","AE","AF","AG","AH","AI","AJ","AK","AL","AM","AN","AO","AP","AQ","AR","AS","AT","AU","AV","AW","AX","AY","AZ"
  ];
    public $main_lang = '[
        { "id": 1,"code":"en", "name": "English","trans":"en"},
        { "id": 2,"code":"ar" ,"name": "Arabic","trans":"ar"},
        { "id": 3, "code":"ur","name": "Urdu","trans":"ur"},
        { "id": 4, "code":"tl","name": "Tagalog","trans":"fil"}
    ]';

    public $hints_questions;
    public $questionsTextImages;
    // satisafaction and rating with image (new 8-28)
    public $question_image="images/default_answer_image.png";
    // to detect where user click add score
    public $stepscore=null;
    public $setscore=array();
    public $sethide=array();
    public $setskip=array();
    public $setterminate=array();
    public $questionstextimages='{
        "email":"images/questionstextimages/email_question.png",
        "date_question":"images/questionstextimages/date_question.png",
        "drawing":"images/questionstextimages/drawing_question.png",
        "long_text_question":"images/questionstextimages/longtext_question.png",
        "short_text_question":"images/questionstextimages/shorttext_question.png",
        "number":"images/questionstextimages/number_question.png"
    }';



    public $form_id;
    public $local;
    protected $listeners = ['add'=>'add',
    'resetvalue'=>'resetvalue'
];
    public function loadJsonData($file)
    {
        $path = resource_path('data/'.$file.'.json');
        if (File::exists($path)) {
            $json = File::get($path);
            return json_decode($json, true);
        } else {
            return ['error' => 'File not found'];
        }
    }
    public function add($form_id,$local,$languages){

        $this->form_id=$form_id;

        $this->local=$local;
        $this->main_languages = json_decode($this->main_lang, true);
        $this->questionsTextImages=json_decode($this->questionstextimages, true);
        $this->languageNamesByCode = array_column($this->main_languages, 'name', 'code');
        $this->languages=$languages;

        $this->CheckSubscribe();

    }

        // to set value of disabled of save button....if count of answer >0 then the disabled false
        public $disable=false;
    public function checkdisable()
    {
        if($this->type=="yes_no"||$this->type=="like_dislike"||$this->type=="Agree_Disagree"||$this->type=="rating"||$this->type=="satisfaction"||$this->type=="short_text_question"||$this->type=="email"||$this->type=="number"||$this->type=="date_question"||$this->type=="long_text_question")
        {
            $this->disable=false;

        }
        else
        {
            if(count($this->answers)>0)
            $this->disable=false;
            else
            $this->disable=true;
        }


    }
    // to initializtion array of skip,hide,score,terminate and num of answers based on type of question
    public function initvalue()
    {
         $this->answers=[];
        //    load file contain text of answers for logic and satisfacrion questions
         $answers_text=$this->loadJsonData($this->type);

         if (is_array($answers_text) && array_key_exists($this->local, $answers_text)) {
            $text = $answers_text[$this->local];
        } else {
            $text = ''; // or handle the case where $answers_text[$this->local] is not found
        }
        // if type is logic (yes or no...) then there is only two answers and user cannot add it , we will add it auto
        if($this->type=="yes_no"||$this->type=="like_dislike"||$this->type=="Agree_Disagree")
        {
            $this->numofanswers=2;



            for ($i=0; $i <2 ; $i++) {

            $collect=collect(
                ["id"=>$i,
                "code"=>$this->Chars[$i],
                "value"=>$text[$i],
                "image"=>null,
                "score"=>0,
                "hide"=>false,
                // "skip"=>false,
                // "terminate"=>false,
                "action"=>"None",
                ]
            );
            array_push($this->answers,$collect);
            }

        }
        elseif($this->type=="rating"||$this->type=="satisfaction"||$this->type=="rating_image"||$this->type=="satisfaction_image")
        {

            $this->numofanswers=5;
            if($this->type=="satisfaction"||$this->type=="satisfaction_image")
            {

                $svg=$answers_text['svg'];
                for ($i=0; $i <5 ; $i++) {
                    $idx=$i+1;

                    $collect=collect(
                        ["id"=>$i,
                        "code"=>$this->Chars[$i],
                        "value"=>$text[$i],
                        "image"=>null,
                        "score"=>0,
                        "hide"=>false,
                        "svg"=>$svg[$i],
                        "action"=>"None",
                        ]
                    );
                    array_push($this->answers,$collect);
                    }
            }
            else
            {


                for ($i=0; $i <5 ; $i++)
                {
                    $collect=collect(
                        ["id"=>$i,
                        "code"=>$text[$i],
                        "value"=>$text[$i],
                        "image"=>null,
                        "score"=>0,
                        "hide"=>false,
                        // "skip"=>false,
                        // "terminate"=>false,
                        "action"=>"None",
                        ]
                    );
                    array_push($this->answers,$collect);
                }
            }


        }
        else
        $this->type=="list"?$this->numofanswers=200:$this->numofanswers=50;

        for ($i=0; $i <$this->numofanswers ; $i++) {
             $this->setscore[$i]=0;
             $this->setskip[$i]=0;
             $this->sethide[$i]=0;
             $this->setterminate[$i]=0;
        }


    }


    public function mount(){

        $this->imagedefultsrc="images/default_answer_image.png";
        $this->step=1;
        $this->stepanswer=0;
        $this->show=false;
        $this->currentanswer=null;
        $this->category_types=CategoryType::with('enabledQuestionTypes')->get();

        $this->current_subscribe=SubscribePlan::getCurrentSubscription(Auth::user()->current_account_id);
    }
    // check valide subscribe
    public function CheckSubscribe(){


        //    $permissions= json_decode($this->plans_permission, true);



        $this->valid=$this->checkValidNumQuestions();

    }


    public function checkValidNumQuestions(){

        $this->current_subscribe=SubscribePlan::getCurrentSubscription(Auth::user()->current_account_id);
        $this->accountStatus=SubscribePlan::getCurrentAccountStatus(Auth::user()->current_account_id);
        $questions=Questions::whereform_id($this->form_id)->get();
        $num= count($questions);
        if($num<$this->current_subscribe->num_questions)
          $valid=true;
        else
        {
            $valid=false;
            $this->error=trans('main.num_questions_'.$this->current_subscribe->type);
        }
       return $valid;


    }
    // setterminate
    // save image after crop it
    public function cropimage(){
        $this->dispatchBrowserEvent('save-add');
    }
    public function saveimage($image,$step){

      if($this->type=="satisfaction_image"||$this->type=="rating_image")
      {
        $this->question_image=$image;
      }
      else
      {
        $this->answers[$step]['image']=$image;


      }




    }






    // on update question
    public function updatedquestion($value){
        $this->question_text=$value;
    }
    public function validatNextStep(){
        $this->validate(['selectedTypeId' =>['required'],],['selectedTypeId.required'=>trans('main.questiontyperequired')]);
    }
     // increase the step
    public function increasestep(){
         $this->validatNextStep();
        $questionType=QuestionType::whereid($this->selectedTypeId)->first();
        $this->answers=[];
        $this->count=0;
        $this->type=$questionType->question_type;
        $this->type_detail=app()->getLocale() == 'en'?$questionType->question_type_details : $questionType->question_type_details_ar;;
        $this->checkdisable();
        $this->initvalue();
        // add initial one answer
        if($this->type=="mcq"||$this->type=="checkbox"||$this->type=="mcq_pic"||$this->type=="checkbox_pic"||$this->type=="list")
         $this->addanswer();
        $this->step+=1;
    }

    //   on delete answer
    public function deleteAnswer($i)
    {

        //    $this->answers[$i]['code']=null;
        // if the item deleted IS the last item
        if (isset($this->answers[$i])) {

            unset($this->answers[$i]);

            // Re-index the array to remove gaps in the indices
            $this->answers = array_values($this->answers);

            // Update count and stepanswer
            $this->count = count($this->answers);
            $this->stepanswer = $this->count; // Assuming stepanswer should follow count

            // If there is one answer left, reset its 'hide' property
            if ($this->count == 1) {
                $this->answers[0]['hide'] = false;
                $this->sethide[0] = false;
            }

            // Call the checkdisable method
            $this->checkdisable();

        }



    }

    // function to add answers
    public function addanswer(){



        $this->validate
            (
                ['answers.*.value' =>['required'],],
                ['answers.*.value.required'=>trans('main.answernotempty')


                ]
            );


            // set the type of image dependent on type of question...||$this->type=="custom_rating"||$this->type=="custom_satisfaction"
          if($this->type=="mcq_pic"||$this->type=="checkbox_pic")
             { $image=$this->imagedefultsrc;

            }
          else
          {$image=null;

        }

            // if the answer is the first answer
        if($this->count==0)
        {


                $collect=collect(
                    ["id"=>$this->count,
                    "code"=>$this->Chars[$this->count],
                    "value"=>null,
                    "image"=>$image,
                    "score"=>0,
                    "hide"=>false,
                    // "skip"=>false,
                    // "terminate"=>false,
                    "action"=>"None",
                    ]
                );
                array_push($this->answers,$collect);
                $this->count+=1;
                $this->stepanswer+=1;
        }

        elseif($this->count>0)
        {

            $this->currentanswer=$this->answers[$this->count-1]['value'];
            if( $this->currentanswer!=" " &&  $this->currentanswer!=null)
            {  $name='answer'.$this->count-1;

                $collect=collect(
                    ["id"=>$this->count,
                    "code"=>$this->Chars[$this->count],
                    "value"=>null,
                    "image"=>$image,
                    "score"=>0,
                    "hide"=>false,
                    // "skip"=>false,
                    // "terminate"=>false,
                    "action"=>"None",
                    ]
                );
                array_push($this->answers,$collect);
                $this->count+=1;
                $this->stepanswer+=1;

            }
        }

      $this->checkdisable();

    }

    // reset value
    public function resetvalue(){

       foreach ($this->answers as $i =>  $answer )
        {
            if(str_contains($answer['image'],'storage/images/temp/'))
            {
              File::delete(public_path($answer['image']));}
        }
        if(str_contains($this->question_image,'storage/images/temp/'))
           File::delete(public_path($this->question_image));
            $this->step=1;
            $this->type=null;
            $this->answers=[];
            $this->stepanswer=0;
            $this->currentanswer=null;
            $this->count=0;
            // $this->question=$this->selectquestiondefult();
            for ($i=0; $i <$this->numofanswers ; $i++)
            {
                $this->setscore[$i]=0;
                $this->setskip[$i]=0;
                $this->setterminate[$i]=0;
                $this->sethide[$i]=0;
            }
        $this->resetErrorBag();

    }

    public function selecttype($id){
        $this->selectedTypeId=$id;

    }
    public function render()
    {
        return view('livewire.add-question');
    }
    // realtime validate
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName,[
            'answers.*.value' =>['required'],
            'question_text' =>['required','min:6'],
            'answers'=>['required','min:1'],
            'answers.*.score'=>[ 'required','numeric','min:0','max:10']
        ],
        [
        'answers.*.value.required'=>'The answer can\'t be  empty ',
        'answers.*.score.required'=>'The score can\'t be  empty ',
        'question_text.min'=>'The :attribute must contain at least 10 characters ',
        'answers.*.score.max'=>'the score should be between 0 and 10',
        'answers.*.score.min'=>'the score should be between 0 and 10',
        'question_text.required'=>'The :attribute is empty ',
        'answers.required'=>'You should add at least one answer']
      );
    }

    // validate on submit
    public function validatedata(){


        $this->validate([

            'answers.*.value' =>['required'],
            'question_text' =>['required','min:6'],
            'answers'=>['required','min:1'],
            'answers.*.score'=>[ 'required','numeric','min:0','max:10']

        ],[
            'answers.*.value.required'=>trans('main.answernotempty'),
            'answers.*.score.required'=>trans('main.scorenotempty'),
            'question_text.min'=>trans('main.questiontextmin'),
            'answers.*.score.max'=>trans('main.scoremax'),
        'answers.*.score.min'=>trans('main.scoremin'),
            'question_text.required'=>trans('main.questionrequired'),
            'answers.required'=>trans('main.answersrequired'),

        ]
          );
    }
    // validate on submit only for yes or no types
    public function validatequestion(){


        $this->validate([


            'question_text' =>['required','min:6'],


        ],[

            'question_text.min'=>trans('main.questiontextmin'),

            'question_text.required'=>trans('main.questionrequired'),


        ]
          );
    }
    public function save(){

        // allow to add question(num of questions)
        if($this->checkValidNumQuestions()&&$this->form_id!=null)
        {
            // validation
            if($this->type=="drawing"||$this->type=="yes_no"||$this->type=="like_dislike"||$this->type=="Agree_Disagree"||$this->type=="rating"||$this->type=="satisfaction"||$this->type=="rating_image"||$this->type=="satisfaction_image"||$this->type=="short_text_question"||$this->type=="email"||$this->type=="number"||$this->type=="date_question"||$this->type=="long_text_question")
                {$this->validatequestion();}
            else
                {$this->validatedata();}


            //  end of validation
            try
            {

                $this->resetErrorBag();

                // add question
                $Question=Questions::createQuestion($this->is_mandetory_question,$this->form_id,$this->type,$this->question_image,$this->languages,$this->question_text);

                // create Answers

                //  if question of type yes_no or like_dislike or..........or rating ..... then i will store only the answer without  image
                if($this->type=="yes_no"||$this->type=="like_dislike"||$this->type=="Agree_Disagree"||$this->type=="rating"||$this->type=="satisfaction"||$this->type=="rating_image"||$this->type=="satisfaction_image")
                {
                    $answers_text=$this->loadJsonData($this->type);

                    $Question->addAnswers($Question->id,$this->form_id,$this->answers,$this->languages,$this->local, $answers_text);

                }
                // if there another type of question
                else

                {
                    $Question->addAnswers($Question->id,$this->form_id,$this->answers,$this->languages,$this->local,null);
                }

                // to reset value after save
                $this->resetvalue();

                //  to enable updating of form on each change or action
                $form=Form::whereid($this->form_id)->first();

                if(count(FormTrnslations::whereform_id($this->form_id)->get())>1)
                {
                        $form->trans_notification=true;
                }

                $form->updating=true;
                $form->save();
                // emit if question add success

                // $this->emit('questionaddsuccess',$this->form_id);
                return redirect()->route('editform', ['id' => $this->form_id,'lastLocal'=>$this->local])->with('success_message','your question has been added successfuly');
            }
            catch (\Throwable $th)
            {

                return redirect()->route('editform', ['id' => $this->form_id,'lastLocal'=>$this->local])->with('error_message','cannnot be add');

            }
        }
        else
        return redirect()->route('editform', ['id' => $this->form_id,'lastLocal'=>$this->local])->with('error_message','cannnot be add');

    }

}
