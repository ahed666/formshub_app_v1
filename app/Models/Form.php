<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Questions;
use App\Models\Pictures;
use App\Models\Answers;
use App\Models\Logos;
use App\Models\FormMedia;
use App\Models\Responses;
use App\Models\FormMediaConfig;
use App\Models\FormTrnslations;
use App\Models\FormType;
use App\Models\ResponsedCustomersInfo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;
use Intervention\Image\ImageManagerStatic as Image;

use App\Models\Account;
class Form extends Model
{
    use HasFactory;
    protected $type="forms";
    protected $fillable = [
        'form_name',
        'business_name',
        'comment',
        'contact_number',
        'user_id',
        'logo_id',
        'customer_info',


    ];
    public static function formsStatus(){
        return self::select(
            DB::raw('CASE WHEN active = 1 THEN "Active" ELSE "Inactive" END AS property'),
            DB::raw('COUNT(*) as count')
        )
        ->groupBy('property')
        ->get();
    }
    public static function formInfo(){
         $formsStatus=self::formsStatus();

         $formsCount=self::all()->count();
         // Create the array
         $responses = [
             'formsStatus' => $formsStatus,

             'formsCount'=>$formsCount
         ];
         return $responses;
    }

    public static function deleteForm($id){
        $form = self::find($id);
        if ($form) {
            try {
            DB::beginTransaction();


        $directoryPath='storage/accounts/account-'.Auth::user()->current_account_id.'/forms/form-'.$id;
        if (File::exists($directoryPath)) {
            File::deleteDirectory($directoryPath);
        }
           $form->delete();
            DB::commit();
            return ['status' => 'success', 'message' => 'form deleted successfully'];

             } catch (Exception $e) {
            // If an exception occurs, rollback the transaction and return an error status
            DB::rollBack();
            return ['status' => 'error', 'message' => 'Failed to delete the form'];
        }

        }
    }
    public static function getAllForms($accountId){
        return  self::join('type_of_forms','type_of_forms.id','=','forms.form_type_id')->where('forms.account_id','=',$accountId)
        ->select('forms.*','type_of_forms.form_type')->get();

    }

    // all forms by type form order
    public static function getAllTypesForms($accountId){
            $types=FormType::all();
            $typesForms=collect();


            foreach ($types as $key => $type) {
                $forms = self::join('type_of_forms', 'type_of_forms.id', '=', 'forms.form_type_id')
                    ->where('type_of_forms.id', '=', $type->id)
                    ->where('forms.account_id', '=', $accountId)
                    ->select('forms.*', 'type_of_forms.form_type')
                    ->get();
                $activeFormsCount = $forms->where('active', true)->count();
                $inactiveFormsCount = $forms->where('active', false)->count();
                $collect = collect([
                    'type' => $type->form_type,
                    'type_id'=>$type->id,
                    'forms' => $forms,
                    'activeFormsCount' => $activeFormsCount,
                    'inactiveFormsCount' => $inactiveFormsCount,
                ]);

                $typesForms->push($collect);
            }

        return  $typesForms;
    }


    // delete forms
    public static function deleteFormsFiles($accountId){
        try
        {

            // forms logo
            $forms=self::whereaccount_id($accountId)->get();
            $formIds = $forms->pluck('id')->toArray();
            $pictureIds = Logos::whereIn('form_id', $formIds)

                    ->where('logo_url', 'LIKE', '%storage/images/upload/%')
                    ->pluck('id')
                    ->toArray();
            $picturePaths = Logos::whereIn('id', $pictureIds)->pluck('logo_url')->toArray();

            File::delete($picturePaths);

            $forms=self::whereaccount_id($accountId)->get();

            foreach ($forms as $key => $form) {
                // media form type
                if($form->form_type_id==2)
                {
                    $media=FormMedia::whereform_id($form->id)->get();
                    foreach ($media as $key => $mediaItem) {
                        File::delete(public_path($mediaItem->path));
                    }

                }
                // custom form type
                else
                {
                    // questions
                    $questions = Questions::where('form_id', $form->id)->get();
                    $questionIds = $questions->pluck('picture_id')->toArray();
                    $pictureIds = Pictures::whereIn('id', $questionIds)
                            ->where('pic_url', 'LIKE', '%storage/images/upload/%')
                            ->pluck('id')
                            ->toArray();
                    $picturePaths = Pictures::whereIn('id', $pictureIds)->pluck('pic_url')->toArray();
                    File::delete($picturePaths);

                    // answers
                    $questions = Questions::where('form_id', $form->id)->whereIn('type_of_question_id', [5, 7,21])->get();
                    foreach ($questions as $key => $question) {


                        $answers=Answers::wherequestion_id($question->id)->get();
                        // delete images of answers
                        $answerIds = $answers->pluck('picture_id')->toArray();
                        $pictureIds = Pictures::whereIn('id', $answerIds)
                            ->whereNotNull('id')
                            ->where('pic_url', 'LIKE', '%storage/images/upload/%')
                            ->pluck('id')
                            ->toArray();
                        // Alternatively, if you want to delete files directly using File::delete
                        $picturePaths = Pictures::whereIn('id', $pictureIds)->pluck('pic_url')->toArray();
                        File::delete($picturePaths);

                        // delete signatures of responses
                        $signaturesPaths=ResponsedCustomersInfo::wherequestion_id($question->id)
                        ->where('answer', 'LIKE', '%storage/images/drawing/%')->get()->pluck('answer')->toArray();
                        File::delete($signaturesPaths);


                    }
                }
                $form->delete();
            }
                    //code...
        }
        catch (\Throwable $th)
        {
                   dd($th);
        }
    }
    // save form image
    public static function saveFormImage($formId,$imageFile){
        try {
            $path='storage/accounts/account-'.Auth::user()->current_account_id.'/forms/form-'.$formId.'/';
            $name="form_image-".$formId.'.jpg';

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

    // edit form
    public static function editForm($formId,$title,$logo){
        $form=Form::findOrFail($formId);
        $form->form_title=$title;
        if(str_contains($logo, 'data:image'))
            {
                $newUrl=self::saveFormImage($form->id,$logo);
            }
            else
            {
                $newUrl=$logo;
            }
        $logoForm=Logos::findOrFail($form->logo_id);
        $logoForm->logo_url=$newUrl;
        $logoForm->logo_name="logo-".$title;
        $logoForm->save();

        $form->logo_id=$logoForm->id;

        $form->save();
        return $form;

    }
    // add form
    public static function addForm($title,$typeId,$logo,$defultLanguages,$messages){

        $user = Auth::user();
        $account = Account::find($user->current_account_id);
        if (Gate::forUser($user)->denies('createForm', $account)) {

               return redirect()->route('forms')->with('error_message','You have reached the maximum limit allowed.');
        }
        else{
            $form = new Form();

            $form->form_title=$title;
            $form->user_id=$user->id;
            $form->account_id=$user->current_account_id;
            $form->form_type_id=$typeId;
            $form->logo_id=null;
            $form->save();

            $form->url=url("/forms/{$form->account_id}/{$form->id}");
            $form->save();

            if(str_contains($logo, 'data:image'))
            {
                $newUrl=self::saveFormImage($form->id,$logo);
            }
            else
            {
                $newUrl=$logo;
            }

            $logoForm=new Logos();
            $logoForm->logo_url=$newUrl;
            $logoForm->form_id=$form->id;
            $logoForm->logo_name="logo-".$title;
            $logoForm->save();

            $form->logo_id=$logoForm->id;
            $form->save();

            self::SetFormConfig($typeId,$form->id,$defultLanguages,$messages);


           return $form;



        }

    }

    public static function SetFormConfig($typeId,$formId,$defultLanguages,$messages){
        if($typeId==1){
            foreach ($defultLanguages as $key => $form_DefultLanguage)
            {
                $message=$messages[$form_DefultLanguage];

                $form_trans=new FormTrnslations();
                $form_trans->form_start_header=$message['start_header'];
                $form_trans->form_start_text=$message['start_text'];
                $form_trans->form_end_header=$message['end_header'];
                $form_trans->form_end_text=$message['end_text'];
                $form_trans->terms=$message['terms'];
                $form_trans->form_id=$formId;
                $form_trans->form_local=$form_DefultLanguage;
                $form_trans->save();


            }
        }
        // if another type
        else
        {
           $formConfig=new  FormMediaConfig();
           $formConfig->form_id=$formId;
           $formConfig->allow_touch=true;
           $formConfig->allow_loop=true;

           $formConfig->save();
        }
    }


}
