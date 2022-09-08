<?php

namespace FaridBabayev\CBARCurrency\Drivers;

use FaridBabayev\CBARCurrency\Collections\CurrencyCollection;
use FaridBabayev\CBARCurrency\Contracts\CurrencyInterface;
use FaridBabayev\CBARCurrency\Exceptions\XmlParseErrorException;
use SimpleXMLElement;

abstract class Driver implements CurrencyInterface
{
    /**
     * @var string
     */
    protected string $apiEndpoint = "https://cbar.az/currencies/{date}.xml";

    /**
     * @var string
     */
    protected string $regexPattern = "/({date})/";

    /**
     * @var string|null
     */
    protected ?string $currencyDate = null;

    public function __construct($currencyDate = null)
    {
        $this->from($currencyDate);
    }

    /**
     *  Set date for xml data
     * @param $currencyDate
     * @return $this
     */
    public function from($currencyDate = null): self
    {
        $currencyDate = !is_null($currencyDate)
            ? date('d.m.Y',strtotime($currencyDate))
            : date('d.m.Y');

        $this->currencyDate = $currencyDate;

        return $this;
    }

    /**
     *  Replace and generate api endpoint url
     * @return string
     */
    protected function getApiUrl(): string
    {
        return preg_replace($this->regexPattern,$this->currencyDate,$this->apiEndpoint);
    }

    /**
     * Parse xml data and convert to collection
     * @param $xmlData
     * @return CurrencyCollection
     * @throws \Throwable
     */
    protected function getDataFromXml($xmlData = null): CurrencyCollection
    {
        $currencyData = !is_null($xmlData) ? $xmlData : $this->fetchData();
        $currencies = new CurrencyCollection();
        $currencies->push( new CurrencyCollection(['date' => $this->currencyDate,'code' => 'AZN', 'name' =>'AZN','nominal' => 1,'exchangeRate' => 1.0]));

        foreach ($currencyData->xpath('/ValCurs/ValType') as $valTypes) {
            foreach ($valTypes as $valute) {
                $value = doubleval(str_replace(',', '.', $valute->Value));
                $currencies->push(new CurrencyCollection([
                    'date' => $this->currencyDate,
                    'code' => (string) $valute->attributes()['Code'],
                    'name' => (string) $valute->Name,
                    'nominal' => (int) $valute->Nominal,
                    'exchangeRate' =>  $value / (int) $valute->Nominal,
                ]));
            }
        }

        return $currencies;
    }

    /**
     * Send request to api endpoint
     * @return SimpleXMLElement
     * @throws \Throwable
     */
    protected function fetchData(): SimpleXMLElement
    {
        $response = @simplexml_load_file($this->getApiUrl());

        throw_if(
            false === $response,
            XmlParseErrorException::class,
            sprintf('Error parsing file ("%s") on line (%s) : %s',
                @libxml_get_last_error()->file,
                @libxml_get_last_error()->line,
                @libxml_get_last_error()->message
            )
        );

        return $response;
    }
}
