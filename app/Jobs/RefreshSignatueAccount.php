<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Events\RefreshSignatue;
class RefreshSignatueAccount implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $account_id;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($account_id)
    {
       $this->account_id=$account_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        event(new RefreshSignatue($this->account_id));
    }
}
