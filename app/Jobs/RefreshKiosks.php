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
use App\Events\RefreshKiosksCompleted;
class RefreshKiosks implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $kiosks;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $kiosks)
    {
        //
        $this->kiosks = $kiosks;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
        public function handle()
        {
            //
            try {

                for ($i=0; $i < count($this->kiosks); $i++) {
                event(new DeviceRefresh( $this->kiosks[$i]['url'], $this->kiosks[$i]['device_code_id']));
                }
                $response=['status' => 'success'];

            } catch (\Throwable $th) {
                $response= ['status' => 'error'];
            }


            return $response;

        }
}
