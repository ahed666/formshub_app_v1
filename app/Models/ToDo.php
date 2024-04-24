<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Form;
use App\Models\Responses;
use Illuminate\Support\Facades\DB;

class ToDo extends Model
{
    use HasFactory;
    protected $table="todos";

    public static function Todos($id)
    {
        $todos = static::join('responses', 'responses.id', '=', 'todos.response_id')
            ->join('forms', 'forms.id', '=', 'responses.form_id')
            ->where('forms.id', $id) // Replace 'your_column_name' with the actual column name to filter by
            ->get();

        return $todos->count();
    }
    // get todos for account
    public static function getToDos($account_id){
        return self::whereaccess_account_id($account_id)
     ->leftJoin('responses','responses.id','=','todos.response_id')
     ->leftJoin('forms','forms.id','=','responses.form_id')
     ->join('users','users.id','=','todos.user_id')->orderBy('todos.created_at', 'desc')
     ->select('todos.*','responses.id as response_id','responses.response_language','forms.form_title','forms.id as form_id','users.name as user_name')->get();
    }
    public static function todosByStatus($accountId)
    {
        // Define an array of all predefined status values
        $allStatus = ['Open', 'In Progress', 'Closed', 'Pending'];

        // Query the database to count the occurrences of each status
        $statusCounts = DB::table('todos')
            ->select('status', DB::raw('COUNT(*) as count'))
            ->whereIn('status', $allStatus)
            ->where('access_account_id','=',$accountId)
            ->groupBy('status')
            ->get();

        // Create an associative array with default counts of 0
        $statusCountsMap = array_fill_keys($allStatus, 0);

        // Update the counts based on the database query
        foreach ($statusCounts as $statusCount) {
            $statusCountsMap[$statusCount->status] = $statusCount->count;
        }

        return $statusCountsMap;
    }
}
