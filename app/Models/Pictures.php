<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
class Pictures extends Model
{
    use HasFactory;
    protected $table="pictures";


    public static function createFromAnswer($url, $name)
    {
        $image_ans = new self();
        $image_ans->pic_url = $url;
        $image_ans->pic_name = $name;
        $image_ans->user_id = Auth::user()->id;
        $image_ans->account_id = Auth::user()->current_account_id;
        $image_ans->save();

        return $image_ans;
    }
}
