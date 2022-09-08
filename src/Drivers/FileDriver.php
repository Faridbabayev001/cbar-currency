<?php

namespace FaridBabayev\CBARCurrency\Drivers;

use DirectoryIterator;
use FaridBabayev\CBARCurrency\Collections\CurrencyCollection;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class FileDriver extends Driver
{
    /**
     * @return CurrencyCollection
     * @throws \Throwable
     */
    public function currencies(): CurrencyCollection
    {
        return $this->checkXmlFile() ? $this->getXmlDataFromFile() : $this->saveAndLoadXml();
    }

    /**
     * @return CurrencyCollection
     * @throws \Throwable
     */
    private function saveAndLoadXml(): CurrencyCollection
    {
        $xmlData = $this->fetchData();

        file_put_contents($this->getXmlPath(),$xmlData->asXML());

        $this->deleteOldXmlFiles();

        return $this->getDataFromXml($xmlData);
    }

    /**
     * @return CurrencyCollection
     * @throws \Throwable
     */
    private function getXmlDataFromFile(): CurrencyCollection
    {
        $this->deleteOldXmlFiles();
        $xmlData = simplexml_load_string($this->getXmlContent());
        return $this->getDataFromXml($xmlData);
    }

    /**
     * @return string
     * @throws \Throwable
     */
    private function getXmlContent(): string
    {
        $content = file_get_contents($this->getXmlPath());

        throw_if(
            false === $content,
            FileException::class,
            sprintf('Could not get the content of the file "%s".', $this->getXmlPath())
        );

        return $content;
    }

    /**
     *  Remove old files when remove_old_xml is true from config
     * @return void
     */
    private function deleteOldXmlFiles(): void
    {
        if (config('cbar.connections.file.remove_old_xml')) {
            foreach (new DirectoryIterator(config('cbar.connections.file.xml_path')) as $fileInfo) {
                if(!$fileInfo->isDot() && $fileInfo->getFileName() !== $this->currencyDate.'.xml') {
                    unlink($fileInfo->getPathname());
                }
            }
        }
    }

    /**
     *  Check exists xml file
     * @return bool
     */
    private function checkXmlFile(): bool
    {
        $this->checkXmlPath();
        return file_exists($this->getXmlPath());
    }

    /**
     * Check xml path for xml file. When folder not found. Create new folder.
     * @return void
     */
    private function checkXmlPath(): void
    {
        if (!file_exists(config('cbar.connections.file.xml_path'))){
            mkdir(config('cbar.connections.file.xml_path'),0755,true);
        }
    }

    /**
     *  Get xml path.
     * @return string
     */
    private function getXmlPath(): string
    {
        return config('cbar.connections.file.xml_path').DIRECTORY_SEPARATOR.$this->currencyDate.'.xml';
    }
}
