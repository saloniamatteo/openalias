<?php

namespace App\Http\Controllers;

use App\Helpers\DNS;
use App\Helpers\Page;

class PageController
{
    // Index
    public function index()
    {
        // Load minified index page
        return Page::minify('index');
    }
}
