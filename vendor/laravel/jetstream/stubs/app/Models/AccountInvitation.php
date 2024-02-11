<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laravel\Jetstream\Jetstream;
use Laravel\Jetstream\AccountInvitation as JetstreamAccountInvitation;

class AccountInvitation extends JetstreamAccountInvitation
{
    /**
     * The attributes that are mass assignable.
     *
     * @var string<int, string>
     */
    protected $fillable = [
        'email',
        'role',
    ];

    /**
     * Get the account that the invitation belongs to.
     */
    public function account(): BelongsTo
    {
        return $this->belongsTo(Jetstream::accountModel());
    }
}
