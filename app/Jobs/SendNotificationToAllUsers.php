<?php

namespace App\Jobs;

use App\Models\User;
use App\Notifications\OfferNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendNotificationToAllUsers implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $offer;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($offer)
    {
        $this->offer = $offer;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $users = User::all();
        foreach ($users as $user) {
            $user->notify(new OfferNotification($this->offer));
        }
    }
}
