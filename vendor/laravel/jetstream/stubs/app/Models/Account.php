<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Jetstream\Events\AccountCreated;
use Laravel\Jetstream\Events\AccountDeleted;
use Laravel\Jetstream\Events\AccountUpdated;
use Laravel\Jetstream\Account as JetstreamAccount;

class Account extends JetstreamAccount
{
    use HasFactory;

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'personal_account' => 'boolean',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var string<int, string>
     */
    protected $fillable = [
        'name',
        'personal_account',
    ];

    /**
     * The event map for the model.
     *
     * @var array<string, class-string>
     */
    protected $dispatchesEvents = [
        'created' => AccountCreated::class,
        'updated' => AccountUpdated::class,
        'deleted' => AccountDeleted::class,
    ];
}
