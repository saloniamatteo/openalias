<?php

/*
 * Matteo Salonia's request blocker (CheckRequest Middleware)
*/

return [
    /*
    |--------------------------------------------------------------------------
    | Cache TTL
    |--------------------------------------------------------------------------
    |
    | How long to keep the value in the cache (time in minutes)
    |
    */
    'cache_ttl' => env('CHECKREQUEST_CACHE_TTL', 15),

    /*
    |--------------------------------------------------------------------------
    | Blocked methods list
    |--------------------------------------------------------------------------
    |
    | This list contains all blocked HTTP methods.
    | Comment those methods that are actually used.
    |
    */
    'methods' => [
        'CONNECT',
        'DELETE',
        'HEAD',
        'OPTIONS',
        'PATCH',
        'PUT',
        'TRACE',
    ],

    /*
    |--------------------------------------------------------------------------
    | Blocked paths list
    |--------------------------------------------------------------------------
    |
    | This list contains all blocked paths.
    | Make sure all paths end with an asterisk! (*)
    | Please review this list if you use paths that differ from this website.
    |
    */
    'paths' => [
        // Common files
        "*.csv*",
        "*.env*",
        "*.git/config*",
        "*.sql*",
        "*.zip*",

        // Common paths
        "*admin/*",
        "*api/*",
        "*bin/*",
        "*cgi-bin/*",
        "*file-manager/*",
        "*login*",          // Comment or change this line if you do use login
        "*register/*",      // Comment or change this line if you do use register
        "*webclient*",

        // PHPUnit
        "*eval-stdin*",
        "*phpunit*",

        // PHP (general)
        "*laravel/*",
        "*lib/*",
        "*phpinfo*",
        "*vendor*",
        "public/*",         // This one does not have a '*' at the start because
                            // it may be used legitimately

        // Vulnerability scanners
        "*agent/service/register*",
        "*hello.world*",
        "*remote/login*",
        "*setup.cgi*",
        "http*",
        "https*",
        "*nope.php*",
        "*shell*",
        "test*",            // This one does not have a '*' at the start because
                            // it may be used legitimately.
        "*unauth*",

        // Wordpress
        "*wlwmanifest*",
        "*wordpress*",
        "*wp*",
        "*xmlrpc*",
    ],
];
