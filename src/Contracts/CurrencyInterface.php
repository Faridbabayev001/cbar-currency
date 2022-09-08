<?php

namespace FaridBabayev\CBARCurrency\Contracts;

use FaridBabayev\CBARCurrency\Collections\CurrencyCollection;

/**
 * CurrencyInterface.
 */
interface CurrencyInterface
{
    /**
     *  Get currencies
     * @return CurrencyCollection
     */
    public function currencies(): CurrencyCollection;
}
