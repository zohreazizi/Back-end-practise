<?php

namespace App\Jobs;

use App\Models\Reserve;
use App\Models\Ride;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class DeleteReservation implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $reservation;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Reserve $reservation)
    {
        $this->reservation = $reservation;
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $expiredReservation = Reserve::query()->find($this->reservation->id);
        $expiredReservation->delete();
    }

}
