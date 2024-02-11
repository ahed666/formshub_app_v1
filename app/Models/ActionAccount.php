<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
class ActionAccount extends Model
{
    use HasFactory;
    protected $table="actions_account";

    public static function actionsOfAccount($id){
        return  self::join('actions', 'actions.id', '=', 'actions_account.action_id')
        ->where('actions_account.account_id', '=', $id)
        ->where('actions_account.dismiss', '=', false)
        ->select('actions.type','actions.description','actions_account.*')->get();

    }


}
