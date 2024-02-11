<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use App\Models\PdfFile;
use Carbon\Carbon;

class SignFile extends Model
{
    use HasFactory;
    protected $table="signed_files";


    public static function countFilesPerForm($form_id){
        return self::whereform_id($form_id)->count();;
    }
    public static function getLastSignature($account_id){
      $signature=self::join('pdf_files','pdf_files.id','=','signed_files.pdffile_id')->where('pdf_files.account_id','=',$account_id)->
      select([
        'signed_files.*'
    ])->orderBy('signed_files.created_at','desc')->first();


    return $signature;
    }
    public static function deleteLastSignature($account_id){
        $signature=self::join('pdf_files','pdf_files.id','=','signed_files.pdffile_id')->where('pdf_files.account_id','=',$account_id)->
        select([
          'signed_files.*'
      ])->orderBy('signed_files.created_at','desc')->first();
        try {
            File::delete(public_path($signature->path_file));
             $signature->delete();
        } catch (\Throwable $th) {
            //throw $th;
        }


      }
    public static function deleteFiles($account_id){

        try
        {
            $file=PdfFile::whereaccount_id($account_id)->first();
            $signedFile=self::wherepdffile_id($file->id)->first();
            File::delete(public_path($signedFile->path_file));
            $signedFile->delete();
            $file->delete();

        }
        catch (\Throwable $th) {
            //throw $th;
        }

    }

}
