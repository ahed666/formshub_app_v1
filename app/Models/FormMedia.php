<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Answers;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManagerStatic as Image;

class FormMedia extends Model
{
    use HasFactory;
    protected $table="form_media";


    public static function saveFormMediaData($itemData,$formId,$itemId,$type){
        $path='storage/accounts/account-'.Auth::user()->current_account_id.'/forms/form-'.$formId.'/media';
        if (!file_exists($path)) {
            mkdir($path, 666, true);
        }
         if($type=='video')
         {
            $name="/mediaitem-".$itemId.'.mp4';
            $newUrl = $itemData->storeAs($path, $name);
            return [$newUrl,$path];

         }
         elseif($type=='image')
         {
            $name="mediaitem-".$itemId.'.jpg';
            $newUrl = $path .$name;
            $image_parts = explode(";base64,", $itemData);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);
            $image = Image::make($image_base64); // Use Intervention Image to handle the image
            $image->save($newUrl, 100);
            return [$newUrl,$path];
         }
    }

    public static function saveMediaItem($itemData,$formId,$type,$duration){

        $formMedia = new FormMedia();
        $formMedia->form_id = $formId;
        $formMedia->file_name ='';
        $formMedia->path ='';
        $formMedia->type = $type;
        $formMedia->duration = $duration;
        $formMedia->media_order = count(FormMedia::whereform_id($formId)->get()) + 1;
        $formMedia->save();
        $datasave=self::saveFormMediaData($itemData,$formId,$formMedia->id,$type);
        $formMedia->file_name =$datasave[1];
        $formMedia->path =$datasave[0];
        $formMedia->save();
        return $formMedia;
    }
}
