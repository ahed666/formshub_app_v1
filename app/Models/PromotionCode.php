<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PromotionCode extends Model
{
    use HasFactory;
    protected $table="promotion_codes";
    protected $fillable = ['code', 'use_type', 'valid', 'public', 'discount_value','note'];

      /**
     * Toggle the validity of the promotion code.
     *
     * @return bool
     */
    public function toggleValid()
    {
        $this->valid = !$this->valid;
        return $this->save();
    }

    /**
     * Find a promotion code by its code.
     *
     * @param string $code
     * @return \App\Models\PromotionCode|null
     */
    public static function findByCode(string $code)
    {
        return PromotionCode::where('code', $code)->first();
    }

    /**
         * Find a promotion code by its code.
         *
         * @param int $codeText
         * @return \App\Models\PromotionCode|error
         */

    public static function checkCode(string $codeText,$use_type=null){
         // check if code exsist
         if($code=self::findByCode($codeText))
         {

         // yes
             // check on valid

             if($code->valid)
             // yes
             {
                 // check on use type
                 if($code->use_type==$use_type)  //buyresponses //upgrade //renew
                 // yes
                 {
                     // check if public
                     if($code->public)
                     // yes
                     {
                            return $code;
                     }
                     // no
                     else{
                         // check if used or not
                         if($code->used>0)
                         // yes
                         {

                            return response()->json(['error' =>trans('main.codenotvalid')], 422);
                         }
                         // no
                         {

                            return $code;
                         }
                     }
                 }
                 else{
                    return response()->json(['error' =>trans('main.codenotvalid')], 422);
                 }
             }

             // no
             else{
                return response()->json(['error' =>trans('main.codenotvalid')], 422);
             }
         }

         // no
         else{
            return response()->json(['error' =>trans('main.codenotvalid')], 422);
         }
    }
}
