<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;

class DNS
{
    /* Save query results to cache */
    private static function cache($domain, $value)
    {
        // Results are saved using the domain as key, and "value" is the array
        // Note: we are reusing AbuseIPDB's TTL value (default: 15 min)
        cache(
            ["$domain" => $value],
            now()->addMinutes(Config::get('blocker.cache_ttl')
            ));
    }

    // Check if value is correctly set and, if needed, trim the leading ';',
    // otherwise return the string "Empty", already formatted for HTML output.
    private static function checkValid($obj, $trim = 0)
    {
        return isset($obj[1])
                ? ($trim == 0
                    ? $obj[1]
                    : rtrim($obj[1], ';'))
                : '<em>(Empty)</em>';
    }

    // Get OpenAlias DNS records (TXT: ^oa1)
    public static function getRecords($domain)
    {
        // Check if domain is already cached
        $cache = cache($domain);
        if (! empty($cache)) {
            return $cache;
        }

        // No cache.. get all TXT records from domain
        $records = dns_get_record($domain, DNS_TXT);

        // Results array
        $results = [];

        // Loop over records
        foreach ($records as $record) {
            // We only care about entries that start with "oa1"
            if (str_starts_with($record['txt'], 'oa1')) {
                $results[] = $record['txt'];
            }
        }

        // Cache results
        DNS::cache($domain, $results);

        // Return array
        return $results;
    }

    // Check if a domain is DNSSEC verified
    public static function checkDNSSEC($domain)
    {
        exec('host -t RRSIG '.$domain, $output);

        return (strstr($output[0], 'has RRSIG record')) ? true : false;
    }

    // Retrieve data from a record
    public static function getData($record)
    {
        $data = [];

        // NOTE: per the OpenAlias spec, records that
        // contain ":" instead of "=" are INVALID.
        // Example:
        // recipient_name:John Smith; -> INVALID
        // recipient_name=John Smith; -> Valid
        // However, we must relax these requirements as
        // there may be no match, in situations where
        // this mistake may or may not have been made on purpose.

        // NOTE 2: Invalid records have the content "Empty".

        // Match OA1 type (btc, xmr, ...). This is mandatory.
        preg_match('/oa1:(\w+)/', $record, $matches);
        $data['oa1'] = DNS::checkValid($matches);

        // Match recipient address. This is mandatory.
        // We also remove the trailing ';'
        preg_match('/recipient_address=(\S+);/', $record, $matches);
        $data['recipient_address'] = DNS::checkValid($matches, true);

        // Match recipient name
        // We also remove the trailing ';'
        preg_match('/recipient_name[:=](.*?);/', $record, $matches);
        $data['recipient_name'] = DNS::checkValid($matches, true);

        // Match TX description
        // We also remove the trailing ';'
        preg_match('/tx_description[:=](.*?);/', $record, $matches);
        $data['tx_description'] = DNS::checkValid($matches, true);

        // Match TX amount
        // We also remove the trailing ';'
        preg_match('/tx_amount[:=](.*?);/', $record, $matches);
        $data['tx_amount'] = DNS::checkValid($matches, true);

        return $data;
    }
}
