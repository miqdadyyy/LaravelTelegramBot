<?php

namespace Miqdadyyy\LaravelTelegramBot\Facades;

use Illuminate\Support\Facades\Facade;

class LaravelTelegramBot extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'laraveltelegrambot';
    }
}
