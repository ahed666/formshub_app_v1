<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnswersTranslation extends Model
{
    use HasFactory;
    protected $table="answer_translations";


    public static function translateAnswer($answerId, $langCode, $value)
    {

        $answer_trans = new self();
        $answer_trans->answer_local = $langCode;
        $answer_trans->answer_id = $answerId;
        $answer_trans->answer_details =$value;


        $answer_trans->save();
    }
}
