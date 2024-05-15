<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Models\Questions;
use App\Models\QuestionTranslation;
use App\Models\Answers;
use App\Models\AnswersTranslation;
use App\Models\Form;
use App\Models\Pictures;
use App\Models\QuestionType;
use App\Models\CustomQuestion;
use App\Models\CustomQuestionTranslation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
// use Illuminate\Validation\Rules;
use Illuminate\Support\Collection;
use Livewire\WithFileUploads;
use Storage;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;
use Image;
// google translate api
use Stichoza\GoogleTranslate\GoogleTranslate;
class EditQuestion extends Component
{
    // old
    use WithFileUploads;
    public $step=1;
    public $modal=false;
    public $stepanswer=0;
    public $stepimage;
    public $currentanswer=null;
    public $answers=[];
    public $current_image;
    public $imagesrc;
    public $show=false;
    public $numofanswers=50;
    public $numofanswerslist=200;
    public $count=0;
    public $image;
    public $answersdeleted=[];
    public $imagedefultsrc;
     public $answerdeleteid;
    // to detect where user click add score
    public $stepscore=null;
    public $setscore=array();
    public $sethide=array();
    public $setskip=array();
    public $setterminate=array();
    // new
    public $type_detail;
    public $question;
    public $question_text;
    public $custom_questions;
    public $type;
    public $local;
    public $languages;
    public $maxAnswersNum=50;
    public $deleteaction="deleteAnswerConfirmation";
    public $is_mandetory_question=null;
    // satisafaction and rating with image (new 8-28)
    public $question_image;
    public $question_image_temp;
    public $languageNamesByCode;
    public $Chars=["A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z",
    "AA","AB","AC","AD","AE","AF","AG","AH","AI","AJ","AK","AL","AM","AN","AO","AP","AQ","AR","AS","AT","AU","AV","AW","AX","AY","AZ"
  ];
    public $hint_q='[
        { "id": 1,"local":"en", "question": "Enter your question here"},
        { "id": 2,"local":"ar" ,"question": "أدخل سؤالك هنا"},
        { "id": 3, "local":"tl","question": "Ilagay ang iyong tanong dito"},
        { "id": 4, "local":"ur","question": "کیا تمہیں پسند ہے"}
    ]';
    public $hints_questions;
    public $hint_question;
    public $questionsTextImages;
    public $questionstextimages='{
        "email":"images/questionstextimages/email_question.png",
        "date_question":"images/questionstextimages/date_question.png",
        "drawing":"images/questionstextimages/drawing_question.png",
        "long_text_question":"images/questionstextimages/longtext_question.png",
        "short_text_question":"images/questionstextimages/shorttext_question.png",
        "number":"images/questionstextimages/number_question.png"
    }';

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
    protected $listeners = ['edit'=>'edit',
        // to delete form
        'deleteanswerConfirmed'=>'deleteanswer',
        'save'=>'save',
];
    // to initializtion array of skip,hide,score,terminate and num of answers based on type of question
    public function initvalue($count)
    {
        for ($i=0; $i <$count ; $i++) {
            $this->setscore[$i]=$this->answers[$i]['score']>0?1:0;
            // $this->setskip[$i]=$this->answers[$i]['skip'];
            // $this->setterminate[$i]=$this->answers[$i]['terminate'];
            $this->sethide[$i]=$this->answers[$i]['hide'];
        }
        // if type is logic (yes or no...) then there is only two answers and user cannot add it , we will add it auto
        if($this->type=="yes_no"||$this->type=="like_dislike"||$this->type=="Agree_Disagree")
        { $this->numofanswers=$count;

        }
        elseif($this->type=="rating"||$this->type=="satisfaction")
        {$this->numofanswers=$count;
        }
        else
        $this->type=="list"?$this->numofanswers=200:$this->numofanswers=50;

    }

    public function mount(){

        $this->imagedefultsrc="images/default_answer_image.png";
        $this->step=1;
        $this->stepanswer=0;
        $this->show=false;
        $this->currentanswer=null;
        $this->hints_questions = json_decode($this->hint_q, true);


    }
    public function selectquestionhint()
    {

        for ($i=0; $i <count($this->hints_questions) ; $i++) {
            if($this->hints_questions[$i]['local']==$this->local)
              return $this->hints_questions[$i]['question'];

        }

    }
    // initial function
    public function edit($id,$local,$languages){

        $this->resetvalue();
        // $this->question=new Questions();
        $this->question=Questions::whereid($id)->first();
        $this->is_mandetory_question=!(bool)$this->question->optional;

        $this->local=$local;
        $this->languages=$languages;

        $this->hint_question=$this->selectquestionhint();
        $this->languageNamesByCode = array_column($this->languages, 'name', 'code');

        $this->questionsTextImages=json_decode($this->questionstextimages, true);


        $questionType=QuestionType::whereid($this->question['type_of_question_id'])->first();
        $this->type=$questionType->question_type ;

        $this->type_detail=app()->getLocale() == 'en'?$questionType->question_type_details : $questionType->question_type_details_ar;


        // if type of question is custom
        /*if($this->type=='custom_rating'||$this->type=='custom_satisfaction')
        {    $ques=Questions::join('custom_questions', 'questions.id', '=', 'custom_questions.question_id')->
            groupBy('custom_questions.custom_question_id')->
            join('custom_question_translations','custom_questions.custom_question_id','=','custom_question_translations.custom_question_id')->
            where('custom_question_translations.question_local','=',$this->local)->where('questions.id','=',$this->question['id'])
            ->select('questions.*','custom_question_translations.question_details As details','custom_question_translations.question_local As local')
            ->orderby('questions.question_order')->first();

            $this->question_text=$ques->details;
            $parent_question=CustomQuestion::wherequestion_id($ques->id)->first();

            $child_questions=Questions::join('custom_questions', 'questions.id', '=', 'custom_questions.question_id')
            ->join('question_translations','questions.id','=','question_translations.question_id')
             ->join('pictures','custom_questions.picture_id','=','pictures.id')
            ->where('custom_questions.custom_question_id','=',$parent_question->id)
            ->where('question_translations.question_local','=',$this->local)
            ->select('custom_questions.id as child_id','questions.*','question_translations.id as question_trans_id','question_translations.question_details as details','pictures.pic_url As image')->get();
            foreach($child_questions as $i=> $child)
                {
                    $child_answers=Answers::wherequestion_id($child['id'])->get();
                    $collect=collect(
                        ["id"=>$child['id'],
                        "value"=>$child['details'],
                        "code"=>$i+1,
                        "score"=>null,
                        "hide"=>null,
                        "skip"=>null,
                        "new"=>false,
                        "terminate"=>null,
                        "image"=>$child['image'],
                        "child_answers"=>$child_answers,

                        ]
                    );
                    array_push($this->answers,$collect);
                }




        }
        // if type of question is not custom
        else
        {*/
            // get question
            $ques=Questions::join('question_translations','questions.id','=','question_translations.question_id')->
            whereNotIn('questions.type_of_question_id',[8,9])->
            select('questions.*','question_translations.question_details As details','question_translations.question_local As local')->
            where('question_translations.question_local','=',$this->local)->where('questions.id','=',$this->question['id'])->get();
            // question details

            $this->question_text=$ques[0]->details;
            if($this->type=='rating_image'||$this->type=='satisfaction_image')
            {
               $this->question_image=Pictures::whereid($this->question->picture_id)->first()->pic_url;
               $this->question_image_temp=$this->question_image;
            }
            // answers
            // multi with image

            //  if($this->type=="yes_no"||$this->type=="like_dislike"||$this->type=="Agree_Disagree"||$this->type=="satisfaction"||$this->type=="rating"||$this->type=="rating")
            //  {
            //     $answers=Answers::where('question_id','=',$this->question['id'])->get();

            //     foreach($answers as $i=> $answer)
            //     {
            //         $collect=collect(
            //             ["id"=>$answer['id'],
            //             "value"=>$i,
            //             "code"=>$i+1,
            //             "score"=>$answer['score'],
            //             "hide"=>$answer['hide'],
            //             "skip"=>$answer['conditional'],
            //             "terminate"=>$answer['terminate'],
            //             "image"=>null,

            //             ]
            //         );
            //         array_push($this->answers,$collect);

            //     }

            //  }
            if($this->type=='mcq_pic'||$this->type=='checkbox_pic')
            {
                $answers=Answers::where('question_id','=',$this->question['id'])->join('answer_translations','answers.id','=','answer_translations.answer_id')
                ->where('answer_translations.answer_local','=',$this->local)->join('pictures','answers.picture_id','=','pictures.id')
                ->select('answers.*','answers.id as answer_id','answer_translations.*','pictures.pic_url As image')->get();
                foreach($answers as $i=> $answer)
                {   $action=$answer['conditional']?"Skip":($answer['terminate']?"End":"None");
                    $collect=collect(
                        ["id"=>$answer['answer_id'],
                        "value"=>$answer['answer_details'],
                        "code"=>$this->Chars[$i],
                        "score"=>$answer['score'],
                        "hide"=>$answer['hide'],
                        // "skip"=>$answer['conditional'],
                        "action"=>$action,
                        "new"=>false,
                        // "terminate"=>$answer['terminate'],
                        "image"=>$answer['image'],
                        "temp_image"=>$answer['image'],
                        ]
                    );
                    array_push($this->answers,$collect);
                }
            }
            // only multi without images
            else{
                $answers=Answers::where('question_id','=',$this->question['id'])->join('answer_translations','answers.id','=','answer_translations.answer_id')
                ->where('answer_translations.answer_local','=',$this->local)
                ->select('answers.*','answers.id as answer_id','answer_translations.*')->get();

                foreach($answers as $i=> $answer)
                {   $action=$answer['conditional']?"Skip":($answer['terminate']?"End":"None");
                    $collect=collect(
                        ["id"=>$answer['answer_id'],
                        "value"=>$answer['answer_details'],
                        "code"=>$this->Chars[$i],
                        "score"=>$answer['score'],
                        "hide"=>$answer['hide'],
                        // "skip"=>$answer['conditional'],
                        "action"=>$action,
                        "new"=>false,
                        // "terminate"=>$answer['terminate'],
                        "image"=>null,
                        "temp_image"=>null,

                        ]
                    );
                    array_push($this->answers,$collect);
                }

            }



        // }


        $this->count=count($this->answers);
        $this->stepanswer=count($this->answers);
        $this->initvalue($this->count);
        $this->dispatchBrowserEvent('loadquestion',['question'=>$this->question,'question_text'=>$this->question_text,'type'=>$this->type,'answers'=>$this->answers,'local'=>$this->local,'languages'=>$this->languages]);


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
        {$this->answers[$i]['skip']=true;
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

    // save image after crop it
    public function cropimage(){
        $this->dispatchBrowserEvent('save');



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

        $image = Image::make($image_base64);


        $this->modal=false;

        // if image for questiion (satisfaction_image or rating_image)
        if($this->type=="satisfaction_image"||$this->type=="rating_image")
        {
            $name=Auth::user()->id.uniqid().Carbon::now()->format('YmdHis').'.jpg';
            $file = $folderPath .$name;
            if(str_contains($this->question_image, 'storage/images/temp/'))
            {
                File::delete(public_path($this->question_image));
            }
            $this->question_image_temp="/storage/images/temp/".$name;
             $image->save($file, 100);
        }
        else{
            $name=Auth::user()->id.$this->stepimage.uniqid().Carbon::now()->format('YmdHis').'.jpg';
            $file = $folderPath .$name;
            if(str_contains($this->answers[$this->stepimage]['image'], 'storage/images/temp/'))
            {
                File::delete(public_path($this->answers[$this->stepimage]['image']));

            }
            $this->answers[$this->stepimage]['temp_image']="/storage/images/temp/".$name;
            $image->save($file, 100);
        }

    }

    // index image
    public function updatecurrentimageindex($i){
        $this->stepimage=$i;
    }

    public function updatedimage(){

                $this->modal=true;
                // $this->answers[$this->stepimage]['image']=$this->image->temporaryUrl();
                $this->imagesrc=$this->image->temporaryUrl();
                $this->dispatchBrowserEvent('image-updated-edit', ['image' => $this->image]);

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
        $this->question=$value;
    }

     // increase the step
    public function increasestep(){
        $this->step+=1;
    }

    //   on delete answer
    public function deleteanswer()
    {
        array_push($this->answersdeleted,$this->answers[$this->answerdeleteid]['id']);

        //    $this->answers[$i]['code']=null;
        // if the item deleted IS the last item
            if($this->answerdeleteid==$this->count-1)
            {
                $this->count-=1;

                $this->stepanswer-=1;
                array_pop($this->answers);
            }
        else
        {
          for($j=$this->answerdeleteid;$j<$this->count-1;$j++)
           {
                    $this->answers[$j]['id']= $this->answers[$j+1]['id'];
                    $this->answers[$j]['value']= $this->answers[$j+1]['value'];
                    $this->answers[$j]['image']= $this->answers[$j+1]['image'];
                    $this->answers[$j]['temp_image']= $this->answers[$j+1]['temp_image'];

                    $this->answers[$j]['score']= $this->answers[$j+1]['score'];
                    $this->answers[$j]['hide']= $this->answers[$j+1]['hide'];
                    // $this->answers[$j]['skip']= $this->answers[$j+1]['skip'];
                    // $this->answers[$j]['terminate']= $this->answers[$j+1]['terminate'];
                    $this->answers[$j]['action']= $this->answers[$j+1]['action'];
                    $this->setscore[$j]=$this->setscore[$j+1];
                    $this->setskip[$j]=$this->setskip[$j+1];
                    $this->setterminate[$j]=$this->setterminate[$j+1];
                    $this->sethide[$j]=$this->sethide[$j+1];
            }

            $this->count-=1;

            $this->stepanswer-=1;

            array_pop($this->answers);

        }
        // if there is one answer
        if(count($this->answers)==1)
        { $this->answers[0]['hide']=false;
         $this->sethide[0]=false;}

    }

    // function to add answers
    public function addanswer(){



        $this->validate
            (
                ['answers.*.value' =>['required'],],
                ['answers.*.value.required'=>'The answer can\'t be  empty '


                ]
            );


            // set the type of image dependent on type of question---||$this->type=="custom_rating"||$this->type=="custom_satisfaction")
          if($this->type=="mcq_pic"||$this->type=="checkbox_pic")
             { $image=$this->imagedefultsrc;

            }
          else
          {$image=null;}

            // if the question is the first question
        if($this->count==0)
            {


                $collect=collect(
                    ["id"=>-1,
                    "code"=>$this->Chars[$this->count],
                    "value"=>null,
                    "image"=>$image,
                    "temp_image"=>$image,
                    "score"=>0,
                    "hide"=>false,
                    "new"=>true,
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
                    ["id"=>-1,
                    "code"=>$this->Chars[$this->count],
                    "value"=>null,
                    "image"=>$image,
                    "temp_image"=>$image,
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



    }

    // reset value
    public function resetvalue(){

       foreach ($this->answers as $i =>  $answer )
        {
            if(str_contains($answer['temp_image'],'storage/images/temp/'))
            {
              File::delete(public_path($answer['temp_image']));
            }
        }
        if(str_contains($this->question_image_temp,'storage/images/temp/'))
           File::delete(public_path($this->question_image_temp));

        $this->step=1;
        $this->type=null;
        $this->answers=[];
        $this->stepanswer=0;
        $this->currentanswer=null;
        $this->count=0;
        $this->answersdeleted=[];
        $this->question="do you           ?";
        for ($i=0; $i <$this->numofanswers ; $i++) {
            $this->setscore[$i]=0;
            $this->setskip[$i]=0;
            $this->setterminate[$i]=0;
            $this->sethide[$i]=0;
       }

        $this->resetErrorBag();

    }
    // realtime validate
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName,[
            'answers.*.value' =>['required'],
            'question' =>['required','min:6'],
            'answers'=>['required','min:1'],
            'answers.*.score'=>[ 'required','numeric','min:0','max:10']
        ],
        [
        'answers.*.value.required'=>'The answer can\'t be  empty ',

        'question.min'=>'The :attribute must contain at least 10 characters ',
        'answers.*.score.max'=>'the score should be between 0 and 10',
        'answers.*.score.min'=>'the score should be between 0 and 10',
        'question.required'=>'The :attribute is empty ',
        'answers.required'=>'You should add at least one answer']
    );
    }

    //   delete Answer confirmation
    public function deleteAnswerConfirmation($id){
        $this->answerdeleteid=$id;
        $this->dispatchBrowserEvent('show-delete-answer-confirmation');
        //    to re select the current form

    }
      // validate on submit
    public function validatedata(){

        // if($this->type!='custom_satisfaction'||$this->type!='custom_rating')
        // { $this->validate([
        //     'answers.*.score'=>[ 'required','numeric','min:0','max:10']
        // ],[
        //     'answers.*.score.required'=>'The score can\'t be  empty ',
        //     'answers.*.score.max'=>'the score should be between 0 and 10',
        // 'answers.*.score.min'=>'the score should be between 0 and 10',
        // ]
        //   );
        // dd($this->answers);
        // }



        $this->validate([

            'answers.*.value' =>['required'],
            'question' =>['required','min:6'],
            'answers'=>['required','min:1'],
            ],[
            'answers.*.value.required'=>'The answer can\'t be  empty ',
            'question.min'=>'The :attribute must contain at least 10 characters ',
            'question.required'=>'The :attribute is empty ',
            'answers.required'=>'You should add at least one answer',

        ]
          );
    }
    // validate on submit only for yes or no types
    public function validatequestion(){


        $this->validate([


            'question' =>['required','min:6'],


        ],[

            'question.min'=>'The :attribute must contain at least 10 characters ',

            'question.required'=>'The :attribute is empty ',


        ]
          );
    }
    // to  save question
    public function save(){
        try
        {
            if($this->type=="drawing"||$this->type=="yes_no"||$this->type=="like_dislike"||$this->type=="Agree_Disagree"||$this->type=="rating"||$this->type=="satisfaction"||$this->type=="short_text_question"||$this->type=="email"||$this->type=="number"||$this->type=="date_question"||$this->type=="long_text_question")
            {$this->validatequestion();}
            else
            {$this->validatedata();}

            $folderPath ='storage/images/upload/';
            if (!file_exists($folderPath)) {
                mkdir($folderPath, 0777, true);
            }
            $form_id=$this->question['form_id'];
            // if custom question

                // mandetory or no questions
                $Question=Questions::find($this->question['id']);

                $Question->optional=!$this->is_mandetory_question;

                if($this->type=="satisfaction_image"||$this->type=="rating_image")
                {
                    if(str_contains($this->question_image_temp, 'storage/images/temp/'))
                    {
                    $image_name="question_image-".Auth::user()->id.Carbon::now()->format('YmdHis');
                    $name=$image_name . '.jpg';
                    $file = $folderPath .$name;
                    $old=public_path($this->question_image_temp);
                    $new=$file;
                    if(str_contains($this->question_image,'storage/images/upload/'))
                    File::delete(public_path($this->question_image));

                    File::move($old , $new);
                    }
                    else
                    {
                        $new=$this->question_image;
                    }
                    $imageQuestionInfo=Pictures::whereid($Question->picture_id)->first();
                    $imageQuestionInfo->pic_url=$new;
                    $imageQuestionInfo->save();

                }

                $Question->save();

                // delete the answers that its deleted
                for ($i=0; $i <count($this->answersdeleted) ; $i++)
                {

                    // $answer=Answers::wherequestion_id($this->question['id'])
                    // ->join('answer_translations','answer_translations.answer_id','=','answers.id')->Where('answer_translations.id','=',$this->answersdeleted[$i])
                    // ->select('answers.*','answer_translations.*')->get();
                    $answer=Answers::wherequestion_id($this->question['id'])->whereid($this->answersdeleted[$i])->first();
                     if($answer){
                    $answersTransDeleting=AnswersTranslation::whereanswer_id($answer['id']);
                    $answersTransDeleting->delete();
                   $answersDeleting=Answers::findOrFail($answer['id']);
                   $answersDeleting->delete();
                    // if answer have image
                    if($answer['picture_id']!=null)
                    {
                    $imagepath=Pictures::whereid($answer['picture_id'])->first()->pic_url;
                        if(str_contains($imagepath, 'storage/images/temp/')||str_contains($imagepath, 'storage/images/upload/'))
                    {
                        File::delete(public_path($imagepath));}
                        $imagesDeleting=Pictures::findOrFail($answer['picture_id']);
                        $imagesDeleting->delete();
                    }}


                }


                $question_trans=QuestionTranslation::wherequestion_id($this->question['id'])->wherequestion_local($this->local)->first();
                $question_trans->question_details=$this->question_text;
                $question_trans->save();

                //  detect the source of trnslation
                $source="";
                foreach($this->languages as $lang)
                {
                    if($lang['code']==$this->local)
                    {
                    $source=$lang['trans'];
                    }

                }
                /*
                here we will save answers
                1 detect type
                 1.1 get answers
                2 if answer exist =>edit it
                3 if answer no exist=>add it
                4 save
                */
                //if question yes or no .......
                if($this->type=="yes_no"||$this->type=="like_dislike"||$this->type=="Agree_Disagree"||$this->type=="rating"||$this->type=="satisfaction")
                {
                    foreach($this->answers as $ans)

                    {
                        $answer=Answers::find($ans['id']);

                        $answer->score=$ans['score'];
                        $ans['action']=="Skip"?$answer->conditional=true:$answer->conditional=false;
                        $ans['action']=="End"?$answer->terminate=true:$answer->terminate=false;
                        $answer->hide=$ans['hide'];
                        $answer->Save();

                    }
                }
                //else another question
                else{

                    foreach($this->answers as $i=>$ans)
                    {

                        // if answer is exsist =>edit it

                        if(Answers::find($ans['id']))
                        {
                            $answer=Answers::wherequestion_id($this->question['id'])
                            ->join('answer_translations','answer_translations.answer_id','=','answers.id')->Where('answers.id','=',$ans['id'])
                            ->where('answer_translations.answer_local',$this->local)->first();

                            // if answer  have image
                            if($answer->picture_id!=null)
                                {    $image=Pictures::join('answers','pictures.id','=','answers.picture_id')->where('answers.id','=',$answer->answer_id)->select('pictures.*')->first();

                                    if(str_contains($ans['temp_image'],'storage/images/temp/'))
                                    {
                                        $image_name="answer-image-".$this->question['id'].uniqid().$i.Auth::user()->id.Carbon::now()->format('YmdHis');
                                        $name=$image_name . '.jpg';
                                        $file = $folderPath .$name;

                                        $old=public_path($ans['temp_image']);
                                        $new=$file;

                                        if(str_contains($ans['image'],'storage/images/upload/'))
                                        File::delete(public_path($ans['image']));

                                        File::move($old , $new);
                                    }
                                        else
                                        $new=$ans['image'];

                                    $image->pic_url=$new;

                                    $image->save();

                                    $answer_trans=AnswersTranslation::find($answer->id);
                                    $answer_trans->answer_details=$ans['value'];

                                    $answer_trans->save();


                                }
                                // if answer not have image => answer without image
                            else{
                                    $answer_trans=AnswersTranslation::find($answer->id);
                                    $answer_trans->answer_details=$ans['value'];
                                    $answer_trans->save();


                                }
                            // edit answer details score,skip,hide

                            $answer=Answers::find($answer->answer_id);

                            $answer->score=$ans['score'];
                            // $Answer->conditional=$ans['skip'];
                            // $Answer->terminate=$ans['terminate'];
                            $ans['action']=="Skip"?$answer->conditional=true:$answer->conditional=false;
                            $ans['action']=="End"?$answer->terminate=true:$answer->terminate=false;
                            $answer->hide=$ans['hide'];
                            $answer->Save();
                        }
                        // if answer is not exsist =>add it
                        else
                        {
                            // if answer  have image
                            if($ans['temp_image']!=null)
                            {
                                if(str_contains($ans['temp_image'], 'storage/images/temp/'))
                                {
                                    $image_name="answer-image-".$this->question['id'].uniqid().$i.Auth::user()->id.Carbon::now()->format('YmdHis');
                                    $name=$image_name . '.jpg';
                                    $file = $folderPath .$name;
                                    $old=public_path($ans['temp_image']);
                                    $new=$file;
                                    File::delete(public_path($ans['image']));
                                    File::move($old , $new);
                                }
                                else
                                {
                                    $new=$ans['temp_image'];

                                }

                                $image_ans=new Pictures();
                                $image_ans->pic_url=$new;
                                $image_ans->pic_name=$ans['value'];
                                $image_ans->user_id=Auth::user()->id;
                                $image_ans->account_id=Auth::user()->current_account_id;
                                $image_ans->save();
                                $answer=new Answers();
                                $answer->question_id=$this->question['id'];
                                $answer->picture_id=$image_ans->id;
                                $answer->score=$ans['score'];
                                // $answer->conditional=$ans['skip'];
                                // $answer->terminate=$ans['terminate'];
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
                                    // $answer_trans->answer_details=" ";
                                    // {
                                    //     // try {
                                    //     //     $tr = new GoogleTranslate();
                                    //     //     $answer_trans->answer_details=$tr->setSource($source)->setTarget($lang['trans'])->translate($ans['value']);
                                    //     // } catch (\Throwable $th) {
                                    //     //     $answer_trans->answer_details=$ans['value'];

                                    //     // }
                                    //   $answer_trans->answer_details=$ans['value'];

                                    // }
                                    $answer_trans->answer_details=$ans['value'];
                                    $answer_trans->save();
                                }

                            }
                            // if answer not have image => answer without image
                            else
                            {
                                $answer=new Answers();
                                $answer->question_id=$this->question['id'];
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

                                    //    $answer_trans->answer_details=$ans['value'];

                                    // }
                                    $answer_trans->answer_details=$ans['value'];
                                    $answer_trans->save();
                                }
                            }
                        }



                    }
                }


            // }
            //  to enable updating of form on each change or action
            $form=Form::whereid($form_id)->first();
            $form->updating=true;$form->save();
            $this->resetvalue();
            // emit if question edit success
            // $this->emit('questioneditsuccess',$form_id);
            return redirect()->route('editform', ['id' => $form_id,'lastLocal'=>$this->local])->with('success_message','your Question has been edit successfuly');
        }
        catch (\Throwable $th) {
            return redirect()->route('editform', ['id' => $this->form_id,'lastLocal'=>$this->local])->with('error_message','cannnot be add');

        }
    }
    public function render()
    {

        return view('livewire.edit-question');
    }
}
