<?php

namespace App\Providers;

use App\Events\NewFollower;
use App\Listeners\SendNewFollowerNotification;
use App\Events\NewLike;
use App\Listeners\SendNewLikeNotification;
use App\Events\NewCommentLike;
use App\Listeners\SendNewCommentLikeNotification;
use App\Events\NewComment;
use App\Listeners\SendNewCommentNotification;
use App\Events\NewPostFollowed;
use App\Listeners\SendNewPostFollowedNotification;

use Illuminate\Auth\Events\Registered;
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
        NewFollower::class => [
            SendNewFollowerNotification::class,
        ],
        NewLike::class => [
            SendNewLikeNotification::class,
        ],
        NewCommentLike::class => [
            SendNewCommentLikeNotification::class,
        ],
        NewComment::class => [
            SendNewCommentNotification::class,
        ],
        NewPostFollowed::class => [
            SendNewPostFollowedNotification::class,
        ],
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
