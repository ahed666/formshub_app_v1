<?php

namespace App\Models;

use App\Http\Livewire\AddQuestion;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use App\Models\Answers;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManagerStatic as Image;

class Questions extends Model
{
    use HasFactory;
    protected $table="questions";
    protected $fillable = [
        'id',
        'optional',
        'question_order',
        'form_id',
        'question_id',
        'type_of_question_id',

    ];

    // save Answer image
    public static function saveAnswerImage($questionId,$formId,$answerId,$imageFile){
        try {
            $path='storage/accounts/account-'.Auth::user()->current_account_id.'/forms/form-'.$formId.'/question-'.$questionId.'/answers'.'/';
            $name="answer_image-".$answerId.'.jpg';

            if (!file_exists($path)) {
                mkdir($path, 0755, true);
            }

            $newUrl = $path .$name;
                $image_parts = explode(";base64,", $imageFile);
                $image_type_aux = explode("image/", $image_parts[0]);
                $image_type = $image_type_aux[1];
                $image_base64 = base64_decode($image_parts[1]);
                $image = Image::make($image_base64); // Use Intervention Image to handle the image
                $image->save($newUrl, 100);
            return $newUrl;

        } catch (\Throwable $th) {
           dd($th);
        }
    }
    // save question image
    public static function saveQuestionImage($questionId,$formId,$imageFile){
        try {
            $path='storage/accounts/account-'.Auth::user()->current_account_id.'/forms/form-'.$formId.'/question-'.$questionId.'/';
            $name="question_image-".$questionId.'.jpg';

            if (!file_exists($path)) {
                mkdir($path, 0755, true);
            }

            $newUrl = $path .$name;
                $image_parts = explode(";base64,", $imageFile);
                $image_type_aux = explode("image/", $image_parts[0]);
                $image_type = $image_type_aux[1];
                $image_base64 = base64_decode($image_parts[1]);
                $image = Image::make($image_base64); // Use Intervention Image to handle the image
                $image->save($newUrl, 100);
            return $newUrl;

        } catch (\Throwable $th) {
           dd($th);
        }
    }

    // create new answer
    public static function createAnswer($questionId,$formId,$answer,$languages,$local,$translation){

        $newAnswer = Answers::createAnswer($questionId,null, $answer);

         // if answer  have image
         if($answer['image']!=null)
         {

              if(str_contains($answer['image'], 'data:image'))
              {

                 $newUrl=self::saveAnswerImage($questionId,$formId,$newAnswer->id,$answer['image']);


              }
              else
              {
                  $newUrl=$answer['image'];
              }

              $image_ans=Pictures::createFromAnswer($newUrl,$answer['value']);

             $newAnswer->picture_id=$image_ans->id;
             $newAnswer->save();


         }



         foreach($languages as $lang)
         {
             $text=$translation!=null?$translation[$lang['code']]:"";
             $value=$translation!=null?($lang['code']==$local?$answer['value']:$text[$answer['id']]):$answer['value'];
             $answer_trans=AnswersTranslation::translateAnswer($newAnswer->id,$lang['code'], $value);

         }
    }


    // Add answers for any questions
    //inputs quetion id , answers ,All languages ,current local , translation for answers to other langauges if this answers take translate(logic questions and satisfaction)
    public static function addAnswers($questionId,$formId,$answers,$languages,$local,$translation)
    {

        foreach($answers as $i => $answer)
        {

            self::createAnswer($questionId,$formId,$answer,$languages,$local,$translation);

        }
    }

    // edit answer
    public static function editAnswers($questionId,$formId,$answers,$languages,$local,$translation)
    {

        foreach($answers as $i => $answer)
        {
            // if old answer
            if($ans=Answers::find($answer['id'])){

                if($answer['image']!=null)
                {
                    if(str_contains($answer['image'], 'data:image'))
                    {

                       $newUrl=self::saveAnswerImage($questionId,$formId,$ans->id,$answer['image']);



                    }
                    else
                    {
                        $newUrl=$answer['image'];
                    }
                    $image=Pictures::find($ans->picture_id);
                    $image->pic_url=$newUrl;
                    $image->save();


                }

                $answer_trans=AnswersTranslation::where('answer_id','=',$ans->id)->first();
                $answer_trans->answer_details=$answer['value'];
                $answer_trans->save();
                $ans=Answers::editAnswer($ans,$answer);




            }


            // if new answer
            else{
                self::createAnswer($questionId,$formId,$answer,$languages,$local,$translation);
            }

        }
    }




    // Add new question
    //    mandetory (boolean)
    // form id  (int)
    // type (string) => type of question
    // question image  (string) => url of current stored path question image(if have)
    // languages (array)
    // question text (string)
    public static function createQuestion($mandetory,$formId,$type,$questionImage,$languages,$question_text){

        $question = new self();
        $question->optional=$mandetory==1?false:true;

        $max_order = self::where('form_id', $formId)->max('question_order');
        $question->question_order=$max_order+=1;

        $question->form_id=$formId;

        $question->type_of_question_id=QuestionType::wherequestion_type($type)->first()->id;
        $question->save();

        if($type=="satisfaction_image"||$type=="rating_image")
        {
                    if(str_contains($questionImage, 'data:image'))
                    {
                       $newUrl= self::saveQuestionImage($question->id,$formId,$questionImage);
                    }
                    else
                    {
                        $newUrl=$questionImage;
                    }


                    $image_q=Pictures::createFromAnswer($newUrl,'question image -'.$question->id);
                    $question->picture_id=$image_q->id;

                    $question->save();

        }



        foreach($languages as $lang)
        {
            $question_trans=new QuestionTranslation();
            $question_trans->question_details=$question_text;
            $question_trans->question_local=$lang['code'];
            $question_trans->question_id=$question->id;
            $question_trans->save();
        }

        return $question;

    }

    // edit question
    public static function editQuestion($questionId,$mandetory,$formId,$type,$questionImage,$local,$question_text){
        $question=self::find($questionId);
        $question->optional=$mandetory==1?false:true;




        $question->save();

        if($type=="satisfaction_image"||$type=="rating_image")
        {
                    if(str_contains($questionImage, 'data:image'))
                    {
                       $newUrl= self::saveQuestionImage($question->id,$formId,$questionImage);
                    }
                    else
                    {
                        $newUrl=$questionImage;
                    }



                    $image_q=Pictures::whereid($question->picture_id)->first();
                    $image_q->pic_url=$newUrl;
                    $image_q->save();

                    $question->save();

        }

        $question_trans=QuestionTranslation::wherequestion_id($questionId)->wherequestion_local($local)->first();
        $question_trans->question_details=$question_text;
        $question_trans->save();



        return $question;

    }

}
