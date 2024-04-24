<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fact extends Model
{
    use HasFactory;
    protected $table="facts";
    public static function increseFactCount ($type){
        $facts= self::first();
        switch ($type) {
            case 'responses':
                $facts->responses_count+=1;
                break;
            case 'signedpdf':
                $facts->signedpdf_count+=1;
                break;
            case 'createdforms':
                $facts->createdforms_count+=1;
                break;
            case 'linkedkiosks':
                $facts->linkedkiosks_count+=1;
                break;


            default:
                # code...
                break;
        }
        $facts->save();
       }
}
