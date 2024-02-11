<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PdfFileTranslation extends Model
{
    use HasFactory;
    protected $table="pdf_files_translations";
    public static $main_lang = '{
        "en": { "id": 1, "code": "en", "name": "English", "trans": "en" },
        "ar": { "id": 2, "code": "ar", "name": "Arabic", "trans": "ar" },
        "ur": { "id": 3, "code": "ur", "name": "Urdu", "trans": "ur" },
        "tl": { "id": 4, "code": "tl", "name": "Tagalog", "trans": "fil" }
     }';
     public static $messages_defult =
        '[
            {"local":"en","signpdf_message":"Please review the document and sign in the box below"},

            {"local":"ar","signpdf_message":"يرجى مراجعة الوثيقة ثم التوقيع في المربع أدناه"},

            {"local":"tl","signpdf_message":"Pakisuri ang dokumento at pagkatapos ay mag-sign in sa kahon sa ibaba"},

            {"local":"ur","signpdf_message":"براہ کرم دستاویز کا جائزہ لیں اور پھر نیچے والے باکس میں سائن ان کریں۔"}

        ]';
    public $messages;

    public static function getMessages($file_id){
        $main_languages = json_decode(self::$main_lang, true);
        $messages=self::wherefile_id($file_id)->get();
       foreach ($messages as $key => $message) {
         $message->language=$main_languages[$message->local ]['name'];
       }

      return $messages->toArray();
    }
    public static function addMessages($file_id){
        $messages= json_decode(self::$messages_defult, true);
          
       foreach ($messages as $key => $message) {
          $newMessage=new PdfFileTranslation();
          $newMessage->message=$message['signpdf_message'];
          $newMessage->local=$message['local'];
          $newMessage->file_id=$file_id;
          $newMessage->save();
       }

    }
}
