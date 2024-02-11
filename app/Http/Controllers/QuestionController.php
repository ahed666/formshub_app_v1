<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
// google translate api
use Stichoza\GoogleTranslate\GoogleTranslate;
class QuestionController extends Controller
{



    public function save(Request $request){
        // foreach ($request->input('answer_ids') as $key => $value) {
        //     dd($value);
        // }

        if ($request->has('question_mandetory')) {
            $question_mandetory = true;
            // $checkboxValue will be "1" if the checkbox is checked
        } else {
            // Checkbox is not checked
            // dd($request->input('question_mandetory'));
            $question_mandetory=false;

        }
        $type=$request->input('type_id');
        $question_id=$request->input('question_id');
        $local=$request->input('local');
        $question_text=$request->input('question_text');
        $answer_ids=$request->input('answer_ids');
        $languages=json_decode($request->input('languages'), true);
        $Question=Questions::find($question_id);
        $form_id=$Question->form_id;
        if($type=='custom_satisfaction'||$type=='custom_rating')
        {
            // mandetory or no questions
            $Question=Questions::find($this->question['id']);
            $Question->optional=!$this->is_mandetory_question;
            $Question->save();
            // delete the answers that its deleted
            for ($i=0; $i <count($this->answersdeleted) ; $i++)
            {
                $answer=Questions::where('questions.id',$this->answersdeleted[$i])

                ->join('custom_questions','custom_questions.question_id','=','Questions.id')
                ->select('Questions.id as q_id','custom_questions.picture_id as picture_id')->first();

                // AnswersTranslation::whereanswer_id($answer['answer_id'])->delete();
                Questions::whereid($answer->q_id)->delete();
                // if answer have image
                if($answer->picture_id!=null)
                {
                $imagepath=Pictures::whereid($answer->picture_id)->first()->pic_url;
                    if(str_contains($imagepath, 'images/temp/')||str_contains($imagepath, 'images/upload/'))
                {
                    File::delete(public_path($imagepath));}
                    Pictures::whereid($answer->picture_id)->delete();}
                Answers::wherequestion_id($this->answersdeleted[$i])->delete();

            }


                $question_trans=CustomQuestionTranslation::join('custom_questions','custom_questions.id','=','custom_question_translations.custom_question_id')
                ->where('custom_questions.question_id','=',$this->question['id'])
                ->where('custom_question_translations.question_local',$this->local)->select('custom_question_translations.*')->first();

                $question_trans->question_details=$this->question_text;
                $Parentquestion=CustomQuestion::wherequestion_id($this->question['id'])->first();
                $question_trans->save();
                $folderPath ='storage/images/upload/';
                if (!file_exists($folderPath)) {
                    mkdir($folderPath, 0777, true);
                }
                //  detect the source of trnslation
                $source="";
                foreach($this->languages as $lang)
                {if($lang['code']==$this->local)
                    {
                    $source=$lang['trans'];
                    }

                }

                //  add child questions

                foreach($this->answers as $ans)

                {
                     if(Questions::find($ans['id']))
                     {
                        $answer=Questions::where('Questions.id',$ans['id'])
                        ->join('custom_questions','custom_questions.question_id','=','Questions.id')
                        ->join('question_translations','question_translations.question_id','=','Questions.id')

                        ->where('question_translations.question_local',$this->local)->select()->first();

                            // if child question  have image
                            if($answer->picture_id!=null)
                            {

                                $image=Pictures::whereid($answer->picture_id)->first();

                                if(str_contains($ans['image'],'images/temp/'))
                                {
                                    $image_name="image-".Auth::user()->id.$ans['value']."-".$answer->question_id;
                                    $name=$image_name . '.jpg';
                                    $file = $folderPath .$name;

                                    $old=public_path($ans['image']);
                                    $new=$file;
                                    File::copy($old , $new);
                                }
                                else
                                $new=$ans['image'];

                                $image->pic_url=$new;

                                $image->save();

                                  // add translation of each child question for each language of form languages
                                  foreach($this->languages as $lang)
                                  {
                                    $child_question_trans=QuestionTranslation::where('question_translations.question_id','=',$answer->question_id)->where('question_translations.question_local','=',$lang['code'])->first();

                                      // if language is same the local language of form
                                    //   if($lang['code']==$this->local)
                                    //   {  $child_question_trans->question_details=$ans['value'];

                                    //   }
                                    //   // if language is not same the local language of form
                                    //   else
                                    //   {
                                    //     //   try {
                                    //     //       $tr = new GoogleTranslate();
                                    //     //   $child_question_trans->question_details=$tr->setSource($source)->setTarget($lang['trans'])->translate($ans['value']);
                                    //     //   } catch (\Throwable $th) {
                                    //     //       $child_question_trans->question_details=$ans['value'];
                                    //     //   }
                                    //   }
                                    $child_question_trans->question_details=$ans['value'];
                                      $child_question_trans->save();
                                  }


                            }
                            // if child question not have image => answer without image
                            else
                            {
                                // add translation of each child question for each language of form languages
                                foreach($this->languages as $lang)
                                {
                                    $child_question_trans=QuestionTranslation::where('questions.id','=',$answer->question_id)->where('question_translations.question_local','=',$lang['code'])->first();
                                    // if language is same the local language of form
                                    // if($lang['code']==$this->local)
                                    // {  $child_question_trans->question_details=$ans['value'];
                                    // }
                                    // // if language is not same the local language of form
                                    // else
                                    // {
                                    //     // try {
                                    //     //     $tr = new GoogleTranslate();
                                    //     // $child_question_trans->question_details=$tr->setSource($source)->setTarget($lang['trans'])->translate($ans['value']);
                                    //     // } catch (\Throwable $th) {
                                    //     //     $child_question_trans->question_details=$ans['value'];
                                    //     // }
                                    //    $child_question_trans->question_details=$ans['value'];

                                    // }
                                    $child_question_trans->question_details=$ans['value'];
                                    $child_question_trans->save();
                                }



                            }
                        // edit answer details score,skip,hide

                        // $Answer=Answers::find($answer->answer_id);

                        // $Answer->score=$ans['score'];
                        // $Answer->conditional=$ans['skip'];
                        // $Answer->hide=$ans['hide'];
                        // $Answer->Save();
                     }
                     else
                     {

                        //  if image is not defult
                        if(str_contains($ans['image'], 'images/temp/'))
                        {
                            $image_name="image-".Auth::user()->id.$ans['value']."-".uniqid();
                            $name=$image_name . '.jpg';
                            $file = $folderPath .$name;
                            $old=public_path($ans['image']);
                            $new=$file;
                            File::copy($old , $new);
                        }
                        // if image is defult
                        else
                        {
                            $new=$ans['image'];
                        }
                        $image_ans=new Pictures();
                        $image_ans->pic_url=$new;
                        $image_ans->pic_name=$ans['value'];
                        $image_ans->user_id=Auth::user()->id;
                        $image_ans->save();
                        // add each question to question table
                        $child_question=new Questions();
                        $child_question->question_order=$this->question['question_order'];
                        $child_question->form_id=$form_id;
                        $child_question->type_of_question_id=QuestionType::wherequestion_type($this->type)->first()->id;
                        $child_question->optional=$this->question['optional'];
                        $child_question->save();
                        // end of add to question table


                        // add translation of each child question for each language of form languages
                        foreach($this->languages as $lang)
                        {
                            $child_question_trans=new QuestionTranslation();
                            // if language is same the local language of form
                            // if($lang['code']==$this->local)
                            // {  $child_question_trans->question_details=$ans['value'];
                            // $child_question_trans->question_local=$lang['code'];
                            // $child_question_trans->question_id=$child_question->id;

                            // }
                            // // if language is not same the local language of form
                            // else
                            // {
                            //     // try {
                            //     //     $tr = new GoogleTranslate();
                            //     // $child_question_trans->question_details=$tr->setSource($source)->setTarget($lang['trans'])->translate($ans['value']);
                            //     // } catch (\Throwable $th) {
                            //     //     $child_question_trans->question_details=$ans['value'];
                            //     // }

                            // $child_question_trans->question_details=$ans['value'];
                            // $child_question_trans->question_local=$lang['code'];
                            // $child_question_trans->question_id=$child_question->id;
                            // }
                            $child_question_trans->question_details=$ans['value'];
                            $child_question_trans->question_local=$lang['code'];
                            $child_question_trans->question_id=$child_question->id;
                            $child_question_trans->save();
                        }
                        //  end of add translation of each child question

                        // add child question to custom question table with custom question id
                        $childcustomquestion=new CustomQuestion();
                        $childcustomquestion->question_id=$child_question->id;
                        $childcustomquestion->custom_question_id=$Parentquestion->id;
                        $childcustomquestion->picture_id=$image_ans->id;
                        $childcustomquestion->save();
                        // end of child question to custom question table with custom question id
                        //  add answers 1->5 rating or satisfaction
                        $answers_text=json_decode($this->answers_json_text_rating, true);
                        $text=null;
                        foreach($answers_text as $i=>$answer_text)
                        $answer_text['custom_type']==$this->type?$text=$answer_text:"";
                        for ($i=0; $i < 5; $i++) {

                            $answer=new Answers();
                            $answer->question_id=$child_question->id;
                            $answer->picture_id=null;
                            $answer->score=$i+1;
                            $answer->save();
                            foreach($this->languages as $lang)
                            {
                                $answer_trans=new AnswersTranslation();
                                $answer_trans->answer_local=$lang['code'];
                                $answer_trans->answer_id=$answer->id;
                                // if($lang['code']=="en")
                                // $answer_trans->answer_details=$text[$i];
                                // else
                                // {
                                //     // try {
                                //     //     $tr = new GoogleTranslate();
                                //     // $answer_trans->answer_details=$tr->setSource("en")->setTarget($lang['trans'])->translate($text[$i]);
                                //     // } catch (\Throwable $th) {
                                //     //     $answer_trans->answer_details=$text[$i];
                                //     // }
                                //  $answer_trans->answer_details=$text[$i];
                                // }
                                $answer_trans->answer_details=$text[$i];
                                $answer_trans->save();
                            }

                        }
                    }

                }


        }
        // if type is another type of custom question
        else
        {
                // mandetory or no questions

                $Question->optional=!$question_mandetory;
                $Question->save();



                $question_trans=QuestionTranslation::wherequestion_id($question_id)->wherequestion_local($local)->first();
                $question_trans->question_details=$question_text;
                $question_trans->save();
                $folderPath ='storage/images/upload/';
                if (!file_exists($folderPath)) {
                    mkdir($folderPath, 0777, true);
                }
                //  detect the source of trnslation
                $source="";
                foreach($languages as $lang)
                {
                    if($lang['code']==$local)
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
                if($type=="yes_no"||$type=="like_dislike"||$type=="Agree_Disagree"||$type=="rating"||$type=="satisfaction")
                {
                    foreach($answer_ids as $ans)

                    { $Answer=Answers::find($ans);

                        $Answer->score=$request->input('answer_score-'.$ans);
                        // skip answer
                        if ($request->has('answer_skip-'.$ans)) {
                            $Answer->conditional=true;

                        } else {

                            $Answer->conditional=false;

                        }

                        // terminate answer
                        if ($request->has('answer_terminate-'.$ans)) {
                            $Answer->terminate=true;

                        } else {

                            $Answer->terminate=false;

                        }
                        // hide answer
                         if ($request->has('answer_hide-'.$ans)) {
                            $Answer->hide=true;

                        } else {

                            $Answer->hide=false;

                        }

                        $Answer->Save();

                    }
                }
                //else another question
                else{

                    // delete the answers that its deleted
                    // *****here****
                    // end  delete

                    foreach($this->answers as $ans)
                    {

                        // if answer is exsist =>edit it

                        if(Answers::find($ans['id']))
                        {
                            $answer=Answers::wherequestion_id($this->question['id'])
                            ->join('answer_translations','answer_translations.answer_id','=','Answers.id')->Where('Answers.id','=',$ans['id'])
                            ->where('answer_translations.answer_local',$this->local)->first();

                            // if answer  have image
                            if($answer->picture_id!=null)
                                {    $image=Pictures::join('answers','pictures.id','=','Answers.picture_id')->where('answers.id','=',$answer->answer_id)->select('pictures.*')->first();

                                    if(str_contains($ans['image'],'images/temp/'))
                                    {
                                        $image_name="image-".Auth::user()->id.$ans['value']."-".$answer->answer_id;
                                        $name=$image_name . '.jpg';
                                        $file = $folderPath .$name;

                                        $old=public_path($ans['image']);
                                        $new=$file;
                                        File::copy($old , $new);
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

                            $Answer=Answers::find($answer->answer_id);

                            $Answer->score=$ans['score'];
                            $Answer->conditional=$ans['skip'];
                            $Answer->terminate=$ans['terminate'];
                            $Answer->hide=$ans['hide'];
                            $Answer->Save();
                        }
                        // if answer is not exsist =>add it
                        else
                        {
                            // if answer  have image
                            if($ans['image']!=null)
                            {
                                if(str_contains($ans['image'], 'images/temp/'))
                                {
                                    $image_name="image-".Auth::user()->id.$ans['value']."-".uniqid();
                                    $name=$image_name . '.jpg';
                                    $file = $folderPath .$name;
                                    $old=public_path($ans['image']);
                                    $new=$file;
                                    File::copy($old , $new);
                                }
                                else
                                {
                                    $new=$ans['image'];

                                }

                                $image_ans=new Pictures();
                                $image_ans->pic_url=$new;
                                $image_ans->pic_name=$ans['value'];
                                $image_ans->user_id=Auth::user()->id;
                                $image_ans->save();
                                $answer=new Answers();
                                $answer->question_id=$this->question['id'];
                                $answer->picture_id=$image_ans->id;
                                $answer->score=$ans['score'];
                                $answer->conditional=$ans['skip'];
                                $answer->terminate=$ans['terminate'];
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
                                $answer->conditional=$ans['skip'];
                                $answer->terminate=$ans['terminate'];
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


        }
        sleep(3);
        return redirect()->route('editform', ['id' => $form_id])->with('success_message','your Question has been edit successfuly');

    }
}
