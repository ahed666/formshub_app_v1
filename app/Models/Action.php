<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Action extends Model
{
    use HasFactory;
    protected $table="actions";
    public function actionAccounts()
    {
        return $this->hasMany(ActionAccount::class);
    }

    // Custom method to retrieve all actions with dismissal status for a specific account
    public function getAllActionsWithDismissalStatus($account_id)
    {
        return $this->leftJoin('actions_account', function ($join) use ($account_id) {
                $join->on('actions.id', '=', 'actions_account.action_id')
                    ->where('actions_account.account_id', '=', $account_id);
            })
            ->addSelect(['actions.*','actions_account.dismiss'])
            ->get();
    }
}
