<?php

namespace Metis\System;

use \Metis\System\Util;
use \Metis\Framework\NoticeHandler;

class Session
{
    public static function get(string $varName)
    {
        $var= $_SESSION[$varName] ?? null;
        if (!empty($var)) {
            $var= Util::sanitise($var);
        }

        return $var;
    }

    public static function set(string $varName, mixed $value)
    {
        $_SESSION[$varName]= Util::sanitise($value);
    }

    public static function addNotice(NoticeHandler $notice)
    {
        $notices= self::get('notices') ?? [];
        $notices[]= $notice;

        self::set('notices', $notices);
    }

    public static function getNotices()
    {
        return self::get('notices') ?? [];
    }

    public static function clearNotices()
    {
        self::set('notices', []);
    }
}