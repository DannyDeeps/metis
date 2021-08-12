<?php namespace Metis\System;

class Util
{
    public static function redirect(string $location)
    {
        $host= 'http://metis.tools';
        switch (ENV)
        {
            case 'development': $host= 'http://dev.metis'; break;
            case 'testing': $host= 'http://test.metis'; break;
        }

        $url= '';
        switch ($location)
        {
            case 'login': $url= '/login'; break;
            case 'dashboard': $url= '/dashboard'; break;
            case 'events': $url= '/events'; break;
        }

        header("Location: {$host}{$url}");
        exit;
    }

    public static function pascalToSnake($input)
    {
        return ltrim(strtolower(preg_replace('/[A-Z]([A-Z](?![a-z]))*/', '_$0', $input)), '_');
    }
}
