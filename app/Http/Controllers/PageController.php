<?php

namespace App\Http\Controllers;

use App\Helpers\DNS;
use App\Helpers\Page;

class PageController
{
    // Load a domain's records
    public function viewRecords($domain)
    {
        // Remove whitespace from the string,
        // and make domain lowercase
        $domain = strtolower(trim($domain));

        // Before matching, try to remove http(s):// from query
        $domain = str_replace(['http://', 'https://'], '', $domain);

        // Domain pattern
        $pattern = "/^(?!\-)(?:(?:[a-zA-Z\d][a-zA-Z\d\-]{0,61})?[a-zA-Z\d]\.){1,126}(?!\d+)[a-zA-Z\d]{1,63}$/";

        // Check if the domain is valid
        if (! empty($domain) && preg_match($pattern, $domain)) {
            // We have a valid domain. Get DNS records
            $records = DNS::getRecords($domain);

            // Check if domain is DNSSEC verified
            $dnssec = DNS::checkDNSSEC($domain);

            // Show data
            return Page::minify('index', [
                'data' => [
                    'domain' => $domain,
                    'records' => $records,
                    'dnssec' => $dnssec,
                ],
            ]);
        }

        return Page::minify('index');
    }

    // Index
    public function index()
    {
        // Load minified index page
        return Page::minify('index');
    }
}
