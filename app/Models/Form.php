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
use App\Models\Form;
use App\Models\FormType;
use App\Models\ResponsedCustomersInfo;
use Illuminate\Support\Facades\File;
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
        return  self::join('type_of_forms','type_of_forms.id','=','forms.form_type_id')->where('forms.account_id','=',$accountId)->
        select('forms.*','type_of_forms.form_type')->get();
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


}
