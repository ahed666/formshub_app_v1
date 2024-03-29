<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Cities;
use App\Models\Countries;
use App\Rules\isvalidPassword;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Laravel\Fortify\Contracts\RegisterResponse;
use Laravel\Fortify\Contracts\RegisterViewResponse;
use App\Actions\Fortify\PasswordValidationRules;
use Illuminate\Validation\Rules\Password;
use ZxcvbnPhp\Zxcvbn;
use Illuminate\Support\Str;
use App\Providers\RouteServiceProvider;

use Illuminate\Http\RedirectResponse;

use Illuminate\Support\Facades\Auth;

use Illuminate\Validation\Rules;
use Illuminate\View\View;
class Multistepsform extends Component
{  use PasswordValidationRules;
    //define variables for register process
   public $countries;
   public $cities;
    public $country;
    public $name;
     public $terms;
    public $email;
    public $phone_number;
    public $mobile_number;
    public $password;
    public $city;
    public $know_about_us;
    public $business_name;
    public $tax_number;
    public $password_confirmation;
    public $receive_emails;
    public $billing_address;
    public $CountryMobileCode;
      public $idCountry;
      //status of show password
    public $show=false;
    //current step (inital 2 beacuse there is one country defult)
    public $currentstep=2;
    //intital strength of password
    public $passwordStrength=0;
    public $isDisabled;
    //password empty status
    public $passwordempty=0;
    // number phone level(0 no valid ,1 valid)
    public $numberphonelevel=0;
    //number phone empty or no
    public $numberphoneempty=0;
    //password confirmed or no
    public $isconfirm=0;


    // confirmed and non confirmed classes
    public $confirmedclass='"border-green-300 caret-green-300  focus:border-green-300 focus:ring focus:ring-green-200
    focus:ring-opacity-50 rounded-md shadow-sm block mt-1 w-full"';
    public $notconfirmedclass='"border-red-300 caret-red-300  focus:border-red-300 focus:ring focus:ring-red-200
    focus:ring-opacity-50 rounded-md shadow-sm block mt-1 w-full"';
    // levels of strength password
    public array $passwordLevels=[

        0 =>'Weak',
        1 =>'Strong',
        2 =>'Strong',
        3 =>'Strong',
        4 =>'Strong',
    ];
    //color to each level
    public array $passwordLevelsColors=[
        0 =>'red',
        1 =>'green',
        2 =>'green',
        3 =>'green',
        4 =>'green',

    ];
    //messages of validation in real time
    public function __construct()
    {


        $this->messages = [
            'required' => trans('auth.required'),
            'integer' => trans('auth.integer'),
            'regex' => trans('auth.regex'),
            'digits' => trans('auth.digits'),
            'email.unique' => trans('auth.email_unique'),
            'email' => trans('auth.email'),
            'email.max' => trans('auth.email_max'),
            'mobile_number.regex' => trans('auth.mobile_number_regex'),
            'password_confirmation.same' => trans('auth.password_confirmation_same'),
            'name.max' => trans('auth.name_max'),
            'phone_number.regex' => trans('auth.phone_number_regex'),
            'phone_number.max' => trans('auth.phone_number_max'),
            'tax_number.max' => trans('auth.tax_number_max'),
            'billing_address' => trans('auth.billing_address'),
            'business_name' => trans('auth.business_name'),
            'password' => trans('auth.password'),
            'password_confirmation' => trans('auth.password_confirmation'),
        ];
    }
    // rules of validation in realtime
    protected $rules = [
             'country' =>['required','string','max:255'],
             'city' => ['required', 'string', 'max:255'],
             'name' => ['required','string','max:35'],
             'email' => ['required', 'string', 'email:rfc,dns', 'max:50', 'unique:users'],
             'mobile_number' => ['required','regex:/((5)[0-9]{8}$)|((05)[0-9]{8}$)/'],


             'password_confirmation' => 'required_with:password|same:password|max:30',
             'password' => 'max:30',
             'phone_number' => [ 'nullable','max:12','regex:/([0-9]{9}$)/'],
             'business_name' => [  'nullable','max:60'],
             'billing_address' => [ 'nullable','max:150'],
             'tax_number' => [ 'nullable','max:20',],


    ];

    public function mount(){
        $this->show=false;
        $this->country="United Arab Emaraties";
        $this->CountryMobileCode="+971";
        $this->isconfirm=0;
        $this->countries=Countries::all();
        $this->cities=Cities::all();
        // $this->receive_emails=false;

        if($this->country=="null" || empty($this->country)){
            $this->currentstep=1;
          $this->isDisabled=true;
           }
  else{
    $this->isDisabled=false;
   $this->currentstep=2;}
//    foreach($this->countries as $country)
//                if($this->country==$country->country)
//                {
//                    $this->idCountry=$country->id;
//                $this->CountryMobileCode=$country->country_code;
//                $this->cities=Cities::wherecountry_id($country->id)->get();
//      }

    }
    public function render()
    { return view('livewire.multistepsform');
    }
    //this to initial status of password show
    public function showpassword(){
        if($this->show==false)
           $this->show=true;
        else
        $this->show=false;
      }
      //to initial status of confirmed password
    public function onchangeconfirmpassword(){
        if($this->password_confirmation!=$this->password){
       $this->isconfirm=0;}
       else{
       $this->validate(['password_confirmation' => 'required_with:password|same:password', ]);
       $this->isconfirm=1;}

    }
 public function onchangepassword(){

     $this->passwordStrength=0;
    $this->validate(['password' => $this->passwordRules(), ]);
    $zxcvbn = new Zxcvbn();
	$strength = $zxcvbn->passwordStrength($this->password);

	$this->passwordStrength = $strength['score'];


 }
//  public function updatedmobile_number($mobile_number){
//     $this->numberphonelevel=0;
//     if($this->mobile_number!=null){
//         $this->validate(['mobile_number'=>['required','regex:/((5)[0-9]{8}$)|((05)[0-9]{8}$)/']]);
//         $this->numberphonelevel=1;
//     }
//  }
//on update password to valid it on real time
 public function updatedpassword($password)

 {  $this->passwordStrength=0;
    if($this->password!=null) $this->passwordempty=1;
    else $this->passwordempty=0;
    $this->validate(['password' => $this->passwordRules(), ]);

    $zxcvbn = new Zxcvbn();
	$strength = $zxcvbn->passwordStrength($password);
	$this->passwordStrength = $strength['score'];



 }
 //this will use if there is more one country
  public function onchangestepone(){


    if($this->country=="null" || empty($this->country)){
             $this->currentstep=1;
           $this->isDisabled=true;
            }
   else{
     $this->isDisabled=false;
    $this->currentstep=2;}
    foreach($this->countries as $country)
                if($this->country==$country->country)
                {
                    $this->idCountry=$country->id;
                $this->CountryMobileCode=$country->country_code;
                $this->cities=Cities::wherecountry_id($country->id)->get();
      }
  }

    // public function increasestep(){


    //     $this->validatedata();

    //     $this->currentstep++;




    // }
    // public function decreasestep(){
    //     $this->resetErrorBag();

    //     $this->currentstep--;
    //     if($this->currentstep<1){
    //         $this->currentstep=1;
    //     }
    // }

    public function updated($propertyName)
    {


        $this->validateOnly($propertyName);

      // if($propertyName!="null" && empty($propertyName)){
        //     $this->isDisabled=false;

        // }
        // else          $this->isDisabled=true;

    }

    public function validatedata(){

        $this->validate();
    }

    // public function register(){

    //    $this->validatedata();
    //     $this->resetErrorBag();
    //     $this->currentstep==1;
    //     //remove zero if first char in mobile number is 0
    //     if($this->mobile_number[0]=='0'){
    //     $this->mobile_number=substr($this->mobile_number,1);}
    //     $user= User::create([
    //         'country'=>$this->country,
    //         'name' => $this->name,
    //         'email' => $this->email,

    //         'phone_number' => $this->phone_number,
    //         'mobile_number' => $this->mobile_number,
    //         'city' => $this->city,
    //         'know_about_us'=>$this->know_about_us,
    //         'company_name' => $this->company_name,

    //         'billing_address' => $this->billing_address,
    //         'tax_number' =>$this->tax_number,
    //         'password' => Hash::make($this->password),
    //         'subscribe'=>(bool)$this->receive_emails,
    //     ]);
    //     event(new Registered($user));

    //        $email=$this->email;




    //      //redirect to next page after registertion
    //         return redirect()->route('responseregister',$user);

    // }
    public function submitForm(){
        $this->validatedata();

    }
}
