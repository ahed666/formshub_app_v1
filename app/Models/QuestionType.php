<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CategoryType;
class QuestionType extends Model
{
    use HasFactory;
    protected $table="type_of_questions";

    public function categoryType(){
        return $this->belongsTo(CategoryType::class,'category_id');
     }
}
