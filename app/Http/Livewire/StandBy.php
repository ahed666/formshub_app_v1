<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
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
use Illuminate\Support\Facades\File;
use App\Models\Pictures;
use App\Models\CustomQuestionTranslation;
use App\Models\CustomQuestion;
use App\Models\DeviceCode;
use App\Models\Account;
use App\Models\Responses;
use App\Models\ResponsedQuestions;
use App\models\ResponsedCustomersInfo;
use Carbon\Carbon;
use App\Models\Subscribe;
use App\Models\SubscribePlan;
use App\Models\TypeSubscribe;
use App\Models\PdfFile;
use App\Models\SignFile;
use App\Models\PdfFileTranslation;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Notifications\ResponsesWarning;
use App\Notifications\ResponsesZeroWarning;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Jobs\RefreshKiosk;


use \PDF;
use Dompdf\Dompdf;
use setasign\Fpdi\Fpdi;
use Illuminate\Support\Facades\Storage;
class StandBy extends Component
{
    public $deviceinfo;
    public $currentkiosk;
    public $current_formid;
    public $formPdfFile;
    public $current_message;
    public function getListeners()
    {
            return [
                "echo:refresh.{$this->currentkiosk->device_code_id},DeviceRefresh" => 'refreshpage',
                'saveAsPDF' => 'saveAsPDF',
                'timeout'=>'timeOut',


            ];
    }
    public function mount(){
        $this->url=url()->current();

        $this->deviceinfo = explode('/', $this->url);
        $this->currentkiosk=Kiosk::wheredevice_code_id($this->deviceinfo[5])->
        join('standbykiosks_media','devices.standbymedia_id','=','standbykiosks_media.id')->select('devices.*','standbykiosks_media.type','standbykiosks_media.path_file as path')->
        first();


    }
    public function refreshpage($url)
    {

        Redirect::to($url['url']);
        // $this->dispatchBrowserEvent('ReloadPage');
    }
    public function render()
    {
        return view('livewire.stand-by');
    }
}
