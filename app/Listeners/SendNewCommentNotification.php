<?php

namespace App\Listeners;

use App\Events\NewComment;
use App\Notifications\NewComment as NotificationsNewComment;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;

class SendNewCommentNotification
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
     * @param  NewComment  $event
     * @return void
     */
    public function handle(NewComment $event)
    {
        DB::table('notifications')
            ->where("data->tipo", "commentPost")
            ->where("data->post", $event->post->id)
            ->where("data->user->id", $event->user->id)
            ->delete();

        $event->post->user->notify(new NotificationsNewComment($event->post, $event->user, $event->comment));
    }
}
