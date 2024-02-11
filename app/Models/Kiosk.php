<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\DeviceCode;
use App\Models\Pictures;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;

class Kiosk extends Model
{
    use HasFactory;
    protected $table="devices";

//     public static function kioskStatus(){
//         return self::select(
//             DB::raw('CASE WHEN in_service=1 THEN "In Service" ELSE "Out of service" END AS property'),
//             DB::raw('COUNT(*) as count')
//         )
//         ->groupBy('property')
//         ->get();

//   }
  public static function kioskLink(){
    $all=DeviceCode::all()->count();
    $linked=self::all()->count();

    return  [
        'Linked' => $linked,
        'Non Linked' => $all-$linked,
    ];

    }
  public static function kioskInfo(){
    // $kioskStatus=self::kioskStatus();
    $kioskLink=self::kioskLink();
    $kioskCount=DeviceCode::all()->count();
    // Create the array
    $kiosks = [
        // 'kioskStatus' => $kioskStatus,
        'kioskLink'=>$kioskLink,
        'kioskCount'=>$kioskCount
    ];
    return $kiosks;
}

//  get ready kiosks  for signature
    public static function getReadySignatureKiosks($account_id){
       return self::leftJoin('device_codes', 'device_codes.id', '=', 'devices.device_code_id')
    ->where('devices.account_id',$account_id)
        ->where(function ($query) {
            $query->where('devices.form_id', null)
                ->orWhere('devices.form_id', false);
        })
        ->select('devices.*', 'device_codes.device_code as device_code')
        ->get();
    }

    // delete kiosks files and kiosks
    public static function deleteFiles($account_id){
        try {

       $kiosks=self::whereaccount_id($account_id)->get();
       foreach ($kiosks as $key => $kiosk) {
        $pic=Pictures::whereid($kiosk->standbyimage_id)->first();
        
        if(str_contains($pic->pic_url,'storage/images/upload/'))
        File::delete(public_path($pic->pic_url));
        
        $kiosk->delete();


       }
       //code...
    } catch (\Throwable $th) {
        //throw $th;
    }
    }
}
