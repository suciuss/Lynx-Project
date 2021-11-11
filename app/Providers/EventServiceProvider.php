<?php

namespace App\Providers;

use App\Events\TermsPublished;
use App\Listeners\Auth\LogVerifiedUser;
use App\Listeners\SendTermsPublishedEmail;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Events\Verified;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],

        Verified::class => [
            LogVerifiedUser::class,
        ],

        TermsPublished::class => [
            SendTermsPublishedEmail::class,
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
