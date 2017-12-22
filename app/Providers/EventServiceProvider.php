<?php

namespace WPTL\Providers;

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
        'Illuminate\Auth\Events\Registered'    => [
            'WPTL\Listeners\AssignDefaultRole',
        ],
        'Illuminate\Auth\Events\Login'         => [
            'WPTL\Listeners\LogSuccessfulLogin',
        ],
        'Illuminate\Auth\Events\Failed'        => [
            'WPTL\Listeners\LogFailedLogin',
        ],
        'Illuminate\Auth\Events\Logout'        => [
            'WPTL\Listeners\LogSuccessfulLogout',
        ],
        'Illuminate\Auth\Events\PasswordReset' => [
            'WPTL\Listeners\LogPasswordReset',
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
