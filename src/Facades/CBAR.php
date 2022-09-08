<?php

namespace FaridBabayev\CBARCurrency\Facades;

use Illuminate\Support\Facades\Facade;

class CBAR extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'cbar';
    }
}
