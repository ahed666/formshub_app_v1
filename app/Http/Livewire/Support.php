<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\SupportTicket;
use App\Models\Kiosk;
use Illuminate\Support\Facades\DB;
use App\Models\Questions;
use App\Models\QuestionTranslation;
use App\Models\Form;
use App\Models\Answers;
use App\Models\Logos;
use App\Models\FormTrnslations;
use App\Models\AnswersTranslation;
use App\Models\QuestionType;
use Storage;
use Illuminate\Support\Facades\File;
use App\Models\Pictures;
use App\Models\CustomQuestionTranslation;
use App\Models\CustomQuestion;
use App\Models\DeviceCode;
use Carbon\Carbon;
use App\Models\Subscribe;
use App\Models\SubscribePlan;
use App\Models\TypeSubscribe;
use App\Models\FrequencyAskedQuestion;
// google translate api
use Stichoza\GoogleTranslate\GoogleTranslate;
use Illuminate\Support\Facades\Auth;
class Support extends Component
{
    public $tickets;
    public $questions;
    public $StatusColors='{
        "Open":"primary_red","Pending":"yellow-400","In Progress":"secondary_blue","Closed":"valid"
    }';



    public function mount(){
        $this->questions=FrequencyAskedQuestion::all();
        $this->tickets=SupportTicket::whereaccount_id(Auth::user()->current_account_id)->orderBy('created_at', 'desc')->get();
        $this->dispatchBrowserEvent('loadedTickets', ['tickets' => $this->tickets]);
        $this->StatusColors=json_decode($this->StatusColors, true);


    }
    public function render()
    {
        return view('livewire.support');
    }
}
