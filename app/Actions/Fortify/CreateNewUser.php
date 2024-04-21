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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email:rfc,dns', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'password_confirmation' => 'required_with:password|same:password|max:30',

            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();


        return DB::transaction(function () use ($input) {

            return tap(User::create([
                'name' => $input['name'],
                'email' => $input['email'],
                'password' => Hash::make($input['password']),
                'timezone'=>$input['timezone'],
                'unsubscribe_token'=>Str::random(100),
                'mobile_number'=>$input['mobile_number'],
            ]), function (User $user) {

                $this->createAccount($user);

            });
        });

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
        $subscribe->num_of_responses=$freeplan->num_responses;
        $subscribe->type_of_subscription_id=$freeplan->id;
        $subscribe->save();



    }
}
