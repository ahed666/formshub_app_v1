<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kiosk;
use App\Models\DeviceCode;
use App\Models\Form;
use App\Models\FormMedia;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\abort;
use Illuminate\Support\Facades\Auth;

class FormController extends Controller
{

    public function index($code,$device_id){
        try {

            $device=DeviceCode::join('devices_models','devices_models.id','=','device_codes.device_model_id')

            ->where('device_codes.id','=',$device_id)->select('device_codes.*','devices_models.view_name as view')->first();

            if($device)
            {
                $kiosk=Kiosk::where('devices.device_code_id','=',$device_id)->first();

                if($kiosk->form_id!=null)
                {
                    $form=Form::whereid($kiosk->form_id)->first();
                    $type="custom";
                }
                else
                {

                    if($kiosk->form_id==null&&$kiosk->sign_kiosk==true)
                    $type="sign";
                    else
                    $type=null;
                }


             switch ($type) {
                case "custom":
                    return view('form-template',compact('form'));
                    break;
                case "sign":
                    return view('sign_pdf_template');
                    break;
                default:
                    return view('stand_by');
                    break;
             }


            }

            // if($device)
            // return view($device->view);
        //    else type of devices models
        // else{}

        } catch (\Throwable $th) {
            //throw $th;
        }
    }

   public function preview($id){
      $form=Form::whereid($id)->first();
      if($form!=null)
        {  
           if(Auth::user()->current_account_id==$form->account_id)
           {
            $form_type_id=$form->form_type_id; 
             return view('form_template_preview',compact('id','form_type_id'));
           }
           else
           {
               abort(403, 'No permission to access this resource.');

           }
           
        }
        else
            abort(404, 'Not Found');

        
        
       
    


   }

}
