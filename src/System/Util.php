<?php namespace Metis\System;

class Util
{
    public static function redirect(string $location, string $messageCode= null)
    {
        $host= 'http://metis.tools';
        switch (ENV) {
            case 'development': $host= 'http://dev.metis'; break;
            case 'testing': $host= 'http://test.metis'; break;
        }

        $url= '';
        switch ($location) {
            case 'login': $url= '/login'; break;
            case 'dashboard': $url= '/dashboard'; break;
            case 'ecents': $url= '/events'; break;
        }

        if (!empty($messageCode))
            $url .= '&mc=' . urlencode($messageCode);

        header("Location: $host$url");
        exit;
    }
}
