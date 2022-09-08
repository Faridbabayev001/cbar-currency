<?php
namespace FaridBabayev\CBARCurrency\Drivers;

use FaridBabayev\CBARCurrency\Collections\CurrencyCollection;

class SyncDriver extends Driver
{
    /**
     * Load currencies from api endpoint
     * @return CurrencyCollection
     * @throws \Throwable
     */
    public function currencies(): CurrencyCollection
    {
       return $this->getDataFromXml();
    }
}
