<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Request;

class Url
{
    /* Get Base URL */
    public static function getBaseURL()
    {
        return Request::schemeAndHttpHost();
    }

    /* Get URL */
    public static function getURL()
    {
        // Do not append '/' if path is '/' as well
        return  Request::path() === '/' ?
                Request::schemeAndHttpHost() :
                Request::schemeAndHttpHost().'/'.Request::path();
    }
}
