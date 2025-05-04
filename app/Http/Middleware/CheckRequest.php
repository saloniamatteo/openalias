<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;

class CheckRequest
{
    private static $_request;   // Request object to share across functions

    /* Get value from config */
    private static function getConf($value)
    {
        return Config::get("checkrequest.{$value}");
    }

    /* Get value from cache */
    private static function getCache($key)
    {
        return cache($key);
    }

    /* Save value to cache */
    private static function setCache($key, $value)
    {
        cache(
            ["{$key}" => "{$value}"],
            now()->addMinutes(self::getConf('cache_ttl'))
        );
    }

    private static function increaseAttempts()
    {
        // Get incoming IP
        $ip = self::$_request->ip();

        // Check if IP is cached
        $cache = self::getCache("cr-{$ip}");

        // If IP is not inserted in the cache, set attempts to 1,
        // otherwise increase its attempts
        $attempts = $cache == null ? 1 : intval($cache) + 1;

        // Cache attempts
        self::setCache("cr-{$ip}", $attempts);
    }

    /*
     * Send a zip bomb to the client
    */
    private static function sendZipBomb()
    {
        // Increase attempts
        self::increaseAttempts();

        // Available bomb sizes & filenames
        $bombs = [
            "1" => "bomb1.gz",
            "10" => "bomb10.gz",
            "20" => "bomb20.gz",
        ];

        // Assign bombs based on attempts
        $attempts = self::getCache("cr-" . self::$_request->ip());

        if ($attempts <= 2) {
            $bomb = $bombs["1"];
        } else if ($attempts > 2 && $attempts <= 5) {
            $bomb = $bombs["10"];
        } else {
            $bomb = $bombs["20"];
        }

        // Log this action
        Log::info(
            "CheckRequest Middleware: "
            . "Sending zip bomb '$bomb' to " . self::$_request->ip()
            . " ($attempts attempts)"
        );

        // Prepend full path to bomb filename
        $bomb = app_path("Http/Middleware/CheckRequest/$bomb");

        // Set proper headers
        header("Content-Encoding: gzip");
        header("Content-Length: " . filesize($bomb));

        // Turn off output buffering
        if (ob_get_level()) {
            ob_end_clean();
        }

        // Send bomb to client
        readfile($bomb);
    }

    /*
     * Check if request method or path is disallowed.
     * If it is, send the client a zip bomb.
     *
     * Note that this is employed only for
     * those pesky bots & vulnerability scanners.
    */
    public function handle(Request $request, Closure $next)
    {
        $this::$_request = $request;

        // Get disallowed methods
        $methods = self::getConf('methods');

        // Get disallowed paths
        $paths = self::getConf('paths');

        /* Check if request method is disallowed */
        foreach ($methods as $method) {
            if ($request->isMethod($method)) {
                die($this::sendZipBomb());
            }
        }

        /* Check if request path is disallowed */
        foreach ($paths as $path) {
            if ($request->is($path)) {
                die($this::sendZipBomb());
            }
        }

        return $next($request);
    }
}
