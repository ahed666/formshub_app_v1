<?php

namespace App\Actions\Fortify;

use App\Models\Account;
use App\Models\User;
use App\Models\Subscribe;
use App\Models\SubscribePlan;
use App\Models\TypeSubscribe;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;
use Carbon\Carbon;
use Illuminate\Support\Str;
class CreateNewUser implements CreatesNewUsers
{    public $input;
    use PasswordValidationRules;

    /**
     * Create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {

        $this->input=$input;
           
        Validator::make($input, [
            'name' => ['required', 'string', 'max:35'],
            'email' => ['required', 'string', 'email:rfc,dns', 'max:50', 'unique:users'],
            'password' => $this->passwordRules(),
            'password_confirmation' => 'required_with:password|same:password|max:30',

            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',

            'country' =>['required','string','max:255'],
            'city' => ['required', 'string', 'max:255'],
            'mobile_number' => ['nullable','regex:/((5)[0-9]{8}$)|((05)[0-9]{8}$)/'],
            'phone_number' => [ 'nullable','max:12','regex:/([0-9]{9}$)/'],
            'business_name' => [  'nullable','max:60'],
            'billing_address' => [ 'nullable','max:150'],
            'tax_number' => [ 'nullable','max:20',],
        ],[
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
        ])->validate();


        return DB::transaction(function () use ($input) {
                $mobileNumber=$this->formatMobileNumber($input['CountryMobileCode'],$input['mobile_number']);
            return tap(User::create([
                'name' => $input['name'],
                'email' => $input['email'],
                'password' => Hash::make($input['password']),
                'timezone'=>$input['timezone'],
                'unsubscribe_token'=>Str::random(100),
                'mobile_number'=>$mobileNumber,
            ]), function (User $user) {

                $this->createAccount($user);

            });
        });

    }

    // format mobile number
    protected function formatMobileNumber($code, $mobilenumber)
{
    if (!is_null($mobilenumber)) {
        if (substr($mobilenumber, 0, 1) === '0') {
            $mobilenumber = substr($mobilenumber, 1);
        }

        return $code . $mobilenumber;
    }

    return null;
}

    /**
     * Create a personal account for the user.
     */
    protected function createAccount(User $user): void
    {
        if($this->input['business_name']!=null)
            $name =$this->input['business_name']."(".explode(' ', $user->name, 2)[0].")";
        else
            $name =explode(' ', $user->name, 2)[0];

        $user->ownedAccounts()->save(Account::forceCreate([
            'user_id' => $user->id,


            'personal_account' => true,
            'business_name'=>$this->input['business_name'],
            'billing_address'=>$this->input['billing_address'],
            'tax_number'=>$this->input['tax_number'],
            'city'=>$this->input['city'],
            'know_about_us'=>$this->input['know_about_us'],
            'phone_number'=>$this->input['phone_number'],
            'country'=>$this->input['country'],
        ]));

        $account_id=Account::whereuser_id($user->id)->first()->id;
        $dt = Carbon::today();
        $dt=$dt->addYear();

        $subscribe=new SubscribePlan();
        $freeplan=TypeSubscribe::whereorder_plan('1')->first();
        $subscribe->expired_at=Carbon::today()->addQuarter();
        $subscribe->start_date=Carbon::today();
        $subscribe->account_id=$account_id;
        $subscribe->valid=true;
        $subscribe->active=true;
        $subscribe->num_of_responses=env('NUM_OF_RESPONSES_FREE', 500);
        $subscribe->type_of_subscription_id=$freeplan->id;
        $subscribe->save();



    }
}
