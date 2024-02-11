<?php

namespace App\Http\Livewire\Forms\Previews;

use Livewire\Component;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;
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
use App\Models\FormMedia;
use App\Models\FormMediaConfig;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Notifications\ResponsesWarning;
use App\Notifications\ResponsesZeroWarning;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
class PreviewtemplateFormMedia extends Component
{
    public  $media=[];
    public $deviceinfo;
    public $currentkiosk;
    public $current_formid;
    public $currentForm;
    public $formSettings;
    public function getListeners()
    {
            return [

                'startform'=>'startForm',

            ];
    }
    public function refreshpage($url)
    {

        Redirect::to($url['url']);
    }

    public function mount($id){

        $this->current_formid=$id;

        if($this->current_formid)
        { $this->currentForm=Form::whereid($this->current_formid)->first();
            $this->formSettings=FormMediaConfig::whereform_id($this->current_formid)->first();

        }
    }
    public function startForm()
    {

       $this->getMedia();


    }
    public function getMedia(){
        try {
            //code...

            $allMedia=FormMedia::whereform_id($this->currentForm->id)->wherehide(false)->orderBy('media_order')->get();
            foreach ($allMedia as $i => $media) {

                $path = public_path($media->path);

                if (!file_exists($path)) {

                    abort(404);
                }

                $fileContents = file_get_contents($path);

                $this->media[] =
                ['blob' => base64_encode($fileContents),
                'type'=>$media->type,
                'duration'=>$media->duration,
                 'volume'=>$media->volume,
                'mute'=>(bool)$media->mute,

                ];
            }


            $this->dispatchBrowserEvent('featched',['media'=>$this->media,'FormSettings'=>  $this->formSettings]);
        } catch (\Throwable $th) {

        }


    }
    public function render()
    {
        return view('livewire.forms.previews.previewtemplate-form-media');
    }
}
