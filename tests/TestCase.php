<?php

namespace FaridBabayev\CBARCurrency\Tests;

use FaridBabayev\CBARCurrency\CBARCurrencyServiceProvider;
use FaridBabayev\CBARCurrency\Facades\CBAR;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TestCase extends \Orchestra\Testbench\TestCase
{
    use RefreshDatabase;

    protected $currencyDate = '18.05.2022';

    protected function getPackageProviders($app)
    {
        return [
            CBARCurrencyServiceProvider::class
        ];
    }

    protected function getApplicationTimezone($app)
    {
        return 'Asia/Baku';
    }

    /**
     * Define database migrations.
     *
     * @return void
     */
    protected function defineDatabaseMigrations()
    {
        $this->loadMigrationsFrom(realpath('./src/database/migrations'));
        $migrationsPath = realpath('./src/database/migrations');

        $this->artisan('migrate', [
            '--database' => 'testbench',
            '--realpath' => $migrationsPath,
        ])->run();

        $this->beforeApplicationDestroyed(function () use($migrationsPath) {
            $this->artisan('migrate:rollback', [
                    '--database' => 'testbench',
                    '--realpath' => $migrationsPath,
                ]
            )->run();
        });
    }

    protected function getEnvironmentSetUp($app)
    {
        # Setup default database to use sqlite :memory:
        $app['config']->set('database.connections.testbench', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);
        $app['config']->set('database.default', 'testbench');
    }
}
