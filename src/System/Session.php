<?php namespace Metis\System;

/**
 * undocumented class
 */
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
}
