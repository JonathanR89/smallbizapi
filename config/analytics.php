<?php

return [

    /*
     * The view id of which you want to display data.
     */
    'view_id' => '10812592',

// 161456901
    /*
     * Path to the client secret json file. Take a look at the README of this package
     * to learn how to get this file.
     */
    //  'service_account_credentials_json' => storage_path('app/analytics/smallbizcrm-f386b5059421.json'),
    'service_account_credentials_json' => storage_path('app/analytics/smallbizcrm-188215.json'),

    /*
     * The amount of minutes the Google API responses will be cached.
     * If you set this to zero, the responses won't be cached at all.
     */
    'cache_lifetime_in_minutes' => 1,

    /*
     * Here you may configure the "store" that the underlying Google_Client will
     * use to store it's data.  You may also add extra parameters that will
     * be passed on setCacheConfig (see docs for google-api-php-client).
     *
     * Optional parameters: "lifetime", "prefix"
     */
    'cache' => [
        'store' => 'file',
    ],
];
