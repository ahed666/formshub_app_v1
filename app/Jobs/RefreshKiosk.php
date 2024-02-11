<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Events\DeviceRefresh;
use App\Models\Kiosk;

class RefreshKiosk implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $kiosk;

    public function __construct(Kiosk $kiosk)
    {
        $this->kiosk = $kiosk;
    }

    public function handle()
    {

        // Your refresh logic for the kiosk goes here
        // For example: $this->kiosk->refresh();
        event(new DeviceRefresh( $this->kiosk->url, $this->kiosk->device_code_id));

    }
}
