<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LanguagesController extends Controller
{


   public function addLang($form_id,$code){
     redirect()->route('editform', ['id' => $form_id]);

   }

}
