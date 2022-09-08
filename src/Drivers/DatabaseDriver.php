<?php

namespace FaridBabayev\CBARCurrency\Drivers;

use FaridBabayev\CBARCurrency\Collections\CurrencyCollection;
use FaridBabayev\CBARCurrency\Exceptions\TableNotFoundException;
use FaridBabayev\CBARCurrency\Models\Currency;
use Illuminate\Database\QueryException;

class DatabaseDriver extends Driver
{
    /**
     *  Load currencies from database
     * @return CurrencyCollection
     */
    public function currencies(): CurrencyCollection
    {
        $currencies = $this->getCurrenciesByDate();

        return $currencies->isNotEmpty() ? $currencies : $this->saveAndGetCurrencies();
    }

    /**
     *  Get currencies by selected date
     * @return CurrencyCollection
     */
    private function getCurrenciesByDate(): CurrencyCollection
    {
        try {
            return  Currency::where('date',$this->currencyDate)->get();
        } catch (\Throwable $exception) {
          $this->throwTableNotFoundException($exception);
        }
    }

    /**
     *   Parse xml data after send request and save database
     * @return CurrencyCollection
     */
    private function saveAndGetCurrencies(): CurrencyCollection
    {
        $currencies = $this->getDataFromXml();

        try {
            if (config('cbar.connections.database.refresh_table')) {
                Currency::truncate();
            }

            Currency::insert($currencies->toArray());
        }catch (\Throwable $exception){
            $this->throwTableNotFoundException($exception);
        }

        return $this->getCurrenciesByDate();
    }

    /**
     * @param \Exception $exception
     * @return void
     * @throws \Throwable
     */
    private function throwTableNotFoundException(\Throwable $exception): void
    {
        throw_if(
            $exception instanceof QueryException,
            TableNotFoundException::class,
            'Table not found. Please run  [ php artisan vendor:publish --provider="FaridBabayev\CBARCurrency\CBARCurrencyServiceProvider" --tag="migration" ] and [ php artisan migrate ]'
        );
    }
}
