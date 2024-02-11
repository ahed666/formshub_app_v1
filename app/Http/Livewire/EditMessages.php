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
class EditMessages extends Component
{
    public $header=null;
    public $text=null;
    public $current_message_id=null;
    public $form_id;
    public $type="";
    public $main_languages;
    public $local;
    public $languageNamesByCode;
    public $main_lang = '[
        { "id": 1,"code":"en", "name": "English","trans":"en"},
        { "id": 2,"code":"ar" ,"name": "Arabic","trans":"ar"},
        { "id": 3, "code":"ur","name": "Urdu","trans":"ur"},
        { "id": 4, "code":"tl","name": "Tagalog","trans":"fil"}
    ]';
    protected $listeners = [
        'edit_message'=>'editingmessage'
    ];
     // validation rules
     protected $rules=[
        'header' => 'required',
        'text' => 'required',

    ];
    // error messages
    protected $messages=[
        'header.required' => 'the header cannot be empty.',
        'text.required' => 'the message cannot be empty.',

    ];
    public function editingmessage($type,$message)
    {

        $this->type=$type;
        $this->current_message_id=$message['id'];
        $this->local=$message['form_local'];
        $this->form_id=$message['form_id'];

        if($this->type=='Start')
        {
            $this->header=$message['form_start_header'];
            $this->text=$message['form_start_text'];
        }
        else
        {
            $this->header=$message['form_end_header'];
            $this->text=$message['form_end_text'];
        }
        $this->main_languages = json_decode($this->main_lang, true);
        $this->languageNamesByCode = array_column($this->main_languages, 'name', 'code');
        $this->dispatchBrowserEvent('loadmessage',['header'=>$this->header,'text'=>$this->text]);



    }
    public function render()
    {
        return view('livewire.edit-messages');
    }
    public function resetvalue()
    {
        $this->header=null;
        $this->text=null;
        $this->current_message_id=null;

        $this->type=null;
    }
    public function edit($formData)
    {
        $this->header=$formData['header_message'];
        $this->text=$formData['text_message'];
        $this->validateOnly('header');
        $this->validateOnly('text');

        $form_trans=FormTrnslations::find($this->current_message_id);
        if($this->type=='Start')
        {
        $form_trans->form_start_header=$formData['header_message'];
        $form_trans->form_start_text=$formData['text_message'];
        $form_trans->save();
        }
        else
        {
        $form_trans->form_end_header=$formData['header_message'];
        $form_trans->form_end_text=$formData['text_message'];
        $form_trans->save();
        }
        $this->resetvalue();
        // emit if message edit success
        //  to enable updating of form on each change or action
        $form=Form::whereid($this->form_id)->first();
        $form->updating=true;$form->save();
        return redirect()->route('editform', ['id' => $this->form_id,'lastLocal'=>$this->local])->with('success_message','your question has been added successfuly');
    }
}
