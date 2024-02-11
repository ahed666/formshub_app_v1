<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
// use Illuminate\Validation\Rules;
use Illuminate\Support\Collection;
use Livewire\WithFileUploads;
use App\Models\QuestionType;
use App\Models\Pictures;
use App\Models\Form;
use App\Models\Logos;
use Illuminate\Support\Facades\Auth;
use Storage;
use Illuminate\Support\Facades\File;
class AddForm extends Controller
{
    public function store( Request $request )
    {
        $survey_logo=$request->logo_url;
           $survey_Name=$request->survey_name;
           $survey_BusinessName=$request->survey_bname;
        $logo=new Logos();
        $folderPath ='storage/images/upload/';
        if (!file_exists($folderPath)) {
            mkdir($folderPath, 0777, true);
        }
            if(str_contains($survey_logo,'images/temp/'))
            {
                $numofsurvey=count(Form::whereuser_id(Auth::user()->id)->get());
                $lastsurvey=Form::whereuser_id(Auth::user()->id)->get()->last();
                $image_name="form-logo-".Auth::user()->id.$numofsurvey.$lastsurvey->id;
                $name=$image_name . '.jpg';
                $file = $folderPath .$name;

                $old=public_path($survey_logo);
                $new=$file;
                File::copy($old , $new);
            }
                else
                $new=$survey_logo;

            $logo->logo_url=$new;
            $logo->user_id=Auth::user()->id;

            $logo->logo_name=$survey_BusinessName."-".$survey_Name;
            $logo->save();



        $Form=new Form();
        $Form->survey_name=$survey_Name;
        $Form->business_name=$survey_BusinessName;
        $Form->user_id=Auth::user()->id;
        $Form->logo_id=$logo->id;
        $Form->save();


        return back()->with('success', 'Question posted');

    }


}
