<?php

namespace App\Http\Controllers;

use App\Helpers\DNS;
use App\Helpers\Page;

class PageController
{
    // Load a domain's records
    public function viewRecords($domain)
    {
        // Check if given string is a URL
        if (DNS::checkDomain($domain)) {
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
