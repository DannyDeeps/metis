<?php namespace Metis\System;

use \Metis\Exceptions\NoticeException;

class Session
{
    public static function get(string $varName)
    {
        return !empty($_SESSION[$varName]) ? $_SESSION[$varName] : null;
    }

    public static function set(string $varName, mixed $value)
    {
        $_SESSION[$varName]= $value;
    }

    public static function addNotice(NoticeException $notice)
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
