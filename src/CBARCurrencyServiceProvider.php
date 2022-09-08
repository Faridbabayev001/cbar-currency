<?php

namespace FaridBabayev\CBARCurrency;

use Illuminate\Support\ServiceProvider;

class CBARCurrencyServiceProvider extends ServiceProvider
{

    /**
     * @return void
     */
    public function  register(): void
    {
        $this->app->singleton('cbar', function ($app) {
            return new CBARManager($app);
        });

        $this->mergeConfigFrom(__DIR__.'/config/cbar.php','cbar');
    }

    /**
     * @return void
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()){
            if (! class_exists('CreatePostsTable')) {
                $this->publishes([
                    __DIR__ . '/database/migrations/2022_08_08_100000_create_currencies_table.php' => database_path('migrations/' . date('Y_m_d_His', time()) . '_create_currencies_table.php'),
                ], 'migrations');
            }

            $this->publishes([
                __DIR__.'/config/cbar.php' => config_path('cbar.php')
            ],'config');
        }
    }
}
