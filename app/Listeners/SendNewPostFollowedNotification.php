<?php

namespace App\Listeners;

use App\Events\NewPostFollowed;
use App\Notifications\NewPostFollowed as NotificationsNewPostFollowed;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class SendNewPostFollowedNotification
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
     * @param  NewPostFollowed  $event
     * @return void
     */
    public function handle(NewPostFollowed $event)
    {
        Notification::send($event->user->followers, new NotificationsNewPostFollowed($event->user, $event->post));
    }
}
