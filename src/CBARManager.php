<?php

namespace FaridBabayev\CBARCurrency;

use Illuminate\Support\Manager;

use FaridBabayev\CBARCurrency\Drivers\DatabaseDriver;
use FaridBabayev\CBARCurrency\Drivers\FileDriver;
use FaridBabayev\CBARCurrency\Drivers\SyncDriver;
use FaridBabayev\CBARCurrency\Drivers\NullDriver;


class CBARManager extends Manager
{

    /**
     * @return string
     */
    public function getDefaultDriver(): string
    {
        return config('cbar.default');
    }

    /**
     * @return DatabaseDriver
     */
    public function createDatabaseDriver(): DatabaseDriver
    {
        return new DatabaseDriver();
    }

    /**
     * @return FileDriver
     */
    public function createFileDriver(): FileDriver
    {
        return new FileDriver();
    }

    /**
     * @return SyncDriver
     */
    public function createSyncDriver(): SyncDriver
    {
        return new  SyncDriver();
    }

    /**
     * @return NullDriver
     */
    public function createNullDriver(): NullDriver
    {
        return new NullDriver();
    }
}
