<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
class Questions extends Model
{
    use HasFactory;
    protected $table="questions";
    protected $fillable = [
        'optional',
        'question_order',
        'form_id',
        'question_id',
        'type_of_question_id',

    ];
    // public function answers(): MorphMany
    // {
    //     return $this->morphMany(Answers::class);
    // }
}
