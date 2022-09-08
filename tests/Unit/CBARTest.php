<?php

namespace FaridBabayev\CBARCurrency\Tests\Unit;

use FaridBabayev\CBARCurrency\Facades\CBAR;
use FaridBabayev\CBARCurrency\Tests\TestCase;
use Illuminate\Testing\TestResponse;

class CBARTest extends TestCase
{
    /**
     * @return TestResponse
     */
    public function test_default_sync_driver()
    {
        $currencies = CBAR::from($this->currencyDate)->currencies();
        return $this->testCurrencyDataStructure($currencies);
    }

    /**
     * @return TestResponse
     */
    public function test_database_driver()
    {
        $currencies = CBAR::driver('database')->from($this->currencyDate)->currencies();
        return $this->testCurrencyDataStructure($currencies);
    }

    /**
     * @return TestResponse
     */
    public function test_file_driver()
    {
        $currencies = CBAR::driver('file')->from($this->currencyDate)->currencies();
        return $this->testCurrencyDataStructure($currencies);
    }

    /**
     * @return void
     */
    public function test_convert_currency_from_usd_to_azn()
    {
        $currencies = CBAR::from($this->currencyDate)->currencies();
        $convertedCurrency = $currencies->toAZN('USD')->convert();
        $this->assertEquals($convertedCurrency,1.7);
    }

    /**
     * @return void
     */
    public function test_convert_currency_from_azn_to_usd()
    {
        $currencies = CBAR::from($this->currencyDate)->currencies();
        $convertedCurrency = $currencies->fromAZN('USD')->convert();
        $this->assertEquals($convertedCurrency,0.5882);
    }

    /**
     *  Check currency data json data structure
     * @param $currencyData
     * @return TestResponse
     */
    private function testCurrencyDataStructure($currencyData)
    {
        $testResponse = new TestResponse(response()->json($currencyData->toArray()));
        return $testResponse->assertJsonStructure([
            '*' => [
                'date',
                'code',
                'name',
                'nominal',
                'exchangeRate',
            ]
        ]);
    }

}
