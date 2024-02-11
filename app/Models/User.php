<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Jetstream\HasAccounts;
use Laravel\Sanctum\HasApiTokens;
use App\Models\SubscribePlan;
use App\Models\TypeSubscribe;
use Illuminate\Support\Facades\DB;
class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use HasAccounts;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string<int, string>
     */
    protected $fillable = [
        'name', 'email', 'password','subscribe','mobile_number','timezone',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];
    public static function userVerifiy(){
        return self::select(
            DB::raw('CASE WHEN email_verified_at IS NOT NULL THEN "Verified" ELSE "Non-Verified" END AS property'),
            DB::raw('COUNT(*) as count')
        )
        ->groupBy('property')
        ->get();

  }
  public static function userEmailsSubscriptions(){
    return [
        'E.S Notification' =>count(self::whereemail_sub_notification(true)->get()),
        'E.S Events' => count(self::whereemail_sub_offers_events(true)->get()),
        'E.S Security'=>count(self::whereemail_sub_security(true)->get()),
        'E.S Payment'=>count(self::whereemail_sub_payment_subscriptions(true)->get()),
    ];




}
  public static function userInfo(){
    $userVerifiy=self::userVerifiy();
    $userEmailsSubscriptions=self::userEmailsSubscriptions();
    $userCount=self::all()->count();
    // Create the array
    $users = [
        'userVerifiy' => $userVerifiy,
        'userEmailsSubscriptions'=>$userEmailsSubscriptions,
        'userCount'=>$userCount
    ];
    return $users;
}
}
