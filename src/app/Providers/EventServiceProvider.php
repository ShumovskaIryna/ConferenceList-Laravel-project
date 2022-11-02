<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use App\Events\EditReportTimeEvent;
use App\Events\DeleteReportEvent;
use App\Events\AddCommentEvent;
use App\Events\AddListenerEvent;
use App\Events\AddAnnouncerEvent;
use App\Events\DeleteConferenceEvent;
use App\Listeners\EditReportTimeEventHandler;
use App\Listeners\DeleteReportEventHandler;
use App\Listeners\AddCommentEventHandler;
use App\Listeners\AddListenerEventHandler;
use App\Listeners\AddAnnouncerEventHandler;
use App\Listeners\DeleteConferenceEventHandler;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        AddCommentEvent::class => [
            AddCommentEventHandler::class
        ],
        AddListenerEvent::class => [
            AddListenerEventHandler::class
        ],
        AddAnnouncerEvent::class => [
            AddAnnouncerEventHandler::class
        ],
        DeleteConferenceEvent::class => [
            DeleteConferenceEventHandler::class
        ],
        DeleteReportEvent::class => [
            DeleteReportEventHandler::class
        ],
        EditReportTimeEvent::class => [
            EditReportTimeEventHandler::class
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

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return true;
    }
}
