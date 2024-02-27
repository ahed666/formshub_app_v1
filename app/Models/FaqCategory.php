<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\FrequencyAskedQuestion;

class FaqCategory extends Model
{
    use HasFactory;
    protected $table="faq_categories";

    public function questions()
    {
        return $this->hasMany(FrequencyAskedQuestion::class);
    }
}
