<?php

namespace App\Http\Livewire;
use App\Models\Logos;
use App\Models\Pictures;
use App\Models\Questions;
use App\Models\QuestionTranslation;
use App\Models\QuestionType;
use App\Models\Form;
use App\Models\FormMedia;
use App\Models\FormTrnslations;
use Livewire\Component;
use App\Models\Responses;
use App\Models\ResponsedQuestions;
use App\models\ResponsedCustomersInfo;
use Illuminate\Support\Facades\Auth;
use App\Models\TypeSubscribe;
use App\Models\SubscribePlan;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use App\Models\Kiosk;
use App\Models\FormType;
use App\Models\SignFile;
use App\Events\DeviceRefresh;
use App\Jobs\RefreshKiosk;
use App\Jobs\RefreshKiosks;
class Allforms extends Component
{
    public $form_delete_id;
    public $forms;
    public $typesForms;

    public $responses;
    public $totalresponses=0;
    public $totalresponses_kiosks=0;
    public $totalforms=0;

    public $main_languages;
    public $totalactiveforms=0;
    public $active;
    public $current_subscribe;
    public $disabledForms;
    public $enableFormsNum;
    public $validAccount;
    public $accountStatus;
    public $current_subscribe_id;
    public $current_subscribe_type;
    protected $listeners=[
     "deleted"=>"deletenow",
     "formaddsuccess"=>"formaddsuccess",
     "unlink"=>"unlinkKiosks",
    ];
    public $responses_svg='<!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">
    <!-- Uploaded to: SVG Repo, www.svgrepo.com, Transformed by: SVG Repo Mixer Tools -->
    <svg class="w-6 h-6 xs:w-3 xs:h-3" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="-83.3 -83.3 656.60 656.60" xml:space="preserve" width="800px" height="800px">
    <g id="SVGRepo_bgCarrier" stroke-width="0"/>
    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>
    <g id="SVGRepo_iconCarrier"> <g> <g> <g> <path d="M450,0h-410c-22.056,0-40,17.944-40,40v280c0,22.056,17.944,40,40,40h235v120c0,4.118,2.524,7.814,6.358,9.314 c1.184,0.463,2.417,0.687,3.639,0.687c2.738,0,5.42-1.126,7.35-3.218L409.38,360H450c22.056,0,40-17.944,40-40V40 C490,17.944,472.057,0,450,0z M470,320c0,11.028-8.972,20-20,20h-45c-2.791,0-5.455,1.167-7.348,3.217L295,454.423V350 c0-5.523-4.477-10-10-10h-245c-11.028,0-20-8.972-20-20V40c0-11.028,8.972-20,20-20h410c11.028,0,20,8.972,20,20V320z"/> <path d="M144.881,80.001c-3.957,0.047-7.513,2.423-9.072,6.06l-75,175l18.383,7.878L106.594,205h79.982l29.329,64.158 l18.189-8.315l-80-175C152.45,82.244,148.863,79.974,144.881,80.001z M115.167,185l30.129-70.302L177.433,185H115.167z"/> <rect x="255.001" y="115" width="80" height="20"/> <rect x="350" y="115" width="60" height="20"/> <rect x="255.001" y="165" width="180" height="20"/> <rect x="255.001" y="215" width="75" height="20"/> </g> </g> </g> </g>
    </svg>';
    public $formage_svg='<!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">
    <!-- Uploaded to: SVG Repo, www.svgrepo.com, Transformed by: SVG Repo Mixer Tools -->
    <svg fill="#000000" class="w-6 h-6 xs:w-3 xs:h-3" viewBox="-2.64 -2.64 29.28 29.28" xmlns="http://www.w3.org/2000/svg">
    <g id="SVGRepo_bgCarrier" stroke-width="0"/>
    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>
    <g id="SVGRepo_iconCarrier">
    <path d="M20,3a1,1,0,0,0,0-2H4A1,1,0,0,0,4,3H5.049c.146,1.836.743,5.75,3.194,8-2.585,2.511-3.111,7.734-3.216,10H4a1,1,0,0,0,0,2H20a1,1,0,0,0,0-2H18.973c-.105-2.264-.631-7.487-3.216-10,2.451-2.252,3.048-6.166,3.194-8Zm-6.42,7.126a1,1,0,0,0,.035,1.767c2.437,1.228,3.2,6.311,3.355,9.107H7.03c.151-2.8.918-7.879,3.355-9.107a1,1,0,0,0,.035-1.767C7.881,8.717,7.227,4.844,7.058,3h9.884C16.773,4.844,16.119,8.717,13.58,10.126ZM12,13s3,2.4,3,3.6V20H9V16.6C9,15.4,12,13,12,13Z"/>
    </g>
    </svg>';
    public $media_svg='
    <?xml version="1.0" encoding="utf-8"?><!-- Uploaded to: SVG Repo, www.svgrepo.com, Generator: SVG Repo Mixer Tools -->
    <svg  class="w-6 h-6 xs:w-3 xs:h-3" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path fill-rule="evenodd" clip-rule="evenodd" d="M10 1C9.73478 1 9.48043 1.10536 9.29289 1.29289L3.29289 7.29289C3.10536 7.48043 3 7.73478 3 8V20C3 21.6569 4.34315 23 6 23H8C8.55228 23 9 22.5523 9 22C9 21.4477 8.55228 21 8 21H6C5.44772 21 5 20.5523 5 20V9H10C10.5523 9 11 8.55228 11 8V3H18C18.5523 3 19 3.44772 19 4V7C19 7.55228 19.4477 8 20 8C20.5523 8 21 7.55228 21 7V4C21 2.34315 19.6569 1 18 1H10ZM9 7H6.41421L9 4.41421V7ZM12 17C12 14.2386 14.2386 12 17 12C19.7614 12 22 14.2386 22 17C22 19.7614 19.7614 22 17 22C14.2386 22 12 19.7614 12 17ZM17 10C13.134 10 10 13.134 10 17C10 20.866 13.134 24 17 24C20.866 24 24 20.866 24 17C24 13.134 20.866 10 17 10ZM16.5547 14.1679C16.2478 13.9634 15.8533 13.9443 15.5281 14.1183C15.203 14.2923 15 14.6312 15 15V19C15 19.3688 15.203 19.7077 15.5281 19.8817C15.8533 20.0557 16.2478 20.0366 16.5547 19.8321L19.5547 17.8321C19.8329 17.6466 20 17.3344 20 17C20 16.6656 19.8329 16.3534 19.5547 16.1679L16.5547 14.1679Z" fill="#000000"/>
    </svg>
    ';

    public $errors_permission='
    {
        "Free":{"num_forms":"You have reached the maximum limit allowed.","num_questions":"You have reached the maximum limit allowed.","num_responses":"You have reached the maximum limit allowed.","num_kiosks":"You have reached the maximum limit allowed."},
        "Basic":{"num_forms":"You have reached the maximum limit allowed.","num_questions":"You have reached the maximum limit allowed.","num_responses":"You have reached the maximum limit allowed.","num_kiosks":"You have reached the maximum limit allowed."},
        "Premium":{"num_forms":"You have reached the maximum limit allowed.","num_questions":"You have reached the maximum limit allowed.","num_responses":"You have reached the maximum limit allowed.","num_kiosks":"You have reached the maximum limit allowed."},
        "Professional":{"num_forms":"You have reached the maximum limit allowed.","num_questions":"You have reached the maximum limit allowed.","num_responses":"You have reached the maximum limit allowed.","num_kiosks":"You have reached the maximum limit allowed."},
        "Ultimate":{"num_forms":"You have reached the maximum limit allowed.","num_questions":"You have reached the maximum limit allowed.","num_responses":"You have reached the maximum limit allowed.","num_kiosks":"You have reached the maximum limit allowed."}
    }
    ';

   public $plansPermissions;
   public $plansPermissionsErrors;



    public $messages;
    public $lang =
    '[
    { "id": 1,"code":"en", "name": "English"},
    { "id": 2,"code":"ar" ,"name": "Arabic"},
    { "id": 3, "code":"ur","name": "Urdu"}
    ]';
    public $main_lang = '[
    { "id": 1,"code":"en", "name": "English","trans":"en"},
    { "id": 2,"code":"ar" ,"name": "Arabic","trans":"ar"},
    { "id": 3, "code":"ur","name": "Urdu","trans":"ur"},
    { "id": 4, "code":"tl","name": "Tagalog","trans":"fil"}
    ]';

    public function loadJsonData($file)
    {
        $path = resource_path('data/'.$file.'.json');
        if (File::exists($path)) {
            $json = File::get($path);
            return json_decode($json, true);
        } else {
            return ['error' => 'File not found'];
        }
    }
    public function delete($id)
    {
        $this->form_delete_id = $id;
        $typeId=Form::whereid($id)->first()->form_type_id;
        $kiosks=Kiosk::whereform_id($this->form_delete_id)->get();
        if(count($kiosks)>0){
            $this->dispatchBrowserEvent('show-modal-haveKiosks');
        }
        else{
            $this->dispatchBrowserEvent('show-delete',['typeId'=>$typeId]);
        }
        $this->mount();



    }
    public function unlinkKiosks(){
        $kiosks=Kiosk::whereform_id($this->form_delete_id)->get();
        foreach ($kiosks as $key => $kiosk) {
             $kiosk->form_id=null;$kiosk->save();
        }
        RefreshKiosks::dispatch($kiosks->toArray());
        $this->mount();


    }
    public function copyformlink($form)
    {
        $link=$form['url'];
        $this->dispatchBrowserEvent('show-box-link',['link'=>$link]);
        $this->mount();

    }
    public function setactiveform($id,$active){

        $form = Form::whereid($id)->first();
         $form->active =!$active;
        $form->save();
        $this->mount();
    }

    public function deletenow(){

        $form = Form::whereaccount_id(Auth::user()->current_account_id)->whereid($this->form_delete_id)->first();
        $kiosks=Kiosk::whereform_id($this->form_delete_id)->get();

        // // if form have image


        FormTrnslations::whereform_id($this->form_delete_id)->delete();


        $form->deleteForm($form->id);

        $this->mount();
    }

    public function numofquestions($id)
    {
        $count1 = questions::where('form_id', '=', $id)->whereNotIn('type_of_question_id', [8, 9])->get();
        $count2 = DB::table('questions')
            ->join('custom_questions', 'questions.id', '=', 'custom_questions.question_id')
            ->where('questions.form_id', '=', $id)
            ->groupBy('custom_questions.custom_question_id')
            ->select('questions.*')
            ->get();
        $count = count($count1) + count($count2);

        return $count;
    }
    // after add new form
    public function formaddsuccess($id)
    {


        //   dd($this->current_form);


        $this->dispatchBrowserEvent('close_modal_add_form');
        $this->mount();

    }

    public function mount()
    {



        $this->current_subscribe=SubscribePlan::getCurrentSubscription(Auth::user()->current_account_id);
        $this->current_subscribe_id=$this->current_subscribe->plan_id;
        $this->current_subscribe_type=$this->current_subscribe->type;

        $this->accountStatus=SubscribePlan::getCurrentAccountStatus(Auth::user()->current_account_id);


        $this->plansPermissionsErrors= json_decode($this->errors_permission, true);

        $this->forms = Form::getAllForms(Auth::user()->current_account_id);

        $this->typesForms=Form::getAllTypesForms(Auth::user()->current_account_id);
        $this->responses=[];
        $this->totalresponses=0;
        $this->totalresponses_kiosks=0;
        $this->totalactiveforms=0;
        $this->totalforms=0;

        foreach ($this->typesForms as $key => $type) {

            foreach ($type['forms'] as $key => $form) {

            // $responses_kiosks=Responses::whereform_id($form->id)->whereNotNull('responses.response_source')->get();
            // $this->totalresponses_kiosks+=count($responses_kiosks);
            $form->responsesCount=Responses::countResponsesPerForm($form->id);
            $this->totalresponses+=$form->responsesCount;
            $form->mediaCount=FormMedia::whereform_id($form->id)->count();
            $form->devices_count=count(Kiosk::where('form_id','=',$form->id)->get());
           $form->active==true?$this->totalactiveforms+=1:"";
            $form->age=$this->formAge($form->created_at);
            $this->totalforms+=1;
            }
        }


        $this->main_languages = json_decode($this->main_lang, true);
        $this->messages =  $this->loadJsonData('defaultFormMessages');


    }
    public function formAge($birth){
        $birthdate = Carbon::parse($birth); // Replace with the person's birthdate

        // Current date
        $currentDate = Carbon::now();

        // Calculate age
        $age = $birthdate->diff($currentDate);

        // Extract years, months, and days from the age difference
        $years = $age->y;
        $months = $age->m;
        $days = $age->d;

        // Output the age
        if($years==0)
        {
            if($months==0)
            {
            if($days==0)
               return trans('main.today');
            else
           {
               return trans('main.days',['days'=>$days]);}
            }
            else
            return trans('main.days_months',['days'=>$days,'months'=>$months]);


        }

        return trans('main.days_months_years',['days'=>$days,'months'=>$months,'years'=>$years]);
    }
      public function Route($route,$id){
        $this->mount();
        //routing
        if( $this->current_subscribe->valid)
        {
            return redirect()->route($route,$id);
        }
        //invalid account
        else
        {
            $this->dispatchBrowserEvent('show-alarm');

        }

      }
    public function render()
    {
        return view('livewire.allforms');
    }
}
