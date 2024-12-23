<?php

/*
 * Matteo Salonia's custom blocker implementation
*/

return [
    /*
    |--------------------------------------------------------------------------
    | AbuseIPDB key
    |--------------------------------------------------------------------------
    |
    | If you want to block bad/malicious servers using AbuseIPDB,
    | set the ABUSEIPDB_KEY variable to your APIv2 key in .env
    |
    */
    'abuseipdb_key' => env('ABUSEIPDB_KEY', false),

    // Percentage threshold, over which an IP is considered malicious (bad)
    /*
    |--------------------------------------------------------------------------
    | Score threshold (percentage)
    |--------------------------------------------------------------------------
    |
    | The minimum percentage score required for an IP to be considered malicious.
    |
    */
    'threshold' => env('ABUSEIPDB_THRESHOLD', 35),

    /*
    |--------------------------------------------------------------------------
    | Ignore AbuseIPDB whitelist
    |--------------------------------------------------------------------------
    |
    | Set to 1 to ignore AbuseIPDB whitelist.
    |
    */
    'ignore_whitelist' => env('ABUSEIPDB_IGNORE_WHITELIST', 0),

    /*
    |--------------------------------------------------------------------------
    | Cache TTL
    |--------------------------------------------------------------------------
    |
    | How long to keep the value in the cache (time in minutes)
    |
    */
    'cache_ttl' => env('ABUSEIPDB_CACHE_TTL', 15),

    /*
    |--------------------------------------------------------------------------
    | IP_OK value
    |--------------------------------------------------------------------------
    |
    | Which value to store in the cache for a known good IP
    |
    */
    'ip_ok' => env('ABUSEIPDB_IP_OK', 'OK'),

    /*
    |--------------------------------------------------------------------------
    | IP_BAD value
    |--------------------------------------------------------------------------
    |
    | Which value to store in the cache for a known bad IP
    |
    */
    'ip_bad' => env('ABUSEIPDB_IP_BAD', 'BAD'),
];
