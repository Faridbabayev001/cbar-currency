<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Default CBAR Connection Name
    |--------------------------------------------------------------------------
    |
    */

    'default' => env('CBAR_CONNECTION', 'sync'),

    /*
   |--------------------------------------------------------------------------
   | CBAR Connections
   |--------------------------------------------------------------------------
   |
   | Drivers: "sync", "database", "file" , "null"
   |
   */

    'connections' => [

        'sync' => [
            'driver' => 'sync',
        ],

        'database' => [
            'driver' => 'database',
            'refresh_table' => true
        ],

        'file' => [
            'driver' => 'file',
            'xml_path' => public_path('currencies'),
            'remove_old_xml' => true
        ],

    ],
];
