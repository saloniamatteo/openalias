<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Request;

class Url
{
    /* Get URL */
    public static function getURL()
    {
        return Request::schemeAndHttpHost().'/'.Request::path();
    }
}
