<?php

namespace Metis\System;

class Redirect
{
    public static function to(string $to, array|bool $with= false)
    {
        $host= 'http://metis.tools';
        switch (ENV) {
            case 'development': $host= 'http://dev.metis'; break;
            case 'testing':     $host= 'http://test.metis'; break;
        }

        $url= '';
        switch ($to) {
            case 'login':       $url= '/login'; break;
            case 'dashboard':   $url= '/dashboard'; break;
            case 'events':      $url= '/events'; break;
        }

        $luggage= '';
        if (!empty($with)) {
            $luggage= self::_packLuggage($with);
        }

        header("Location: {$host}{$url}{$luggage}");
        exit;
    }

    private static function _packLuggage(array $with)
    {
        if (is_array($with)) {
            $luggage= [];

            foreach ($with as $item) {
                $luggage[$item]= Request::get($item);
            }

            return http_build_query($luggage);
        }

        return http_build_query(Request::getAll());
    }
}
