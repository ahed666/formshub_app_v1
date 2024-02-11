<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Answers;
use App\Models\AnswersTranslation;
use App\Models\CustomQuestion;
use App\Models\Kiosk;
use App\Models\Logos;
use App\Models\Pictures;
use App\Models\Questions;
use App\Models\QuestionTranslation;
use App\Models\QuestionType;
use App\Models\Form;
use App\Models\FormTrnslations;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use App\Events\DeviceRefresh;
// google translate api
use Stichoza\GoogleTranslate\GoogleTranslate;
class Formterms extends Component
{
    public $current_message_id=null;
    public $form_id;
    public $terms=null;
    public $local;
    public $add=false;
    public $main_languages;
    public $languageNamesByCode;
    public $main_lang = '[
        { "id": 1,"code":"en", "name": "English","trans":"en"},
        { "id": 2,"code":"ar" ,"name": "Arabic","trans":"ar"},
        { "id": 3, "code":"ur","name": "Urdu","trans":"ur"},
        { "id": 4, "code":"tl","name": "Tagalog","trans":"fil"}
    ]';
     // validation rules
     protected $rules=[
        'terms' => 'required|min:6',

    ];
    // error messages
    protected $messages=[
        'terms.required' => 'the terms & conditions cannot be empty.',
        'terms.min' => 'length of terms & conditions cannot be less of 6 characters',

    ];
    protected $listeners = [
        'edit_terms'=>'editingterms',
        'add_terms'=>'addterms',

     ];
     public function mount(){
        $this->main_languages = json_decode($this->main_lang, true);
        $this->languageNamesByCode = array_column($this->main_languages, 'name', 'code');
     }
    //  edit terms
    public function editingterms($message)
    {


        $this->current_message_id=$message['id'];
        $this->local=FormTrnslations::whereid($this->current_message_id)->first()->form_local;
        $this->form_id=$message['form_id'];
        $this->terms=$message['terms'];
        $this->dispatchBrowserEvent('loadterms',['terms'=>$this->terms]);



        }
    // add terms

    public function addterms($message)
    {


        $this->current_message_id=$message['id'];
        $this->local=FormTrnslations::whereid($this->current_message_id)->first()->form_local;
        $this->form_id=$message['form_id'];
        $this->add=true;


        // $this->terms=$message['terms'];
    }
    // get locales of form
    public function getLocalesOfForm($id)
    {
        $locales = FormTrnslations::
            where('form_id', '=', $id)->
            select('form_translations.form_local As local')->get();
        $locales = json_decode($locales, true);
        $formlocales = [];
        foreach ($locales as $i => $local) {foreach ($this->main_languages as $main) {
            if ($local['local'] == $main['code']) {
                $collect = collect(
                    ["id" => $main['id'],
                        "code" => $local['local'],
                        "name" => $main['name'],
                        "trans" => $main['trans'],

                    ]
                );

                array_push($formlocales, $collect);
            }
        }

        }

        return $formlocales;

    }
    public function resetvalue()
    {
        $this->current_message_id=null;

        $this->terms=null;
        $this->add=false;
    }
    public function save($formData)
    {
        //  validate
        $this->terms=$formData['terms'];
      
        $this->validateOnly('terms');
        // add terms
        if($this->add==true)
        {
            $formlanguages = $this->getLocalesOfForm( $this->form_id);

            foreach($formlanguages as $lang)
            {
                $form_trans=FormTrnslations::whereform_id($this->form_id)->whereform_local($lang['code'])->first();

                if($lang['code']==$this->local)
                {
                $form_trans->terms=$formData['terms'];

                }
                else
                {
                    try {
                        $tr = new GoogleTranslate();
                        $form_trans->terms= $tr->setSource($this->local)->setTarget($lang['code'])->translate($formData['terms']);
                    } catch (\Throwable $th) {

                        $form_trans->terms=$formData['terms'];
                    }
                }
                $form_trans->save();
            }


        }
        // edit terms
        else
        {
            $form_trans=FormTrnslations::find($this->current_message_id);
            $form_trans->terms=$formData['terms'];
            $form_trans->save();

        }
           // update updating status of form
            $form=Form::whereid($this->form_id)->first();
            $form->updating=true;
            $form->save();
            // emit if terms edit success

            $this->resetvalue();
            return redirect()->route('editform', ['id' => $this->form_id,'lastLocal'=>$this->local])->with('success_message','your question has been added successfuly');

    }
    public function render()
    {
        return view('livewire.formterms');
    }
}
