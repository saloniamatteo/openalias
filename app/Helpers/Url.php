<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Request;

class Url
{
    /* Get URL */
    public static function getURL()
    {
        // Do not append '/' if path is '/' as well
        return (Request::path() == '/') ?
                Request::schemeAndHttpHost() :
                Request::schemeAndHttpHost().'/'.Request::path();
    }
}
