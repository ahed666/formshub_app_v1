<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\AnswersTranslation;
class Answers extends Model
{
    use HasFactory;
    protected $table="answers";

    protected $fillable = ['question_id', 'picture_id', 'score', 'conditional', 'terminate', 'hide'];

    public static function createAnswer($questionId, $pictureId, $ans)
    {
        $answer = new self();
        $answer->question_id = $questionId;
        $answer->picture_id = $pictureId;
        $answer->score = $ans['score'];
        $answer->conditional = ($ans['action'] === "Skip");
        $answer->terminate = ($ans['action'] === "End");
        $answer->hide =isset($answer['hide'])?$ans['hide']:false;
        $answer->save();



        return $answer;
    }
    public static function editAnswer(self $answer,$ans)
    {

        $answer->score = $ans['score'];
        $answer->conditional = ($ans['action'] === "Skip");
        $answer->terminate = ($ans['action'] === "End");
        $answer->hide =isset($ans['hide'])?$ans['hide']:false;
        $answer->save();



        return $answer;
    }

}


