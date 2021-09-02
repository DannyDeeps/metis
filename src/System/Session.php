<?php

namespace Metis\System;

use \Metis\System\{ Util };
use \Metis\Exceptions\MetisException;

class Session
{
    public static function get(string $varName)
    {
        return Util::sanitise($_SESSION[$varName] ?? null);
    }

    public static function set(string $varName, mixed $value)
    {
        $_SESSION[$varName]= Util::sanitise($value);
    }

    public static function addNotice(MetisException $notice)
    {
        $notices= self::get('metis_exceptions') ?? [];
        $notices[]= $notice;

        self::set('notices', $notices);
    }

    public static function getNotices()
    {
        return self::get('metis_exceptions') ?? [];
    }

    public static function clearNotices()
    {
        self::set('metis_exceptions', []);
    }
}