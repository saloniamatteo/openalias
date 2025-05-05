<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class BlockRequest
{
    /* Get value from config */
    private static function getConf($value)
    {
        return Config::get("blockrequest.{$value}");
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

    /*
     * Block all requests coming from bad servers
     *
     * This leverages AbuseIPDB's "/check" API endpoint.
     * To use it, make sure you set "ABUSEIPDB_KEY" in your .env.
     * If empty, this will be skipped.
     *
     * NOTE: this does add some overhead, because we need to wait
     * for AbuseIPDB to respond to our query.
     * We try to mitigate this by using a cache.
     *
    */
    public static function handle(Request $request, Closure $next)
    {
        // Get API key
        $key = self::getConf('abuseipdb_key');

        // Key is empty/not set, do not query AbuseIPDB and continue.
        if (empty($key)) {
            return $next($request);
        }

        // Get incoming IP
        $ip = $request->ip();

        // Check if IP is cached
        $cache = self::getCache("br-{$ip}");

        // Check gotten cache response
        // Note: we do not add "break" after return & abort,
        // because they do not fall through.
        switch ($cache) {
            // Found IP, and it is good! Continue.
            case self::getConf('ip_ok'):
                return $next($request);

            // Found IP, and it is bad! Forbid.
            case self::getConf('ip_bad'):
                // Log this action
                Log::info("BlockRequest Middleware: blocked {$ip}");
                abort(403);
        }

        // Query AbuseIPDB, since IP is not cached. Format:
        // Headers:
        //   - Key: API key (retrieve from config)
        //
        // GET parameters:
        //   - ipAddress: IP address to search
        //   - maxAgeInDays: look at the last 90 days
        $query = Http::withHeaders([
            'Key' => $key,
        ])->get('https://api.abuseipdb.com/api/v2/check', [
            'ipAddress' => $ip,
            'maxAgeInDays' => '90',
        ]);

        // If response status is not 200, do not check the IP,
        // and instead continue processing the request.
        // This may happen if we hit the API ratelimit,
        // or if the API key does not work.
        if (! $query->ok()) {
            return $next($request);
        }

        // We're interested only in the "data" array
        $query = $query->json()['data'];

        // Get data from query
        $whitelisted = $query['isWhitelisted'];
        $score = $query['abuseConfidenceScore'];

        // Check if the IP is whitelisted
        // We also respect the "ignore_whitelist" option.
        if (! $whitelisted || ($whitelisted && self::getConf('ignore_whitelist'))) {
            // Bad IP, save to cache, and return 403.
            if ($score >= self::getConf('threshold')) {
                self::setCache("br-{$ip}", self::getConf('ip_bad'));
                // Log this action
                Log::info("BlockRequest Middleware: blocked {$ip}");
                abort(403);
            }
        }

        // IP is fine. Welcome!
        self::setCache("br-{$ip}", self::getConf('ip_ok'));

        return $next($request);
    }
}
