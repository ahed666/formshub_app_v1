<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Logos;
use App\Models\Pictures;
use App\Models\Questions;
use App\Models\QuestionTranslation;
use App\Models\QuestionType;
use App\Models\Form;
use App\Models\FormTrnslations;
use App\Models\Responses;
use App\Models\Kiosk;
use App\Models\ToDo;
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
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Redirect;
use Laravel\Jetstream\Jetstream;
class Overview extends Component
{


    public $totalresponses;
    public $totalquestions;
    public $totaltodos;
    public $completPercent;
    public $averagescore;
    public $canceledResponsesNum;
    public $status;
    public $form_age;
    public $totalresponses_kiosks;
    public $current_form_id;
    public $current_form;
    public $responsesdates;
    public $numofresponses;
    public $numofresponsesCanceld;
    public $numofresponsesfordevices;
    public $devices;
    public $startdate;
    public $enddate;
    public $mindate;
    public $maxdate;
    public $formquestions;
    public $formlanguages;
    public $language;
    public $allresponses=[];
     public $type;
    public $startDateOfResponse='2023-01-01';
    public $endDateOfResponse='2023-01-01';
    public $todo_svg='<!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">
    <!-- Uploaded to: SVG Repo, www.svgrepo.com, Transformed by: SVG Repo Mixer Tools -->
    <svg class="w-6 h-6" viewBox="-3.2 -3.2 26.40 26.40" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#000000">
    <g id="SVGRepo_bgCarrier" stroke-width="0"/>
    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>
    <g id="SVGRepo_iconCarrier"> <title>time / 30 - time, calendar, add, date, event, planner, shedule, task icon</title> <g id="Free-Icons" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" stroke-linecap="round" stroke-linejoin="round"> <g transform="translate(-525.000000, -748.000000)" id="Group" stroke="#000000" stroke-width="2"> <g transform="translate(523.000000, 746.000000)" id="Shape"> <line x1="17" y1="3" x2="17" y2="5"> </line> <line x1="7" y1="3" x2="7" y2="5"> </line> <path d="M17,13 L17,21 M21,17 L13,17"> </path> <path d="M8.03064542,21 C7.42550126,21 6.51778501,21 5.30749668,21 C4.50512981,21 4.2141722,20.9218311 3.92083887,20.7750461 C3.62750553,20.6282612 3.39729582,20.4128603 3.24041943,20.1383964 C3.08354305,19.8639324 3,19.5916914 3,18.8409388 L3,7.15906122 C3,6.4083086 3.08354305,6.13606756 3.24041943,5.86160362 C3.39729582,5.58713968 3.62750553,5.37173878 3.92083887,5.22495386 C4.2141722,5.07816894 4.50512981,5 5.30749668,5 L18.6925033,5 C19.4948702,5 19.7858278,5.07816894 20.0791611,5.22495386 C20.3724945,5.37173878 20.6027042,5.58713968 20.7595806,5.86160362 C20.9164569,6.13606756 21,7.24671889 21,7.99747152"> </path> </g> </g> </g> </g>
    </svg>';
    public $disagree_svg='<!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">
    <!-- Uploaded to: SVG Repo, www.svgrepo.com, Transformed by: SVG Repo Mixer Tools -->
    <svg fill="#000000" class="w-6 h-6" viewBox="0 0 24.00 24.00" xmlns="http://www.w3.org/2000/svg">
    <g id="SVGRepo_bgCarrier" stroke-width="0"/>
    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>
    <g id="SVGRepo_iconCarrier">
    <path d="M12,7a1,1,0,0,0-1,1v4a1,1,0,0,0,2,0V8A1,1,0,0,0,12,7Zm0,8a1,1,0,1,0,1,1A1,1,0,0,0,12,15Zm9.71-7.44L16.44,2.29A1.05,1.05,0,0,0,15.73,2H8.27a1.05,1.05,0,0,0-.71.29L2.29,7.56A1.05,1.05,0,0,0,2,8.27v7.46a1.05,1.05,0,0,0,.29.71l5.27,5.27a1.05,1.05,0,0,0,.71.29h7.46a1.05,1.05,0,0,0,.71-.29l5.27-5.27a1.05,1.05,0,0,0,.29-.71V8.27A1.05,1.05,0,0,0,21.71,7.56ZM20,15.31,15.31,20H8.69L4,15.31V8.69L8.69,4h6.62L20,8.69Z"/>
    </g>
    </svg>';
    public $questions_svg='<!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">
    <!-- Uploaded to: SVG Repo, www.svgrepo.com, Transformed by: SVG Repo Mixer Tools -->
    <svg fill="#000000" class="w-6 h-6" viewBox="-2.4 -2.4 28.80 28.80" xmlns="http://www.w3.org/2000/svg">
    <g id="SVGRepo_bgCarrier" stroke-width="0"/>
    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>
    <g id="SVGRepo_iconCarrier">
    <path d="m23.254 19.014h-.053c.012.117.02.252.02.389 0 .475-.086.931-.242 1.351l.009-.027c-.235.877-.704 1.624-1.336 2.194l-.004.004c-.809.669-1.856 1.074-2.998 1.074-.076 0-.152-.002-.228-.005h.011c-.039.001-.085.002-.132.002-1.126 0-2.162-.384-2.985-1.027l.011.008c-.812-.617-1.477-1.383-1.963-2.262l-.019-.037c-.819.238-1.76.375-2.732.375-1.249 0-2.446-.226-3.55-.639l.07.023c-2.061-.718-3.776-1.992-5.017-3.642l-.019-.027c-1.305-1.668-2.093-3.796-2.093-6.108 0-.037 0-.074.001-.111v.006c-.001-.039-.001-.085-.001-.131 0-1.997.578-3.859 1.575-5.427l-.024.041c.987-1.552 2.315-2.803 3.885-3.672l.055-.028c1.479-.842 3.25-1.339 5.137-1.339h.005c1.896.002 3.675.498 5.217 1.367l-.054-.028c1.616.873 2.936 2.107 3.885 3.6l.025.042c.951 1.565 1.514 3.458 1.514 5.482v.093-.005.068c0 1.691-.395 3.289-1.099 4.707l.028-.062c-.735 1.381-1.706 2.54-2.872 3.464l-.023.017c.331.534.72.992 1.169 1.384l.007.006c.416.301.937.481 1.499.482.023.001.049.002.076.002.48 0 .912-.206 1.213-.534l.001-.001c.246-.289.403-.659.426-1.066v-.005zm-7.713-3.106c.583-1.426.922-3.08.922-4.814 0-.191-.004-.381-.012-.569l.001.027q0-4.285-1.42-6.374c-.911-1.28-2.389-2.105-4.06-2.105-.126 0-.25.005-.373.014l.016-.001c-.11-.009-.238-.014-.367-.014-1.661 0-3.129.826-4.015 2.09l-.01.016q-1.395 2.088-1.368 6.35t1.395 6.347c.882 1.279 2.34 2.107 3.99 2.107.132 0 .263-.005.392-.016l-.017.001c.032.001.069.001.107.001.594 0 1.165-.099 1.698-.28l-.037.011c-.415-.857-.897-1.595-1.459-2.263l.013.016c-.575-.624-1.394-1.017-2.304-1.027h-.002c-.016 0-.034-.001-.053-.001-.351 0-.683.08-.979.223l.013-.006-.697-1.285c.939-.77 2.153-1.236 3.475-1.236.078 0 .155.002.232.005h-.011c.057-.002.125-.003.192-.003 1.058 0 2.047.3 2.884.82l-.023-.013c.747.54 1.372 1.197 1.859 1.951l.017.028z"/>
    </g>
    </svg>';
    public $responses_svg='<!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">
    <!-- Uploaded to: SVG Repo, www.svgrepo.com, Transformed by: SVG Repo Mixer Tools -->
    <svg class="w-6 h-6" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="-83.3 -83.3 656.60 656.60" xml:space="preserve" width="800px" height="800px">
    <g id="SVGRepo_bgCarrier" stroke-width="0"/>
    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>
    <g id="SVGRepo_iconCarrier"> <g> <g> <g> <path d="M450,0h-410c-22.056,0-40,17.944-40,40v280c0,22.056,17.944,40,40,40h235v120c0,4.118,2.524,7.814,6.358,9.314 c1.184,0.463,2.417,0.687,3.639,0.687c2.738,0,5.42-1.126,7.35-3.218L409.38,360H450c22.056,0,40-17.944,40-40V40 C490,17.944,472.057,0,450,0z M470,320c0,11.028-8.972,20-20,20h-45c-2.791,0-5.455,1.167-7.348,3.217L295,454.423V350 c0-5.523-4.477-10-10-10h-245c-11.028,0-20-8.972-20-20V40c0-11.028,8.972-20,20-20h410c11.028,0,20,8.972,20,20V320z"/> <path d="M144.881,80.001c-3.957,0.047-7.513,2.423-9.072,6.06l-75,175l18.383,7.878L106.594,205h79.982l29.329,64.158 l18.189-8.315l-80-175C152.45,82.244,148.863,79.974,144.881,80.001z M115.167,185l30.129-70.302L177.433,185H115.167z"/> <rect x="255.001" y="115" width="80" height="20"/> <rect x="350" y="115" width="60" height="20"/> <rect x="255.001" y="165" width="180" height="20"/> <rect x="255.001" y="215" width="75" height="20"/> </g> </g> </g> </g>
    </svg>';
    public $formage_svg='<!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">
    <!-- Uploaded to: SVG Repo, www.svgrepo.com, Transformed by: SVG Repo Mixer Tools -->
    <svg fill="#000000" class="w-6 h-6" viewBox="-2.64 -2.64 29.28 29.28" xmlns="http://www.w3.org/2000/svg">
    <g id="SVGRepo_bgCarrier" stroke-width="0"/>
    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>
    <g id="SVGRepo_iconCarrier">
    <path d="M20,3a1,1,0,0,0,0-2H4A1,1,0,0,0,4,3H5.049c.146,1.836.743,5.75,3.194,8-2.585,2.511-3.111,7.734-3.216,10H4a1,1,0,0,0,0,2H20a1,1,0,0,0,0-2H18.973c-.105-2.264-.631-7.487-3.216-10,2.451-2.252,3.048-6.166,3.194-8Zm-6.42,7.126a1,1,0,0,0,.035,1.767c2.437,1.228,3.2,6.311,3.355,9.107H7.03c.151-2.8.918-7.879,3.355-9.107a1,1,0,0,0,.035-1.767C7.881,8.717,7.227,4.844,7.058,3h9.884C16.773,4.844,16.119,8.717,13.58,10.126ZM12,13s3,2.4,3,3.6V20H9V16.6C9,15.4,12,13,12,13Z"/>
    </g>
    </svg>';
    public $score_svg='<!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">
    <svg class="w-6 h-6 text-black" viewBox="0 0 72 72" id="emoji" xmlns="http://www.w3.org/2000/svg" fill="currentColor">
    <g id="SVGRepo_bgCarrier" stroke-width="0"/>
    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>
    <g id="SVGRepo_iconCarrier"> <g id="color"/> <g id="hair"/> <g id="skin"/> <g id="skin-shadow"/> <g id="line"> <line x1="59.1829" x2="13.1829" y1="46.059" y2="46.059" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-width="4"/> <line x1="59.1829" x2="13.1829" y1="54.059" y2="54.059" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-width="4"/> <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-width="4" d="M32.9833,37.0046L32.9833,37.0046c-3.4677,0-6.2789-2.8112-6.2789-6.2789V20.3382c0-3.4677,2.8112-6.2792,6.2789-6.2792l0,0 c3.4681,0,6.2792,2.8115,6.2792,6.2792v10.3875C39.2625,34.1934,36.4513,37.0046,32.9833,37.0046z"/> <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-width="4" d="M52.9092,37.0046L52.9092,37.0046c-3.4677,0-6.2789-2.8112-6.2789-6.2789V20.3382c0-3.4677,2.8112-6.2792,6.2789-6.2792l0,0 c3.4681,0,6.2792,2.8115,6.2792,6.2792v10.3875C59.1884,34.1934,56.3773,37.0046,52.9092,37.0046z"/> <polyline fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-width="4" points="12.9843,18.8851 19.3366,14.1262 19.3366,37.0718"/> </g> <g id="color-foreground"> <line x1="59.1829" x2="13.1829" y1="46.059" y2="46.059" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-width="4.1"/> <line x1="59.1829" x2="13.1829" y1="54.059" y2="54.059" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-width="4.1"/> <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-width="4.1" d="M32.9833,37.0046L32.9833,37.0046c-3.4677,0-6.2789-2.8112-6.2789-6.2789V20.3382c0-3.4677,2.8112-6.2792,6.2789-6.2792l0,0 c3.4681,0,6.2792,2.8115,6.2792,6.2792v10.3875C39.2625,34.1934,36.4513,37.0046,32.9833,37.0046z"/> <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-width="4.1" d="M52.9092,37.0046L52.9092,37.0046c-3.4677,0-6.2789-2.8112-6.2789-6.2789V20.3382c0-3.4677,2.8112-6.2792,6.2789-6.2792l0,0 c3.4681,0,6.2792,2.8115,6.2792,6.2792v10.3875C59.1884,34.1934,56.3773,37.0046,52.9092,37.0046z"/> <polyline fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-width="4.1" points="12.9843,18.8851 19.3366,14.1262 19.3366,37.0718"/> </g> </g>
    </svg>';
    public $completion_svg='<!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">
    <!-- Uploaded to: SVG Repo, www.svgrepo.com, Transformed by: SVG Repo Mixer Tools -->
    <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
    <g id="SVGRepo_bgCarrier" stroke-width="0"/>
    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>
    <g id="SVGRepo_iconCarrier"> <path d="M9 10L12.2581 12.4436C12.6766 12.7574 13.2662 12.6957 13.6107 12.3021L20 5" stroke="#000000" stroke-width="2" stroke-linecap="round"/> <path d="M21 12C21 13.8805 20.411 15.7137 19.3156 17.2423C18.2203 18.7709 16.6736 19.9179 14.893 20.5224C13.1123 21.1268 11.187 21.1583 9.38744 20.6125C7.58792 20.0666 6.00459 18.9707 4.85982 17.4789C3.71505 15.987 3.06635 14.174 3.00482 12.2945C2.94329 10.415 3.47203 8.56344 4.51677 6.99987C5.56152 5.4363 7.06979 4.23925 8.82975 3.57685C10.5897 2.91444 12.513 2.81996 14.3294 3.30667" stroke="#000000" stroke-width="2" stroke-linecap="round"/> </g>
    </svg>';
    public $main_lang='{
        "en":{ "id": 1,"code":"en", "name": "English","trans":"en"},
        "ar":{ "id": 2,"code":"ar" ,"name": "Arabic","trans":"ar"},
        "ur":{ "id": 3, "code":"ur","name": "Urdu","trans":"ur"},
        "tl":{ "id": 4, "code":"tl","name": "Tagalog","trans":"fil"}
    }';
    public $languages;
    public $main_languages;
    protected $listeners=[

        "refreshoverviewdata"=>"refreshoverviewdata",


    ];

    //  when click on refresh button
    public function refreshoverviewdata($id){

        $this->totalresponses=count(Responses::whereform_id($this->current_form_id)->get());
        $this->totalquestions=count(Questions::whereform_id($this->current_form_id)->get());
        $this->totaltodos= ToDo::Todos($this->current_form_id);
        $this->canceledResponsesNum =count( Responses::where('form_id', $this->current_form_id)
        ->whereDoesntHave('questions')
        ->whereDoesntHave('customersInfo')->get());
        $this->current_form=Form::whereid($this->current_form_id)->first();
        $this->form_age=$this->formAge($this->current_form->created_at);
        $this->status=(bool)Form::whereid($this->current_form_id)->first()->active;
        $this->completPercent=Responses::whereform_id($this->current_form_id)->average('complet_percent');
        $this->averagescore=Responses::whereform_id($this->current_form_id)->average('score');

        $this->main_languages=json_decode($this->main_lang, true);

        $this->mostresponses=Responses::lastTenResponsesWithinLastWeek($this->current_form->id);

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



        // call responses/dates function
        $this->responses_dates($this->startDateOfResponse,$this->endDateOfResponse);
        // call responses/devices function
        $this->responses_devices();
        $this->dispatchBrowserEvent('reinitialchart',['responsesdates'=>$this->responsesdates,'numofresponses'=>$this->numofresponses,'numofresponsesCanceld'=>$this->numofresponsesCanceld]);


    }
    }


    public function mount(){

        $url=url()->current();
        $forminfo = explode('/', $url);
        $this->current_form_id=$forminfo[5];
        $this->type=$forminfo[4];
        $this->totalresponses=count(Responses::whereform_id($this->current_form_id)->get());
        $this->totalquestions=count(Questions::whereform_id($this->current_form_id)->get());
        $this->totaltodos= ToDo::Todos($this->current_form_id);
        $this->canceledResponsesNum =count( Responses::where('form_id', $this->current_form_id)
        ->whereDoesntHave('questions')
        ->whereDoesntHave('customersInfo')->get());
        $this->current_form=Form::whereid($this->current_form_id)->first();
        $this->form_age=$this->formAge($this->current_form->created_at);
        $this->status=(bool)Form::whereid($this->current_form_id)->first()->active;
        $this->completPercent=Responses::whereform_id($this->current_form_id)->average('complet_percent');
        $this->averagescore=Responses::whereform_id($this->current_form_id)->average('score');

        $this->main_languages=json_decode($this->main_lang, true);

        $this->mostresponses=Responses::lastTenResponsesWithinLastWeek($this->current_form->id);

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
    // Form Age
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
            {  if($days==0)
               return trans('main.today');
               else
               return trans('main.days',['days'=>$days]);
            }
            else
            return trans('main.days_months',['days'=>$days,'months'=>$months]);


        }

        return trans('main.days_months_years',['days'=>$days,'months'=>$months,'years'=>$years]);
    }

    // updatedstartdate =>set start date of responses/dates charts

    public function updatedstartdate(){
        $this->responses_dates($this->startdate,null);
        $this->dispatchBrowserEvent('reinitialchart',['responsesdates'=>$this->responsesdates,'numofresponses'=>$this->numofresponses,'numofresponsesCanceld'=>$this->numofresponsesCanceld]);
    }
    // updatedenddate =>set end date of responses/dates charts
    public function updatedenddate(){
        $this->responses_dates(null,$this->enddate);
        $this->dispatchBrowserEvent('reinitialchart',['responsesdates'=>$this->responsesdates,'numofresponses'=>$this->numofresponses,'numofresponsesCanceld'=>$this->numofresponsesCanceld]);

    }
    // responses/dates function --- initialization data for responses/dates charts
    public function responses_dates($start,$end){

        $start==null?$start=$this->startDateOfResponse:$start=$start;
        $end==null?$end=$this->endDateOfResponse:$end=$end;
        $this->startDateOfResponse=$start;
        $this->endDateOfResponse=$end;
        $this->responsesdates=[];
        $this->numofresponses=[];
        $this->numofresponsesCanceld=[];
        // $responses=Responses::whereform_id($this->current_form_id)->whereBetween('reviewed_at', [DATE($start),DATE($end)])->select(DB::raw('DATE(`reviewed_at`) as date'), DB::raw('count(*) as total'))->groupBy('date')->get();

        //  foreach ($responses as $key => $response) {
        //     $this->responsesdates[$key]=$response->date;
        //     $this->numofresponses[$key]=$response->total;
        // }
        $dates=$this->getBetweenDates($start, $end);
        $this->numofresponses=array_fill(0, count($dates),0);
        $this->numofresponsesCanceld=array_fill(0, count($dates),0);
        for ($i=0; $i <count($dates) ; $i++) {
            $res=Responses::whereform_id($this->current_form_id)->where(DB::raw('DATE(`reviewed_at`)'),DATE($dates[$i]))
            ->select('responses.*')->get();
            $canceled= Responses::where('form_id', $this->current_form_id)->where(DB::raw('DATE(`reviewed_at`)'),DATE($dates[$i]))
            ->whereDoesntHave('questions')
            ->whereDoesntHave('customersInfo')->select('responses.*')->get();
            $this->responsesdates[$i]=$dates[$i];
            $this->numofresponses[$i]=count($res);
            $this->numofresponsesCanceld[$i]=count($canceled);
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
        $share_key;
        $others_key;
        // $this->devices[0]="Share";$this->numofresponsesfordevices[0]=0;

        $others=0;
        $i=0;
        foreach ($responsesperdevices as $key => $response) {
            // share
            if($response->device_name==null&&$response->response_source==null)
            {
                 $this->numofresponsesfordevices[0]+=$response->total;
            }
            // not share
            else if($response->response_source!=null)
            {
                $device=Kiosk::wheredevice_code_id($response->response_source)->whereaccount_id(Auth::user()->current_account_id)->first();
                if($device)
                {$this->devices[$i]=$response->device_name;
                    $this->numofresponsesfordevices[$i]=$response->total;
                    $i+=1;}
                else
                $others+=$response->total;

            }


        }
        // $this->devices[$i]="Others";$this->numofresponsesfordevices[$i]=$others;
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
    public function render()
    {
        return view('livewire.overview');
    }
}
