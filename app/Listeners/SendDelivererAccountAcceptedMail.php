<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;
use App\Mail\DelivererWelcomeMail;
use App\User;

class SendDelivererAccountAcceptedMail
{
    private $user;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $this->user = $event->deliverer;
        return Mail::to($this->user->email)->send(new DelivererWelcomeMail($this->user));
    }
}
