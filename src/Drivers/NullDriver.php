<?php

namespace FaridBabayev\CBARCurrency\Drivers;

use FaridBabayev\CBARCurrency\Collections\CurrencyCollection;

class NullDriver extends Driver
{

    /**
     *  Return empty collection
     * @return CurrencyCollection
     */
    public function currencies()
    {
        return new CurrencyCollection();
    }
}
