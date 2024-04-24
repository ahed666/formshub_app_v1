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
    public function getCountOfActions($account_id)
    {
        return $this->leftJoin('actions_account', function ($join) use ($account_id) {
                $join->on('actions.id', '=', 'actions_account.action_id')
                    ->where('actions_account.account_id', '=', $account_id);
            })
            ->where('actions_account.dismiss', '=', false)
            ->count();
    }
    public function getAllEnabledActions($account_id,$numResponsesToday, $current_subscribe, $numForms, $numKiosks, $Todos)
{
    $actions = $this->getAllActionsWithDismissalStatus($account_id);

    $enabledActions = $actions->filter(function ($action) use ($numResponsesToday, $current_subscribe, $numForms, $numKiosks, $Todos) {
        if ($action->type == "responses_today" && $numResponsesToday > 0 && ($action->dismiss == null || $action->dismiss != true)) {
            $action->desc = __('main.responsesgotaction', ['numResponsesToday' => $numResponsesToday]);
            return true;
        } elseif ($action->type == "subscription_expired" && $current_subscribe->expired_at->isPast() && $current_subscribe->valid && ($action->dismiss == null || $action->dismiss != true)) {
            return true;
        } elseif ($action->type == "account_locked" && $current_subscribe->expired_at->isPast() && $current_subscribe->valid == false && ($action->dismiss == null || $action->dismiss != true)) {
            return true;
        } elseif ($action->type == "no_forms" && $numForms == 0 && ($action->dismiss == null || $action->dismiss != true)) {
            return true;
        } elseif ($action->type == "no_kiosks" && $numKiosks == 0 && ($action->dismiss == null || $action->dismiss != true)) {
            return true;
        } elseif ($action->type == "less_than_minimum_responses" && $current_subscribe->num_of_responses <= 100 && $current_subscribe->num_of_responses > 0 && ($action->dismiss == null || $action->dismiss != true)) {
            return true;
        } elseif ($action->type == "outof_responses" && $current_subscribe->num_of_responses == 0 && ($action->dismiss == null || $action->dismiss != true)) {
            return true;
        } elseif ($action->type == "open_tasks" && $Todos['Open'] > 0 && ($action->dismiss == null || $action->dismiss != true)) {
            return true;
        }

        return false;
    });

    return $enabledActions;
}
}
