<?php

namespace FaridBabayev\CBARCurrency\Collections;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;
use Illuminate\Support\Traits\EnumeratesValues;

class CurrencyCollection extends Collection
{
    /**
     * @var self
     */
    private self $selectedCurrency;

    private const FROM_AZN = 'from_azn';
    private const TO_AZN = 'to_azn';

    /**
     * 0 => azn to other , 1 => other to azn
     * @var string
     */
    private string $convertType ;

    /**
     *  Convert currency
     * @param $amount
     * @return float
     * @throws \Throwable
     */
    public function convert($amount = 1): float
    {
        throw_if(is_null($this->selectedCurrency),\Exception::class,'Target currency not found');

        switch ($this->convertType){
            case self::FROM_AZN:
                return $amount * bcdiv('1',(string)$this->selectedCurrency['exchangeRate'],4);
            break;
            case self::TO_AZN:
                return floatval($amount * 1 * $this->selectedCurrency['exchangeRate']);
            break;
            default:
                throw new \Exception('Target currency not found');
        }
    }

    /**
     * @param $code
     * @return $this
     */
    public function toAZN($code)
    {
        $this->findCurrencyByCode($code);
        $this->convertType = self::TO_AZN;
        return $this;
    }

    /**
     * @param $code
     * @return $this
     */
    public function fromAZN($code): self
    {
        $this->findCurrencyByCode($code);
        $this->convertType = self::FROM_AZN;
        return $this;
    }

    /**
     * @param $code
     * @return void
     */
    private function findCurrencyByCode($code): void
    {
        $this->selectedCurrency = $this->where('code',$code)->first() ?? null;
    }
}
