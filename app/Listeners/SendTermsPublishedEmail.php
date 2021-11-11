<?php

namespace App\Listeners;

use App\Events\TermsPublished;
use App\Mail\TermsUpdated;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class SendTermsPublishedEmail
{
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
     * @param  TermsPublished  $event
     * @return void
     */
    public function handle(TermsPublished $event)
    {

        $users = User::all();
        foreach ($users as $user) {

            Mail::to($user->email)->send(new TermsUpdated());
        }


    }
}
