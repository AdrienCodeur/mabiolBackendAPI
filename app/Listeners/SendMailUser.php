<?php

namespace App\Listeners;

use App\Events\RegisterUser;
use App\Mail\RegisterUserMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailer;
use Illuminate\Queue\InteractsWithQueue;

class SendMailUser
{
    /**
     * Create the event listener.
     */
    public function __construct( private Mailer $mailer)
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(RegisterUser $event): void
    {
         $this->mailer->send(new  RegisterUserMail($event->user))  ;
    }
}
