<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\FaqCategory;
class FrequencyAskedQuestion extends Model
{
    use HasFactory;
    protected $table="frequency_asked_questions";
    public function category()
    {
        return $this->belongsTo(FaqCategory::class);
    }
}
