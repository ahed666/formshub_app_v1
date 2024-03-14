<?php

namespace App\Http\Livewire;

use Livewire\Component;
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
// google translate api
use Stichoza\GoogleTranslate\GoogleTranslate;
use Illuminate\Support\Facades\Auth;
use App\Notifications\NewTicket;
use App\Models\SupportTicket;
use App\Models\User;
use App\Models\Account;
class AddTicket extends Component
{
    public $subject;
    public $desc;
    public $target="Customer Support";
    public $status="Open";
    public function render()
    {
        return view('livewire.add-ticket');
    }
    public function addticket()
    {
        try {

          $user=User::whereid(Account::whereid(Auth::user()->current_account_id)->first()->user_id)->first();

          $ticket=new SupportTicket();
          $ticket->subject=$this->subject;
          $ticket->description=$this->desc;
          $ticket->target=$this->target;
          $ticket->status=$this->status;
          $ticket->account_id=Auth::user()->current_account_id;

          $ticket->save();

          $user->notify(new NewTicket($ticket));
          $this->dispatchBrowserEvent('saved');

        } catch (\Throwable $th) {
            //throw $th;

        }
    }
    public function resetvalues()
    {
        $this->subject=null;
        $this->desc=null;
        $this->target="Customer Support";
        $this->subject="Open";
    }
}
