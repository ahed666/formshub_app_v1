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
use Carbon\Carbon;
use Intervention\Image\ImageManagerStatic as Image;
class QuestionController extends Controller
{


    public function saveimage($image){

        $folderPath = public_path('storage/images/upload/');
        if (!file_exists($folderPath)) {
            mkdir($folderPath, 0777, true);
        }
        $image_parts = explode(";base64,", $image);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);
        $image = Image::make($image_base64); // Use Intervention Image to handle the image




        $name=Auth::user()->id.uniqid().Carbon::now()->format('YmdHis').'.jpg';
        $file = $folderPath .$name;

        $image->save($file, 100); // The quality is set to 100 for high resolution




    }
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
    public function save(Request $request){
       $data=$request->all();
       dd($data);
       $answers=$request->input('answers');

       $formId=$request->input('formid');
       $questionType=$request->input('questiontype');
       $questionMandetory=$request->input('questionMandetory');
       $questionImage=$request->input('questionimage');
       $local=$request->input('local');
       $languages=json_decode($request->input('languages'), true);
       $questionText=$request->input('questionText');
       $Question=Questions::createQuestion($questionMandetory,$formId,$questionType,$questionImage,$languages,$questionText);

       if($questionType=="checkbox_pic"||$questionType=="checkbox"||$questionType=="mcq_pic"||$questionType=="mcq"||$questionType=="list")

       {

        if($questionType=='checkbox_pic'||$questionType=='mcq_pic')
        {
            foreach($data['answers'] as $i => &$answer)
            {
                if ($request->hasFile('answers.'.$i.'.image') && $request->file('answers.'.$i.'.image') instanceof \Illuminate\Http\UploadedFile)
                  {

                    $path='storage/accounts/account-'.Auth::user()->current_account_id.'/form-'.$formId.'/answers'.'/question-'.$Question->id;
                    $name="answer_image-".$Question->id.uniqid().$i.Auth::user()->id.Carbon::now()->format('YmdHis');
                    $answers[$i]['imagePath'] =  $request->file('answers.'.$i.'.image')->storeAs($path,$name.'.jpg','public');

                  }
                  else
                  {
                    $answers[$i]['imagePath']='images/default_answer_image.png';
                  }

            }


        }
        else{
            foreach($answers as $i => $answer)
            {
                    $answer['imagePath']=null;
            }
        }

        $Question->addNewAnswers($Question->id,$questionType,$formId,$answers,$languages,$local,null);


       }
       // if there another type of question
       else

       {
          $answersText=$this->loadJsonData($questionType);

           $Question->addNewAnswers($Question->id,$questionType,$formId,$answers,$languages,$local, $answersText);
       }





       return redirect()->route('editform', ['id' => $formId,'lastLocal'=>$local])->with('success_message','your question has been added successfuly');

    }


    public function getAnswerBlock($index)
    {
        $Chars =["A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z",
        "AA","AB","AC","AD","AE","AF","AG","AH","AI","AJ","AK","AL","AM","AN","AO","AP","AQ","AR","AS","AT","AU","AV","AW","AX","AY","AZ"
    ];
        $question_image = 'images/default_answer_image.png'; // Provide a default image path or handle dynamically

        return view('partials.answer-block', compact('index', 'Chars', 'question_image'));
    }
}
