<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\QuestionType;
class CategoryType extends Model
{
    use HasFactory;
    protected $table="category_types";

     public function questionTypes(){
        return $this->hasMany(QuestionType::class,'category_id');
     }
     public function enabledQuestionTypes()
     {
         return $this->hasMany(QuestionType::class, 'category_id')->where('enable', true);
     }
}
