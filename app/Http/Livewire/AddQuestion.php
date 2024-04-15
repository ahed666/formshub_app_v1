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
use Image;


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
    public $hint_q='[
        { "id": 1,"local":"en", "question": "Enter your question here"},
        { "id": 2,"local":"ar" ,"question": "أدخل سؤالك هنا"},
        { "id": 3, "local":"tl","question": "Ilagay ang iyong tanong dito"},
        { "id": 4, "local":"ur","question": "کیا تمہیں پسند ہے"}
    ]';
    public $hints_questions;
    public $hint_question;
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
    // ,{"type":"rating","custom_type":"custom_rating","0":"1","1":"2","2":"3","3":"4","4":"5"}
    /*


       ,
        }]
    */
    // custom satisafaction and rating text for languages
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

    public $form_id;
    public $local;
    protected $listeners = ['add'=>'add',
    'resetvalue'=>'resetvalue'
];
    public function add($form_id,$local,$languages){

        $this->form_id=$form_id;

        $this->local=$local;
        $this->main_languages = json_decode($this->main_lang, true);
        $this->questionsTextImages=json_decode($this->questionstextimages, true);
        $this->languageNamesByCode = array_column($this->main_languages, 'name', 'code');
        $this->languages=$languages;
        $this->hint_question=$this->selectquestionhint();

        $this->CheckSubscribe();

    }
    public $TypesOfQuestion;
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
        // if type is logic (yes or no...) then there is only two answers and user cannot add it , we will add it auto
        if($this->type=="yes_no"||$this->type=="like_dislike"||$this->type=="Agree_Disagree")
        { $this->numofanswers=2;

            $answers_text=json_decode($this->answers_json_text, true);

            $text=null;
            foreach($answers_text as $i=>$answer_text)
                $answer_text['type']==$this->type?$text=$answer_text:"";

            $text=$text[$this->local];
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
            {   $this->numofanswers=5;
                if($this->type=="satisfaction"||$this->type=="satisfaction_image"){
                $answers_text=json_decode($this->answers_json_text_satisfaction, true);
                $text=$answers_text[$this->local];
                for ($i=0; $i <5 ; $i++) {
                    $idx=$i+1;

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
            else{
                $answers_text=json_decode($this->answers_json_text_rating, true);

                for ($i=0; $i <5 ; $i++) {
                    $collect=collect(
                        ["id"=>$i,
                        "code"=>$answers_text[$i],
                        "value"=>$answers_text[$i],
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

    // to select question defult
    public function selectquestionhint()
    {

        for ($i=0; $i <count($this->hints_questions) ; $i++) {
            if($this->hints_questions[$i]['local']==$this->local)
              return $this->hints_questions[$i]['question'];

        }

    }
    public function mount(){

        $this->imagedefultsrc="images/default_answer_image.png";
        $this->step=1;
        $this->stepanswer=0;
        $this->show=false;
        $this->currentanswer=null;
        $this->category_types=CategoryType::all();


        $this->current_subscribe=SubscribePlan::getCurrentSubscription(Auth::user()->current_account_id);

        $this->TypesOfQuestion = QuestionType::whereenable(true)->get();

        $this->hints_questions = json_decode($this->hint_q, true);





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

    // to set index of hide
    public function changesethide($i){

        if($this->sethide[$i]==true)

        {
            if(count(array_filter($this->sethide))<count($this->answers))
               $this->answers[$i]['hide']=true;
            else
            $this->sethide[$i]=false;


        }
        else{
        $this->answers[$i]['hide']=false;
        }
    }
     // to set index of skip
    public function changesetskip($i){
        if($this->setskip[$i]==1)
        {
        $this->answers[$i]['skip']=true;
         $this->answers[$i]['terminate']=false;
         $this->setterminate[$i]=0;
        }
        else
        $this->answers[$i]['skip']=false;

    }
     // to set index of terminate
    public function changesetterminate($i){
        if($this->setterminate[$i]==1)
        {$this->answers[$i]['terminate']=true;
         $this->answers[$i]['skip']=false;
         $this->setskip[$i]=0;
        }
        else
        $this->answers[$i]['terminate']=false;
    }
    public function changesetscore($i){
        if($this->setscore[$i]!=1)
        $this->answers[$i]['score']=0;

    }


    // setterminate
    // save image after crop it
    public function cropimage(){
        $this->dispatchBrowserEvent('save-add');



    }
    public function saveimage($image){

        $folderPath = public_path('storage/images/temp/');
        if (!file_exists($folderPath)) {
            mkdir($folderPath, 0777, true);
        }
        $image_parts = explode(";base64,", $image);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);
        $image = Image::make($image_base64); // Use Intervention Image to handle the image


        $this->modal=false;
        // if image for questiion (satisfaction_image or rating_image)
        if($this->type=="satisfaction_image"||$this->type=="rating_image")
        {
            $name=Auth::user()->id.uniqid().Carbon::now()->format('YmdHis').'.jpg';
            $file = $folderPath .$name;
            if(str_contains($this->question_image, 'storage/images/temp/')||str_contains($this->question_image, 'storage/images/upload/'))
            {
                File::delete(public_path($this->question_image));
            }
            $this->question_image="/storage/images/temp/".$name;
            $image->save($file, 100); // The quality is set to 100 for high resolution

        }
        else
        {
            $name=Auth::user()->id.$this->stepimage.uniqid().Carbon::now()->format('YmdHis').'.jpg';
            $file = $folderPath .$name;
                if(str_contains($this->answers[$this->stepimage]['image'], 'storage/images/temp/')||str_contains($this->answers[$this->stepimage]['image'], 'storage/images/upload/'))
                {
                    File::delete(public_path($this->answers[$this->stepimage]['image']));
                }
                    $this->answers[$this->stepimage]['image']="/storage/images/temp/".$name;
                    $image->save($file, 100); // The quality is set to 100 for high resolution

        }


    }

    // index image
    public function updatecurrentimageindex($i){
        $this->stepimage=$i;
    }

    public function updatedimage(){

                $this->modal=true;

                // $this->answers[$this->stepimage]['image']=$this->image->temporaryUrl();
                     try {
                        $this->imagesrc=$this->image->temporaryUrl();

                    $this->dispatchBrowserEvent('image-updated-add', ['image' => $this->image]);
                     } catch (\Throwable $th) {
                        $this->imagesrc=null;
                         $this->dispatchBrowserEvent('image-updated-add', ['image' => $this->image]);
                     }




    }

    // to close the crop modal if user click close button or icon
    public function closemodal(){
        $this->answers[$this->stepimage]['image']=$this->imagedefultsrc;
        $this->modal=false;
    }

    // t oclose crop modal if user click save
    public function closemodalwithsave(){

        $this->modal=false;
    }
    // on update question
    public function updatedquestion($value){
        $this->question_text=$value;
    }

     // increase the step
    public function increasestep(){
        $this->step+=1;
    }

    //   on delete answer
    public function deleteanswer($i)
    {

        //    $this->answers[$i]['code']=null;
        // if the item deleted IS the last item
            if($i==$this->count-1)
            {
                $this->count-=1;

                $this->stepanswer-=1;
                array_pop($this->answers);
            }
        else
        {
          for($j=$i;$j<$this->count-1;$j++)
           {
                    $this->answers[$j]['value']= $this->answers[$j+1]['value'];
                    $this->answers[$j]['image']= $this->answers[$j+1]['image'];
                    $this->answers[$j]['score']= $this->answers[$j+1]['score'];
                    $this->answers[$j]['hide']= $this->answers[$j+1]['hide'];
                    // $this->answers[$j]['skip']= $this->answers[$j+1]['skip'];
                    // $this->answers[$j]['terminate']= $this->answers[$j+1]['terminate'];
                    $this->answers[$j]['action']= $this->answers[$j+1]['action'];
                    // $this->setscore[$j]=$this->setscore[$j+1];
                    // $this->setskip[$j]=$this->setskip[$j+1];
                    // $this->setterminate[$j]=$this->setterminate[$j+1];
                    // $this->sethide[$j]=$this->sethide[$j+1];
            }

            $this->count-=1;

            $this->stepanswer-=1;
            array_pop($this->answers);
        }

        // if there is one answer
        if(count($this->answers)==1)
        { $this->answers[0]['hide']=false;
         $this->sethide[0]=false;}
         $this->checkdisable();



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
        for ($i=0; $i <$this->numofanswers ; $i++) {
            $this->setscore[$i]=0;
            $this->setskip[$i]=0;
            $this->setterminate[$i]=0;
            $this->sethide[$i]=0;
       }
        $this->resetErrorBag();

    }
    public function selecttype($type,$type_detail){
        $this->answers=[];
        $this->count=0;
        $this->type=$type;
        $this->type_detail=$type_detail;
        $this->checkdisable();
        $this->initvalue();
        // add initial one answer
        if($this->type=="mcq"||$this->type=="checkbox"||$this->type=="mcq_pic"||$this->type=="checkbox_pic"||$this->type=="list")
         $this->addanswer();

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
            'answers.*.value.required'=>'The answer can\'t be  empty ',
            'answers.*.score.required'=>'The score can\'t be  empty ',
            'question_text.min'=>'The :attribute must contain at least 10 characters ',
            'answers.*.score.max'=>'the score should be between 0 and 10',
        'answers.*.score.min'=>'the score should be between 0 and 10',
            'question_text.required'=>'The :attribute is empty ',
            'answers.required'=>'You should add at least one answer',

        ]
          );
    }
    // validate on submit only for yes or no types
    public function validatequestion(){


        $this->validate([


            'question_text' =>['required','min:6'],


        ],[

            'question_text.min'=>'The :attribute must contain at least 10 characters ',

            'question_text.required'=>'The :attribute is empty ',


        ]
          );
    }
    public function save(){
        // allow to add question(num of questions)
        if($this->checkValidNumQuestions()&&$this->form_id!=null)
        {
            try
            {
                // validation
                if($this->type=="drawing"||$this->type=="yes_no"||$this->type=="like_dislike"||$this->type=="Agree_Disagree"||$this->type=="rating"||$this->type=="satisfaction"||$this->type=="rating_image"||$this->type=="satisfaction_image"||$this->type=="short_text_question"||$this->type=="email"||$this->type=="number"||$this->type=="date_question"||$this->type=="long_text_question")
                {$this->validatequestion();}
                else
                {$this->validatedata();}
                //  end of validation
                $this->resetErrorBag();
                // create folder upload if not exsist
                $folderPath ='storage/images/upload/';
                if (!file_exists($folderPath)) {
                    mkdir($folderPath, 0777, true);
                }
                $Question=new Questions();
                if($this->is_mandetory_question==1)
                $Question->optional=0;
                else
                $Question->optional=1;
                // calculate the order of question
                $max_order = Questions::where('form_id', $this->form_id)->max('question_order');

                $Question->question_order=$max_order+=1;

                // end calculate of question order
                $Question->form_id=$this->form_id;

                //add the type of question
                $Question->type_of_question_id=QuestionType::wherequestion_type($this->type)->first()->id;
                // if question have image(satisafaction or rating with image)
                if($this->type=="satisfaction_image"||$this->type=="rating_image")
                {
                    if(str_contains($this->question_image, 'storage/images/temp/'))
                    {
                    $image_name="question_image-".Auth::user()->id.Carbon::now()->format('YmdHis');
                    $name=$image_name . '.jpg';
                    $file = $folderPath .$name;
                    $old=public_path($this->question_image);
                    $new=$file;
                    File::move($old , $new);
                    }
                    else
                    {
                        $new=$this->question_image;
                    }
                    $image_q=new Pictures();
                    $image_q->pic_url=$new;
                    $image_q->pic_name="question_image-".Auth::user()->id.Carbon::now()->format('YmdHis');
                    $image_q->user_id=Auth::user()->id;
                    $image_q->account_id=Auth::user()->current_account_id;
                    $image_q->save();
                    $Question->picture_id=$image_q->id;
                }
                //  save question
                $Question->save();

                // //  detect the source of trnslation
                // $source="";
                // foreach($this->languages as $lang)
                // {if($lang['code']==$this->local)
                //     {
                //     $source=$lang['trans'];
                //     }

                // }
                // add translation of question for each language of form languages
                foreach($this->languages as $lang)
                {
                    $question_trans=new QuestionTranslation();
                    $question_trans->question_details=$this->question_text;
                    $question_trans->question_local=$lang['code'];
                    $question_trans->question_id=$Question->id;
                    $question_trans->save();
                }

                //  if question of type yes_no or like_dislike or..........or rating ..... then i will store only the answer without  image
                if($this->type=="yes_no"||$this->type=="like_dislike"||$this->type=="Agree_Disagree"||$this->type=="rating"||$this->type=="satisfaction"||$this->type=="rating_image"||$this->type=="satisfaction_image")
                {   //if satisfaction
                    if($this->type=="satisfaction"||$this->type=="satisfaction_image")
                    {
                        $answers_text=json_decode($this->answers_json_text_satisfaction, true);
                        foreach($this->answers as $ans)
                        {
                            $answer=new Answers();
                            $answer->question_id=$Question->id;
                            $answer->picture_id=null;
                            $answer->score=$ans['score'];
                            // $answer->conditional=$ans['skip'];
                            // $answer->terminate=$ans['terminate'];
                            $ans['action']=="Skip"?$answer->conditional=true:$answer->conditional=false;
                            $ans['action']=="End"?$answer->terminate=true:$answer->terminate=false;
                            $answer->hide=$ans['hide'];
                            $answer->save();

                            foreach($this->languages as $lang)
                            {
                                        $text=$answers_text[$lang['code']];
                                        $answer_trans=new AnswersTranslation();
                                        $answer_trans->answer_local=$lang['code'];
                                        $answer_trans->answer_id=$answer->id;
                                        if($lang['code']==$this->local)
                                        $answer_trans->answer_details=$ans['value'];
                                        else
                                        {
                                            $answer_trans->answer_details=$text[$ans['id']];

                                        }
                                        $answer_trans->save();
                            }
                        }
                    }
                    //if rating
                    elseif($this->type=="rating"||$this->type=="rating_image")
                    {
                        foreach($this->answers as $ans)
                        {
                        $answer=new Answers();
                        $answer->question_id=$Question->id;
                        $answer->picture_id=null;
                        $answer->score=$ans['score'];
                        $ans['action']=="Skip"?$answer->conditional=true:$answer->conditional=false;
                        $ans['action']=="End"?$answer->terminate=true:$answer->terminate=false;
                        $answer->hide=$ans['hide'];
                        $answer->save();

                        foreach($this->languages as $lang)
                        {

                                    $answer_trans=new AnswersTranslation();
                                    $answer_trans->answer_local=$lang['code'];
                                    $answer_trans->answer_id=$answer->id;
                                    $answer_trans->answer_details=$ans['value'];
                                    $answer_trans->save();
                        }
                    }
                    }
                    //if yes-no like-dislike agree-disagree
                    else
                    {
                        $answers_text=json_decode($this->answers_json_text, true);
                        $textofanswers="";
                        foreach($answers_text as $i=>$answer_text)
                        $answer_text['type']==$this->type?$textofanswers=$answer_text:"";


                        foreach($this->answers as $ans)
                        {
                            $answer=new Answers();
                            $answer->question_id=$Question->id;
                            $answer->picture_id=null;
                            $answer->score=$ans['score'];
                            $ans['action']=="Skip"?$answer->conditional=true:$answer->conditional=false;
                            $ans['action']=="End"?$answer->terminate=true:$answer->terminate=false;
                            $answer->hide=$ans['hide'];
                            $answer->save();

                            foreach($this->languages as $lang)
                            {
                                $text=$textofanswers[$lang['code']];

                                $answer_trans=new AnswersTranslation();
                                $answer_trans->answer_local=$lang['code'];
                                $answer_trans->answer_id=$answer->id;
                                if($lang['code']==$this->local)
                                $answer_trans->answer_details=$ans['value'];
                                else
                                {
                                    $answer_trans->answer_details=$text[$ans['id']];

                                }
                                $answer_trans->save();
                            }
                        }

                    }

                }
                // if there another type of question
                else
                {
                    foreach($this->answers as $i => $ans)
                    {

                        // if answer  have image
                            if($ans['image']!=null)
                            {
                                if(str_contains($ans['image'], 'storage/images/temp/'))
                                {

                                $image_name="answer_image-".$Question->id.uniqid().$i.Auth::user()->id.Carbon::now()->format('YmdHis');
                                $name=$image_name . '.jpg';
                                $file = $folderPath .$name;
                                $old=public_path($ans['image']);
                                $new=$file;
                                File::move($old , $new);
                                }
                                else
                                {
                                    $new=$ans['image'];
                                }
                                $image_ans=new Pictures();
                                $image_ans->pic_url=$new;
                                $image_ans->pic_name=$ans['value'];
                                $image_ans->user_id=Auth::user()->id;
                                $image_ans->account_id=Auth::user()->current_account_id;
                                $image_ans->save();
                                $answer=new Answers();
                                $answer->question_id=$Question->id;
                                $answer->picture_id=$image_ans->id;
                                $answer->score=$ans['score'];
                                $ans['action']=="Skip"?$answer->conditional=true:$answer->conditional=false;
                                $ans['action']=="End"?$answer->terminate=true:$answer->terminate=false;
                                $answer->hide=$ans['hide'];
                                $answer->save();

                                foreach($this->languages as $lang)
                                {
                                    $answer_trans=new AnswersTranslation();
                                    $answer_trans->answer_local=$lang['code'];
                                    $answer_trans->answer_id=$answer->id;
                                    // if($lang['code']==$this->local)
                                    // $answer_trans->answer_details=$ans['value'];
                                    // else
                                    // {
                                    //     // try {
                                    //     //     $tr = new GoogleTranslate();
                                    //     //     $answer_trans->answer_details=$tr->setSource($source)->setTarget($lang['trans'])->translate($ans['value']);
                                    //     // } catch (\Throwable $th) {
                                    //     //     $answer_trans->answer_details=$ans['value'];
                                    //     // }

                                    //     $answer_trans->answer_details=$ans['value'];


                                    // }
                                    $answer_trans->answer_details=$ans['value'];
                                    $answer_trans->save();
                                }

                            }
                            // if answer not have image => answer without image
                            else
                            {

                                $answer=new Answers();
                                $answer->question_id=$Question->id;
                                $answer->picture_id=null;
                                $answer->score=$ans['score'];
                                $ans['action']=="Skip"?$answer->conditional=true:$answer->conditional=false;
                                $ans['action']=="End"?$answer->terminate=true:$answer->terminate=false;
                                $answer->hide=$ans['hide'];
                                $answer->save();
                                foreach($this->languages as $lang)
                                {
                                    $answer_trans=new AnswersTranslation();
                                    $answer_trans->answer_local=$lang['code'];
                                    $answer_trans->answer_id=$answer->id;
                                    // if($lang['code']==$this->local)
                                    // $answer_trans->answer_details=$ans['value'];
                                    // else
                                    // {
                                    //     try {
                                    //         $tr = new GoogleTranslate();

                                    //     $answer_trans->answer_details=$tr->setSource($source)->setTarget($lang['trans'])->translate($ans['value']);
                                    //     } catch (\Throwable $th) {
                                    //         $answer_trans->answer_details=$ans['value'];
                                    //     }
                                    //     // $answer_trans->answer_details=$ans['value'];
                                    // }
                                    $answer_trans->answer_details=$ans['value'];
                                    $answer_trans->save();
                                }
                            }




                    }
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
