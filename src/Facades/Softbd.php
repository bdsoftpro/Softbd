<?php

namespace SBD\Softbd\Facades;

use Illuminate\Support\Facades\Facade;

class Softbd extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'softbd';
    }
}
