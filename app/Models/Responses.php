<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ResponsedQuestions;
use App\Models\ResponsedCustomersInfo;
use App\Models\Account;
use Carbon\Carbon;
use App\Models\Kiosk;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Responses extends Model
{
    use HasFactory;
    protected $table="responses";
    protected $fillable = [
        'id_view', 'todo', 'form_id','response_source','response_language','score','complet_percent','viewed'
    ];
        public function questions()
    {
        return $this->hasMany(ResponsedQuestions::class, 'response_id', 'id');
    }
    public function customersInfo()
    {
        return $this->hasMany(ResponsedCustomersInfo::class, 'response_id', 'id');
    }
    public static function lastTenResponsesWithinLastWeek($id)
    {
        // $lastWeek = Carbon::now()->subWeek();

        // return static::where('created_at', '>=', $lastWeek)->where('form_id', '=', $id)
        //     ->latest('created_at')
        //     ->take(10)
        //     ->get();
        $userTimezone=Auth::user()->timezone;
        return static::where('form_id', '=', $id)
            ->latest('created_at')
            ->orderBy('reviewed_at','desc')
            ->take(10)
            ->get() ;

    }
    public static function allResponses($id){
        $responses = self::join('forms', 'forms.id', '=', 'responses.form_id')
        ->where('forms.account_id', '=', $id)
        ->orderBy('responses.reviewed_at','desc')
        ->get();
        return count($responses);
    }
    public static function getResponsesCreatedToday($accountId)
    {

        return self::join('forms', 'forms.id', '=', 'responses.form_id')
        ->where('forms.account_id', '=', $accountId)
        ->whereDate('responses.created_at', now()->toDateString())->count();

    }
    public static function responsesPerDates($accountId)
    {
        $responseCounts = self::join('forms', 'forms.id', '=', 'responses.form_id')
        ->where('forms.account_id', '=', $accountId) // Replace with your account ID condition
    ->select(DB::raw('DATE(reviewed_at) as date'), DB::raw('COUNT(*) as count'))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Prepare the data in the format required for your chart library (e.g., Chart.js)
        $chartData = [
            'labels' => $responseCounts->pluck('date')->toArray(),
            'data' => $responseCounts->pluck('count')->toArray(),
        ];

        return $chartData;
    }
    public static function responsesRateData()
    {
        $responseCounts = self::join('forms', 'forms.id', '=', 'responses.form_id')
         // Replace with your account ID condition
    ->select(DB::raw('DATE(reviewed_at) as date'), DB::raw('COUNT(*) as count'))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Prepare the data in the format required for your chart library (e.g., Chart.js)
        $chartData = [
            'labels' => $responseCounts->pluck('date')->toArray(),
            'data' => $responseCounts->pluck('count')->toArray(),
        ];

        return $chartData;
    }
    // get Responses used of subscription
    public static function getResponsesSubscription($startDate,$accountId){
        $startDate=Carbon::parse($startDate);
        $endDate = Carbon::now();
        return self::join('forms', 'forms.id', '=', 'responses.form_id')
        ->where('forms.account_id', '=', $accountId)
        ->whereBetween('responses.created_at', [$startDate, $endDate])->count();
    }
    // get Responses ratio per form
    public static function getResponsesPerForm($accountId){

        $forms= self::RightJoin('forms', 'forms.id', '=', 'responses.form_id')
        ->where('forms.account_id', '=', $accountId)
        ->where('forms.form_type_id','=',1)
        ->groupBy('forms.id')->select('forms.form_title',DB::raw('COUNT(responses.id) as count'))->get();

        $numAllResponses=self::allResponses($accountId);
      
        foreach ($forms as $key => $form) {
            $form->ratio=$numAllResponses==0?0:($form->count==0?0:round(($form->count)*100/$numAllResponses,1));
        }

        $chartData = [
            'labels' => $forms->pluck('form_title')->toArray(),
            'data' => $forms->pluck('ratio')->toArray(),
        ];
        return $chartData;

    }
    // get Responses ratio per divces
    public static function getResponsesPerKiosk($accountId){


        $devices=Kiosk::whereaccount_id($accountId)->get();
        $responses=self::join('forms','forms.id','=','responses.form_id')->where('forms.account_id','=',$accountId)
        ->select('responses.response_source',DB::raw('count(*) as total'))->groupBy('responses.response_source')->get();
        $numAllResponses=count(self::join('forms','forms.id','=','responses.form_id')
        ->join('devices','devices.device_code_id','=','responses.response_source')
        ->where('devices.account_id','=',$accountId)
        ->where('forms.account_id','=',$accountId)
        ->select('responses.response_source')->get());
        $numofresponsesfordevices=[];
        foreach ($devices as $key => $device) {
          $numofresponsesfordevices[$device->device_code_id]['label']=$device->device_name;
          $numofresponsesfordevices[$device->device_code_id]['count']=0;
        }


            foreach ($responses as $key => $response) {

                // not share
                if($response->response_source!=null)
                {

                    if(array_key_exists($response->response_source, $numofresponsesfordevices))
                    {
                        if ($numAllResponses == 0 ) {
                            $numofresponsesfordevices[$response->response_source]['count']= 0;
                        } else {
                            $numofresponsesfordevices[$response->response_source]['count'] = round(($response->total) * 100 / $numAllResponses, 1);
                        }
                    }



                }


            }
            $labels = [];
            $counts = [];

            foreach ($numofresponsesfordevices as $entry) {
                // Check if the 'label' and 'count' keys exist in the entry
                if (isset($entry['label']) && isset($entry['count'])) {
                    $labels[] = $entry['label'];
                    $counts[] = $entry['count'];
                }
            }
            $chartData = [
                'labels' => $labels,
                'data' => $counts,
            ];

            return $chartData;

    }
    public static function responsesDates(){
        // Get the current date and time
         $currentDate = Carbon::now();

         // Get the start of the current month
         $startOfMonth = Carbon::now()->startOfMonth();
         $startOfYear = Carbon::now()->startOfYear();
         // Retrieve accounts created today
         $ResponsesCreatedToday = self::whereDate('created_at', $currentDate->toDateString()) // Compare the date part
             ->count();

         // Retrieve accounts created this month
         $ResponsesCreatedThisMonth = self::whereMonth('created_at', $startOfMonth->month) // Compare the month
             ->whereYear('created_at', $startOfMonth->year) // Compare the year
             ->count();
        // Retrieve accounts created this month
        $ResponsesCreatedThisYear = self::whereYear('created_at', $startOfYear->year) // Compare the year
        ->count();

         $resultArray = [
             'Today' => $ResponsesCreatedToday,
             'This Month' => $ResponsesCreatedThisMonth,
             'This Year' => $ResponsesCreatedThisYear
         ];
       return $resultArray;
    }
    public static function responseInfo(){
         $responsesDates=self::responsesDates();

         $responsesCount=self::all()->count();
         $responsesRateData=self::responsesRateData();
         // Create the array
         $responses = [
             'responsesDates' => $responsesDates,
             'responsesRateData'=>$responsesRateData,
             'responsesCount'=>$responsesCount
         ];
         return $responses;
    }
    // count responses per form
    public static function countResponsesPerForm($form_id){
       return self::whereform_id($form_id)->count();
    }
}
