<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class SupportTicket extends Model
{
    use HasFactory;
    protected $table="support_tickets";




    public static function ticketsByStatus($accountId)
    {
        // Define an array of all predefined status values
        $allStatus = ['Open', 'In Progress', 'Closed', 'Pending'];

        // Query the database to count the occurrences of each status
        $statusCounts = DB::table('support_tickets')
            ->select('status', DB::raw('COUNT(*) as count'))
            ->whereIn('status', $allStatus)
            ->where('account_id','=',$accountId)
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
    public static function AllTicketsByStatus()
    {
        // Define an array of all predefined status values
        $allStatus = ['Open', 'In Progress', 'Closed', 'Pending'];

        // Query the database to count the occurrences of each status
        $statusCounts = DB::table('support_tickets')
            ->select('status', DB::raw('COUNT(*) as count'))
            ->whereIn('status', $allStatus)
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
