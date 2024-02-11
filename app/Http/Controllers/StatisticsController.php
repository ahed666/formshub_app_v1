<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Form;
class StatisticsController extends Controller
{
    public function overview($id)
    {
        $form=Form::whereid($id)->first();
        if( $form)
        {
            if(Auth::user()->current_account_id==$form->account_id&&$form->form_type_id==1)
            return view('statistics');
            else
            abort(403, 'Unauthorized action.');
        }
        else
        abort(403, 'Unauthorized action.');
    }

    public function questionsStatistics($id)
    {

        $form=Form::whereid($id)->first();
        if( $form)
        {
            if(Auth::user()->current_account_id==$form->account_id&&$form->form_type_id==1)
            return view('statistics');
            else
            abort(403, 'Unauthorized action.');
        }
        else
        abort(403, 'Unauthorized action.');
    }

    public function allResponses($id)
    {

        $form=Form::whereid($id)->first();
        if( $form)
        {
            if(Auth::user()->current_account_id==$form->account_id&&$form->form_type_id==1)
            return view('statistics');
            else
            abort(403, 'Unauthorized action.');
        }
    else
    abort(403, 'Unauthorized action.');
    }


}
