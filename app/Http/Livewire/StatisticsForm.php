<?php

namespace App\Http\Livewire;

use App\Models\Logos;
use App\Models\Pictures;
use App\Models\Questions;
use App\Models\QuestionTranslation;
use App\Models\QuestionType;
use App\Models\Form;
use App\Models\FormTrnslations;
use Livewire\Component;
use App\Models\Responses;
use App\Models\Kiosk;
use App\Models\ResponsedQuestions;
use App\models\ResponsedCustomersInfo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Answers;
use App\Models\AnswersTranslation;
use Illuminate\Support\Facades\File;
use App\Models\CustomQuestionTranslation;
use App\Models\CustomQuestion;
use App\Models\DeviceCode;
use App\Models\Account;
use App\Models\AccountUser;
use Carbon\Carbon;
use App\Models\ToDo;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Redirect;
use Laravel\Jetstream\Jetstream;
class StatisticsForm extends Component
{
    public $totalresponses;
    public $status;
    public $completPercent;
    public $totaltodos;
    public $totalresponses_kiosks;
    public $current_form_id;
    public $current_form;
    public $responsesdates;
    public $numofresponses;
    public $numofresponsesfordevices;
    public $devices;
    public $startdate;
    public $enddate;
    public $mindate;
    public $maxdate;
    public $averagescore;
    public $formquestions;
    public $formlanguages;
    public $language;
    public $allresponses=[];
     public $type;
     public $canceledResponsesNum;
    public $startDateOfResponse='2023-01-01';
    public $endDateOfResponse='2023-01-01';
    public $main_lang = '[
        { "id": 1,"code":"en", "name": "English","trans":"en"},
        { "id": 2,"code":"ar" ,"name": "Arabic","trans":"ar"},
        { "id": 3, "code":"ur","name": "Urdu","trans":"ur"},
        { "id": 4, "code":"tl","name": "Tagalog","trans":"fil"}
    ]';
    public $languages;


    //  when click on refresh button
    public function refreshdata(){
        // $this->render();
        if($this->type=="all-responses")
        $this->emit('refreshdataallresponses');
        elseif($this->type=="questions-statistics")
        $this->emit('refreshdataallquestions',$this->current_form_id);
        elseif($this->type=="overview")
        {;$this->emit('refreshoverviewdata',$this->current_form_id);}

        $this->totalresponses=count(Responses::whereform_id($this->current_form_id)->get());
        $totalscores=Responses::whereform_id($this->current_form_id)->select(DB::raw('SUM(`score`) as score'))->first()->score;
        $this->completPercent=Responses::whereform_id($this->current_form_id)->average('complet_percent');
        $this->totaltodos= ToDo::Todos($this->current_form_id);
        $this->averagescore=$this->totalresponses>0?$totalscores/$this->totalresponses:0;
        $this->status=(bool)Form::whereid($this->current_form_id)->first()->active;
        $this->current_form=Form::whereid($this->current_form_id)->first();
        $this->totalresponses_kiosks=count(Responses::whereform_id($this->current_form_id)->whereNotNull('responses.response_source')->get());
        // $responses=Responses::whereform_id($this->current_form_id)->whereBetween('reviewed_at', [DATE($this->startDateOfResponse),DATE($this->endDateOfResponse)])->select(DB::raw('DATE(`reviewed_at`) as date'), DB::raw('count(*) as total'))->groupBy('date')->get();

         // foreach ($responses as $key => $response) {
        //     $this->responsesdates[$key]=$response->date;
        //     $this->numofresponses[$key]=$response->total;
        // }
        $responses=Responses::whereform_id($this->current_form_id)->select(DB::raw('DATE(`reviewed_at`) as date'), DB::raw('count(*) as total'))->groupBy('date')->get();

       if(count($responses)==0){}
       else{
        foreach ($responses as $key => $response) {
            $this->responsesdates[$key]=$response->date;
        }

        $this->startDateOfResponse=min($this->responsesdates);
        $this->endDateOfResponse=max($this->responsesdates);
        $this->mindate=min($this->responsesdates);
        $this->maxdate=max($this->responsesdates);
        // $this->endDateOfResponse = strtotime($this->endDateOfResponse. ' +1 day');
        // $this->endDateOfResponse = date('Y-m-d',$this->endDateOfResponse);


        // call responses/dates function
        $this->responses_dates($this->startDateOfResponse,$this->endDateOfResponse);
        // call responses/devices function
        $this->responses_devices();
        $this->dispatchBrowserEvent('reinitialchart',['responsesdates'=>$this->responsesdates,'numofresponses'=>$this->numofresponses]);


    }
    }


    public function mount(){

        $url=url()->current();
        $forminfo = explode('/', $url);
        $this->current_form_id=$forminfo[5];
        $this->type=$forminfo[4];
        $this->totalresponses=count(Responses::whereform_id($this->current_form_id)->get());
        $totalscores=Responses::whereform_id($this->current_form_id)->select(DB::raw('SUM(`score`) as score'))->first()->score;
        $this->completPercent=Responses::whereform_id($this->current_form_id)->average('complet_percent');
        $this->totaltodos= ToDo::Todos($this->current_form_id);
        $this->averagescore=$this->totalresponses>0?$totalscores/$this->totalresponses:0;
        $this->status=(bool)Form::whereid($this->current_form_id)->first()->active;
        $this->current_form=Form::whereid($this->current_form_id)->first();
        $this->totalresponses_kiosks=count(Responses::whereform_id($this->current_form_id)->whereNotNull('responses.response_source')->get());
         $this->canceledResponses();
        // $responses=Responses::whereform_id($this->current_form_id)->whereBetween('reviewed_at', [DATE($this->startDateOfResponse),DATE($this->endDateOfResponse)])->select(DB::raw('DATE(`reviewed_at`) as date'), DB::raw('count(*) as total'))->groupBy('date')->get();

         // foreach ($responses as $key => $response) {
        //     $this->responsesdates[$key]=$response->date;
        //     $this->numofresponses[$key]=$response->total;
        // }
        $responses=Responses::whereform_id($this->current_form_id)->select(DB::raw('DATE(`reviewed_at`) as date'), DB::raw('count(*) as total'))->groupBy('date')->get();

       if(count($responses)==0){}
       else{
        foreach ($responses as $key => $response) {
            $this->responsesdates[$key]=$response->date;
        }

        $this->startDateOfResponse=min($this->responsesdates);
        $this->endDateOfResponse=max($this->responsesdates);
        $this->mindate=min($this->responsesdates);
        $this->maxdate=max($this->responsesdates);
        // $this->endDateOfResponse = strtotime($this->endDateOfResponse. ' +1 day');
        // $this->endDateOfResponse = date('Y-m-d',$this->endDateOfResponse);


        // call responses/dates function
        $this->responses_dates($this->startDateOfResponse,$this->endDateOfResponse);
        // call responses/devices function
        $this->responses_devices();

        }








    }

    // updatedstartdate =>set start date of responses/dates charts

    public function updatedstartdate(){
        $this->responses_dates($this->startdate,null);
        $this->dispatchBrowserEvent('reinitialchart',['responsesdates'=>$this->responsesdates,'numofresponses'=>$this->numofresponses]);
    }
    // updatedenddate =>set end date of responses/dates charts
    public function updatedenddate(){
        $this->responses_dates(null,$this->enddate);
        $this->dispatchBrowserEvent('reinitialchart',['responsesdates'=>$this->responsesdates,'numofresponses'=>$this->numofresponses]);

    }
    // responses/dates function --- initialization data for responses/dates charts
    public function responses_dates($start,$end){

        $start==null?$start=$this->startDateOfResponse:$start=$start;
        $end==null?$end=$this->endDateOfResponse:$end=$end;
        $this->startDateOfResponse=$start;
        $this->endDateOfResponse=$end;
        $this->responsesdates=[];
        $this->numofresponses=[];

        $dates=$this->getBetweenDates($start, $end);
        $this->numofresponses=array_fill(0, count($dates),0);
        for ($i=0; $i <count($dates) ; $i++) {
            $res=Responses::whereform_id($this->current_form_id)->where(DB::raw('DATE(`reviewed_at`)'),DATE($dates[$i]))
            ->select('responses.*')->get();
            $this->responsesdates[$i]=$dates[$i];
            $this->numofresponses[$i]=count($res);
        }

    }
    // responses/devices function --- initialization data for responses/devices chart
    public function responses_devices(){
        $responsesperdevices=Responses::where('responses.form_id','=',$this->current_form_id)
        ->leftjoin('devices','devices.device_code_id','=','responses.response_source')
        ->
        select('devices.device_name as device_name','devices.device_code_id','responses.response_source', DB::raw('count(*) as total'))->groupBy('responses.response_source')->get();
        $this->numofresponsesfordevices=[];

        $this->devices=[];
        // $share_key;
        // $others_key;
        $this->devices[0]="Share";$this->numofresponsesfordevices[0]=0;
        $this->devices[1]="Others";$this->numofresponsesfordevices[1]=0;
        $i=2;
        foreach ($responsesperdevices as $key => $response) {
            // share
            if($response->device_name==null&&$response->response_source==null)
            {
                 $this->numofresponsesfordevices[0]+=$response->total;
            }
            // not share but deleted device
            else if($response->device_name==null&&$response->response_source!=null)
            {
                $this->numofresponsesfordevices[1]+=$response->total;
            }
            else
            {
                $this->devices[$i]=$response->device_name;
                $this->numofresponsesfordevices[$i]=$response->total;
            }

        }
    }

    // return array of dates between tow dates
    public function getBetweenDates($startDate, $endDate) {
        $rangArray = [];

        $startDate = strtotime($startDate);
        $endDate = strtotime($endDate);

        for ($currentDate = $startDate; $currentDate <= $endDate; $currentDate += (86400)) {
            $date = date('Y-m-d', $currentDate);
            $rangArray[] = $date;
        }

        return $rangArray;
    }
    // count of canceled responses
    public function canceledResponses(){
    $responses = Responses::where('form_id', $this->current_form_id)
    ->whereDoesntHave('questions')
    ->whereDoesntHave('customersInfo')->get();
    $this->canceledResponsesNum=count($responses);


    }
    public function render()
    {
        return view('livewire.statistics-form');
    }
}
