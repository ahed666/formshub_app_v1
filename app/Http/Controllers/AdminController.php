<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Support\Facades\File;
use Illuminate\Routing\Controller;
use Illuminate\Routing\Pipeline;
// use Laravel\Fortify\Actions\AttemptToAuthenticate;
use Laravel\Fortify\Actions\EnsureLoginIsNotThrottled;
use Laravel\Fortify\Actions\PrepareAuthenticatedSession;
// use Laravel\Fortify\Actions\RedirectIfTwoFactorAuthenticatable;
// use Laravel\Fortify\Contracts\LoginResponse;
use App\Actions\Fortify\AttemptToAuthenticate; // add new line
use App\Actions\Fortify\RedirectIfTwoFactorAuthenticatable; // add new line
use App\Http\Responses\LoginResponse;
use Laravel\Fortify\Contracts\LoginViewResponse;
use Laravel\Fortify\Contracts\LogoutResponse;
use Laravel\Fortify\Features;
use Laravel\Fortify\Fortify;
use Laravel\Fortify\Http\Requests\LoginRequest;
use App\Models\Account;
use App\Models\Admin;
use App\Models\User;
use App\Models\SubscribePlan;
use App\Models\Subscribe;
use App\Models\TypeSubscribe;
use App\Models\Kiosk;
use App\Models\Form;
use App\Models\Responses;
use App\Models\Invoice;
use App\Models\DeviceCode;
use App\Models\DeviceModel;
use App\Models\ResponseCategory;
use \PDF;
use Dompdf\Dompdf;
use App\Models\SupportTicket;
use App\Models\DeletedAccount;
use App\Models\canceledPlan;
use App\Models\OrderProduct;
use App\Models\Client;
use App\Models\PromotionCode;
use App\Models\Order;
use App\Models\TypeDevice;
use Jenssegers\Agent\Agent;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
   /**
     * The guard implementation.
     *
     * @var \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected $guard;

    /**
     * Create a new controller instance.
     *
     * @param  \Illuminate\Contracts\Auth\StatefulGuard  $guard
     * @return void
     */
    public function __construct(StatefulGuard $guard)
    {
        $this->guard = $guard;
    }

    /**
     * Show the login view.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Laravel\Fortify\Contracts\LoginViewResponse
     */
    public function create(Request $request): LoginViewResponse
    {
        return app(LoginViewResponse::class);
    }

    /**
     * Attempt to authenticate a new session.
     *
     * @param  \Laravel\Fortify\Http\Requests\LoginRequest  $request
     * @return mixed
     */
    public function store(LoginRequest $request)
    {

        return $this->loginPipeline($request)->then(function ($request) {

            return app(LoginResponse::class);
        });
    }

    /**
     * Get the authentication pipeline instance.
     *
     * @param  \Laravel\Fortify\Http\Requests\LoginRequest  $request
     * @return \Illuminate\Pipeline\Pipeline
     */
    protected function loginPipeline(LoginRequest $request)
    {
        if (Fortify::$authenticateThroughCallback) {

            return (new Pipeline(app()))->send($request)->through(array_filter(
                call_user_func(Fortify::$authenticateThroughCallback, $request)
            ));
        }

        if (is_array(config('fortify.pipelines.login'))) {

            return (new Pipeline(app()))->send($request)->through(array_filter(
                config('fortify.pipelines.login')
            ));
        }

        return (new Pipeline(app()))->send($request)->through(array_filter([
            config('fortify.limiters.login') ? null : EnsureLoginIsNotThrottled::class,
            Features::enabled(Features::twoFactorAuthentication()) ? RedirectIfTwoFactorAuthenticatable::class : null,
            AttemptToAuthenticate::class,
            PrepareAuthenticatedSession::class,
        ]));
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Laravel\Fortify\Contracts\LogoutResponse
     */

    public function destroy(Request $request)
    {
        if(Auth::guard('admin')->check()) // this means that the admin was logged in.
        {
            Auth::guard('admin')->logout();
            return redirect()->route('admin.login');
        }

        $this->guard()->logout();
        $request->session()->invalidate();

        // $this->guard->logout();

        // $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('admin.login');

    }
    public function loginForm(){

        return view('auth.login',['guard' => 'admin']);
       }
    // accounts
    public function accounts(){
        $accounts= Account::leftJoin('subscriptions_plans', 'accounts.id', '=', 'subscriptions_plans.account_id')
        ->leftJoin('type_of_subscriptions','type_of_subscriptions.id','=','subscriptions_plans.type_of_subscription_id')
        ->select('accounts.*','type_of_subscriptions.subscription_type',
        DB::raw('CASE WHEN accounts.active = 1 THEN "Active" ELSE "Suspended" END as account_status')
        ,DB::raw('CASE
        WHEN subscriptions_plans.expired_at > CURDATE() AND subscriptions_plans.valid = 1 THEN "Valid"
        WHEN CURDATE()  <= DATE_ADD(subscriptions_plans.expired_at,INTERVAL type_of_subscriptions.grace_period MONTH) AND subscriptions_plans.valid = 1 THEN "Expired - Grace Period"
        WHEN  CURDATE() > DATE_ADD(subscriptions_plans.expired_at, INTERVAL type_of_subscriptions.grace_period MONTH) AND CURDATE() <= DATE_ADD(subscriptions_plans.expired_at, INTERVAL type_of_subscriptions.locked_period MONTH)  THEN "Locked"
        WHEN  CURDATE() > DATE_ADD(subscriptions_plans.expired_at, INTERVAL type_of_subscriptions.locked_period MONTH) THEN "Locked-(D)"

        END AS subscription_status'))
        ->get();

        return view('admin.accounts',compact('accounts'));
    }
    // accounts for export
    public function getAccounts(){

            // Fetch data from the database or any other source
            $data =Account::leftJoin('users', 'accounts.user_id', '=', 'users.id')
            ->leftJoin('subscriptions_plans', 'accounts.id', '=', 'subscriptions_plans.account_id')
            ->leftJoin('type_of_subscriptions','type_of_subscriptions.id','=','subscriptions_plans.type_of_subscription_id')
            ->select('users.email','users.name','users.mobile_number','accounts.business_name','accounts.country','accounts.city','type_of_subscriptions.subscription_type',DB::raw('CASE
            WHEN subscriptions_plans.expired_at > CURDATE() AND subscriptions_plans.valid = 1 THEN "Valid"
            WHEN CURDATE()  <= DATE_ADD(subscriptions_plans.expired_at,INTERVAL type_of_subscriptions.grace_period MONTH) AND subscriptions_plans.valid = 1 THEN "Expired - Grace Period"
            WHEN  CURDATE() > DATE_ADD(subscriptions_plans.expired_at, INTERVAL type_of_subscriptions.grace_period MONTH) AND CURDATE() <= DATE_ADD(subscriptions_plans.expired_at, INTERVAL type_of_subscriptions.locked_period MONTH)  THEN "Locked"
            WHEN  CURDATE() > DATE_ADD(subscriptions_plans.expired_at, INTERVAL type_of_subscriptions.locked_period MONTH) THEN "Locked-(D)"

            END AS subscription_status'))->get()->toArray();

            // Return the data as JSON
            return response()->json($data);

    }
    // users
    public function users(){
        $today = Carbon::now()->startOfDay();
        $users=User::all()->map(function ($user) use ($today) {
            $user->today = $user->created_at->startOfDay()->eq($today);
            return $user;
        });

        return view('admin.users',compact('users'));
    }
    // subscriptions
    public function subscriptions(){

        $subscriptions=SubscribePlan::join('type_of_subscriptions','type_of_subscriptions.id','=','subscriptions_plans.type_of_subscription_id')
        ->select('subscriptions_plans.*','type_of_subscriptions.subscription_type as type')->get()
        ->map(function ($subscription) {
            $validallowdate=Carbon::parse($subscription->expired_at)->addMonths('type_of_subscriptions.grace_period');
            $subscription->lock = Carbon::now()->greaterThan($validallowdate) && !$subscription->valid;
            return $subscription;
        });

        return view('admin.subscriptions',compact('subscriptions'));
    }
    // invoices
    public function invoices(){
        $today = Carbon::now()->startOfDay();
        $invoices=Invoice::all()->map(function ($invoice) use ($today) {
            $invoice->today = $invoice->created_at->startOfDay()->eq($today);
            return $invoice;
        });
        return view('admin.invoices',compact('invoices'));
    }
     // forms
     public function forms(){

        $forms=Form::all();
        return view('admin.forms',compact('forms'));
    }
    // kiosks
    public function kiosks(){
        $today = Carbon::now()->startOfDay();

        $linkedkiosks=Kiosk::join('device_codes','device_codes.id','=','devices.device_code_id')
        ->select('device_codes.device_code','devices.account_id as account_id','devices.created_at','devices.updated_at')->get()
        ->map(function ($kiosk) use ($today) {
            $kiosk->today = $kiosk->created_at->startOfDay()->eq($today);
            return $kiosk;
        });

        $kiosks=DeviceCode::join('devices_models','devices_models.id','=','device_codes.device_model_id')
        ->select('device_codes.*','devices_models.device_model')->get()->map(function ($kiosk) use ($today) {
            $kiosk->today = $kiosk->created_at->startOfDay()->eq($today);
            return $kiosk;
        });
        return view('admin.kiosks',compact('linkedkiosks','kiosks'));
    }
    // support
    public function supportTickets(){

        $tickets=SupportTicket::join('accounts','accounts.id','=','support_tickets.account_id')
        ->join('users','users.id','=','accounts.user_id')->select('support_tickets.*','users.email as email')->get()
        ->map(function ($ticket) {
            $createdAt = Carbon::parse($ticket->created_at);
            $sevenDaysAgo = Carbon::now()->subDays(7);

            // Check if created_at is within the last seven days
            $ticket->recently = $createdAt->gte($sevenDaysAgo);

            return $ticket;
        });


        return view('admin.support_tickets',compact('tickets'));
    }

    // subscriptions
    public function dashboard(){

        $accounts = Account::accountInfo();
        $users=User::userInfo();
        $subscriptions=SubscribePlan::subscriptionInfo();
        $kiosks=Kiosk::kioskInfo();
        $forms=Form::formInfo();
        $responses=Responses::responseInfo();
        $tickets=SupportTicket::AllTicketsByStatus();
        return view('admin.dashboard',compact('accounts','users','kiosks','forms','responses','tickets','subscriptions'));
    }
    public function deletedaccounts(){
         $deletedAccounts=DeletedAccount::all();
        return view('admin.deleted_accounts',compact('deletedAccounts'));
    }
    public function canceledplans(){
        $canceledPlans=canceledPlan::join('type_of_subscriptions','type_of_subscriptions.id','=','canceled_plans.plan_type_id')->select('type_of_subscriptions.subscription_type','canceled_plans.*')->get();
       return view('admin.canceled_plans',compact('canceledPlans'));
   }
    //  settings
     public function settings(){

        $accounts= Account::leftJoin('subscriptions_plans', 'accounts.id', '=', 'subscriptions_plans.account_id')
        ->leftJoin('type_of_subscriptions','type_of_subscriptions.id','=','subscriptions_plans.type_of_subscription_id')
        ->select('accounts.*','type_of_subscriptions.subscription_type', DB::raw('CASE
            WHEN subscriptions_plans.expired_at > CURDATE() AND subscriptions_plans.valid = 1 THEN "Valid"
            WHEN CURDATE()  <= DATE_ADD(subscriptions_plans.expired_at,INTERVAL 1 MONTH) AND subscriptions_plans.valid = 1 THEN "Expired - Grace Period"
            WHEN  CURDATE() > DATE_ADD(subscriptions_plans.expired_at, INTERVAL 1 MONTH) THEN "Locked"

        END AS subscription_status'))
        ->get();
        // sessions
        $sessions= collect(
            DB::connection(config('session.connection'))->table(config('session.table', 'sessions'))
                    ->leftJoin('admins','admins.id','=',config('session.table', 'sessions').'.admin_id')
                    ->whereNotNull('admin_id')
                    ->orderBy('last_activity', 'desc')
                    ->select(config('session.table', 'sessions').'.*','admins.name','admins.role')
                    ->get()
        )->map(function ($session){

            $agent = $this->createAgent($session);

            return (object) [
                'agent' => [
                    'is_desktop' => $agent->isDesktop(),
                    'platform' => $agent->platform(),
                    'browser' => $agent->browser(),
                ],
                 'admin_name'=>$session->name,
                 'admin_role'=>$session->role,
                'id'=>$session->id,
                'admin_id'=>$session->admin_id,
                'ip_address' => $session->ip_address,
                'is_current_device' => $session->id === session()->getId(),
                'last_active' => Carbon::createFromTimestamp($session->last_activity)->diffForHumans(),
            ];
        });

        if(Auth::user()->role=="super_admin")
        {    $admins=Admin::all();
              $plans=TypeSubscribe::all();
              $allPlans=[];
              foreach ($plans as $key => $plan) {
                $allPlans[$plan->subscription_type]=$plan;
              }

             $responsesCategories=ResponseCategory::all();
            $promotionCodes= PromotionCode::all();
            $typeDevices=TypeDevice::with('model')->get();
            $devicesModels=DeviceModel::all();
            $clients=Client::all();
            return view('admin.settings',compact('admins','typeDevices','clients','devicesModels','promotionCodes','allPlans','responsesCategories','accounts','sessions'));
        }
        else{

            return redirect()->route('admin.dashboard');
        }
     }
    //  orders
    public function orders(){
        if(Auth::user()->role=="super_admin")
        {


            $orders = Order::allOrders();


            return view('admin.orders',compact('orders'));
        }
        else{

            return redirect()->route('admin.dashboard');
        }
    }
    // change status of order

    public function changeorderstatus(Request $request){

        $order=Order::whereid($request->input('order_id'))->first();
        $order->status=$request->input('status_select');
        $order->save();
        return redirect()->route('admin.orders')->with( ['success_title'=>'Success','success'=>'Order status updated successfully.']);


     }


    // functions
    protected function createAgent($session)
    {
        return tap(new Agent, function ($agent) use ($session) {
            $agent->setUserAgent($session->user_agent);
        });
    }
    public function saveplan(Request $request){
        try {
            $plan=TypeSubscribe::whereid($request->input('planid'))->first();

            $plan->price=$request->input('price');
            $plan->num_forms=$request->input('num_forms');
            $plan->num_questions=$request->input('num_questions');
            $plan->num_media_items=$request->input('num_media_items');
            $plan->num_responses=$request->input('num_responses');
            $plan->num_kiosks=$request->input('num_kiosks');
            $plan->valid_period=$request->input('valid_period');
            $plan->grace_period=$request->input('grace_period');
            $plan->locked_period=$request->input('locked_period');
            $plan->todo=$request->input('todo')=="true"?true:false;
            $plan->signpdf=$request->input('signpdf')=="true"?true:false;
            $plan->professional_dashboard_statistics=$request->input('professional_dashboard_statistics')=="true"?true:false;
            $plan->pro_questions=$request->input('pro_questions')=="true"?true:false;
            $plan->custom_form=$request->input('custom_form')=="true"?true:false;
            $plan->form_terms=$request->input('form_terms')=="true"?true:false;
            $plan->account_members=$request->input('account_members');
            $plan->export=$request->input('export')=="true"?true:false;
            $plan->multi_languages=$request->input('multi_languages')=="true"?true:false;
            $plan->save();
            return redirect()->route('admin.settings')->with('message','success');
        } catch (\Throwable $th) {
            return redirect()->route('admin.settings')->with('message','error');
        }

    }
    public function saveresponsescategories(Request $request){


        try {
           $category=ResponseCategory::whereid($request->input('cat_id'))->first();
           $category->num=$request->input('num_edit');
           $category->price=$request->input('price_edit');
           $category->save();
            return redirect()->route('admin.settings')->with('message','success');
        } catch (\Throwable $th) {
            return redirect()->route('admin.settings')->with('message','error');
        }

    }
    public function printInvoice($id){


        $invoice = Invoice::whereid($id)->first();
        $account=Account::whereid($invoice->account_id)->first();

        // $pdf = PDF::loadView('pdf.invoice', compact('invoices'));


        // // return redirect()->route('invoicepdf',$id);
        // return response()->streamDownload(function () use($pdf) {
        //     echo $pdf->download('document.pdf');
        // }, 'report.pdf');
        // // return $pdf->download('document.pdf');

        $html = view('pdf.invoice', compact('invoice','account'))->render(); // Assuming you have a blade view file named 'page'

        // Generate the PDF file name
        $filename ='FHINV-'.$invoice->invoice_no;

        // Generate the PDF using Laravel-Dompdf
        $pdf = PDF::loadHTML($html);
        $pdf->setPaper('A4', 'portrait');

        // Download the PDF file
        return response()->streamDownload(function () use($pdf) {
                    echo $pdf->download('document.pdf');
                },$filename.'.pdf');
    }
    // change status of tickets
     public function changestatus(Request $request){

        $ticket=SupportTicket::whereid($request->input('ticket_id'))->first();
        $ticket->status=$request->input('status_select');
        $ticket->save();

        return redirect()->route('admin.supportTickets');
     }
    //  change password
    public function updateAdminInfo(Request $request){

        try
        {
            $admin = Admin::whereid($request->input('admin_id'))->first();
            $admin->name=$request->input('user_name');
            $admin->email=$request->input('email');
            $admin->role=$request->input('role_select');
            if($request->input('changed_password'))
            {
                $admin->password = Hash::make($request->input('password'));
            }
            $admin->save();


                // Auth::logoutOtherDevices( $request->input('password'));



            $this->guard->logout();

            $request->session()->invalidate();

            $request->session()->regenerateToken();

            DB::connection(config('session.connection'))->table(config('session.table', 'sessions'))
            ->where('admin_id', $admin->id)
            ->where('id', '!=', $request->session()->getId())
            ->delete();
            return redirect()->route('admin.login');

        }
        catch (\Throwable $th) {
            return back()->with('status', 'error');
        }


    }
    // admin logout session
    public function adminLogout($id){
        try {
            DB::connection(config('session.connection'))->table(config('session.table', 'sessions'))
            ->where('id', $id)
            ->delete();
            return redirect()->route('admin.settings');

        } catch (\Throwable $th) {
            return back()->with('status', 'error');

        }

    }
    //
    public function changeaccountstatus(Request $request){

        try
        {



             $account=Account::whereid($request->input('accountId'))->first();

             $request->input('status')==null?$account->active=false:$account->active=true;
             $account->save();




            return redirect()->route('admin.settings')->with('message','success');
        }
        catch (\Throwable $th) {
            return redirect()->route('admin.settings')->with('message','error');
        }
    }

    public function checkCodeUnique(Request $request)
    {
        $code = $request->input('code');
        $isUnique = !PromotionCode::where('code', $code)->exists();

        return response()->json(['unique' => $isUnique]);
    }

    // add promo function
    public function addPromocode(Request $request){
        $validatedData = $request->validate([
            'promocodetext' => 'required|unique:promotion_codes,code',
            // Add other validation rules as needed
        ],[
           'promocodetext.unique'=>'The promo code must be unique',
        ]);
        try {
            //code...

            PromotionCode::create([
                'code' => $request->promocodetext,
                'use_type'=>$request->typeuse_select,
                'valid' => $request->filled('valid_checkbox') ? $request->valid_checkbox : false,
                'public' => $request->filled('public_checkbox') ? $request->public_checkbox : false,
                'discount_value' => $request->discount_value,
                'note'=>$request->note,
            ]);
            return redirect()->route('admin.settings')->with('message','success');
        }
        catch (\Throwable $th) {
            dd($th);
            return redirect()->route('admin.settings')->with('message','error');
        }

    }
    public function editPromocode(Request $request){
        try {
            //code...

        $promotionCode = PromotionCode::find($request->promocodeid); // Assuming $id is the ID of the promotion code to update

        $promotionCode->update([
            'code' => $request->promocodetext,
            'use_type' => $request->typeuse_select,
            'valid' => $request->filled('valid_checkbox') ? $request->valid_checkbox : false,
            'public' => $request->filled('public_checkbox') ? $request->public_checkbox : false,
            'discount_value' => $request->discount_value,
            'note' => $request->note,
        ]);
        return redirect()->route('admin.settings')->with('message','success');

    } catch (\Throwable $th) {

        return redirect()->route('admin.settings')->with('message','error');

    }
    }

    public function deletepromocode($id){
        try {
            PromotionCode::find($id)->delete();
            return redirect()->route('admin.settings')->with('message','success');

        } catch (\Throwable $th) {

            return redirect()->route('admin.settings')->with('message','error');

        }

    }



    // devices
    // edit device
    public function editDevice(Request $request){

        try {
            //code...

        $device = TypeDevice::find($request->deviceid); // Assuming $id is the ID of the promotion code to update
         if($request->hasFile('image'))
      {  File::delete(public_path($device->image));
        $imagePath = $request->image->store('images/devices');}
         else
         $imagePath=$device->image;

        $device->update([
            'name' => $request->device_name,
            'model_id' => $request->devicemodel_select,
            'price_prev' => $request->price_before,
            'price' => $request->price_now,
            'image'=>$imagePath,

        ]);
        return redirect()->route('admin.settings')->with('message','success');

    } catch (\Throwable $th) {
            dd($th);
        return redirect()->route('admin.settings')->with('message','error');

    }
    }

    // delete device
    public function deleteDevice($id){
        try {
           $device= TypeDevice::find($id)->first();
            // Storage::delete('images/devices/' . $device->image);
            File::delete(public_path($device->image));

            $device->delete();
            return redirect()->route('admin.settings')->with('message','success');

        } catch (\Throwable $th) {
           dd($th);
            return redirect()->route('admin.settings')->with('message','error');

        }

    }

    //  add device
    public function addDevice(Request $request){

        try {
            if($request->hasFile('image'))
            $imagePath = $request->image->store('images/devices');

            TypeDevice::create([
                'name' => $request->device_name,
                'model_id' => $request->devicemodel_select,
                'price_prev' => $request->price_before,
                'price' => $request->price_now,
                'image'=>$imagePath,
            ]);
            return redirect()->route('admin.settings')->with('message','success');
        }
        catch (\Throwable $th) {
            dd($th);
            return redirect()->route('admin.settings')->with('message','error');
        }
    }


    // add client
    public function addClient(Request $request){
        try {
            if($request->hasFile('image'))
            $imagePath = $request->image->store('images/clients');

            Client::create([

                'client_logo'=>$imagePath,
            ]);
            return redirect()->route('admin.settings')->with('message','success');
        }
        catch (\Throwable $th) {
            dd($th);
            return redirect()->route('admin.settings')->with('message','error');
        }
    }
    // delete client
    public function deleteClient($id){
        try {
           $client= Client::find($id)->first();
            // Storage::delete('images/devices/' . $device->image);
            File::delete(public_path($client->client_logo));

            $client->delete();
            return redirect()->route('admin.settings')->with('message','success');

        } catch (\Throwable $th) {
           dd($th);
            return redirect()->route('admin.settings')->with('message','error');

        }

    }
}


